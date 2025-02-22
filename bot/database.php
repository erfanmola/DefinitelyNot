<?php

use OpenSwoole\Coroutine;
use OpenSwoole\Coroutine\Channel;

interface ClientFactoryInterface
{
	public static function make($config);
}

class ClientPool
{
	public const DEFAULT_SIZE = 16;

	private $pool;

	private $size;

	private $num;

	private $active;

	private $factory;

	private $config;

	public function __construct($factory, $config, int $size = self::DEFAULT_SIZE, bool $heartbeat = false)
	{
		$this->pool    = new Channel($this->size = $size);
		$this->num     = 0;
		$this->factory = $factory;
		$this->config  = $config;
		if ($heartbeat) {
			$this->heartbeat();
		}
	}

	public function fill(): void
	{
		while ($this->size > $this->num) {
			$this->make();
		}
	}

	public function get(float $timeout = -1)
	{
		if ($this->pool->isEmpty() && $this->num < $this->size) {
			$this->make();
		}

		$this->active++;

		return $this->pool->pop($timeout);
	}

	public function put($connection, $isNew = false): void
	{
		if ($this->pool === null) {
			return;
		}
		if ($connection !== null) {
			$this->pool->push($connection);

			if (!$isNew) {
				$this->active--;
			}
		} else {
			$this->num -= 1;
			$this->make();
		}
	}

	public function close()
	{
		if (!$this->pool) {
			return false;
		}
		while (1) {
			if ($this->active > 0) {
				Coroutine::sleep(1);
				continue;
			}
			if (!$this->pool->isEmpty()) {
				$client = $this->pool->pop();
				$client->close();
			} else {
				break;
			}
		}

		$this->pool->close();
		$this->pool = null;
		$this->num  = 0;
	}

	protected function make()
	{
		$this->num++;
		$client = $this->factory::make($this->config);
		$this->put($client, true);
	}

	protected function heartbeat()
	{
		Coroutine::create(function () {
			while ($this->pool) {
				Coroutine::sleep(30);
				$client = $this->get();
				$client->heartbeat();
				$this->put($client);
			}
		});
	}
}

class ClientProxy
{
	protected object $__object;

	public function __construct($object)
	{
		if (!is_object($object)) {
			throw new TypeError('Non-object given');
		}
		$this->__object = $object;
	}

	public function __getObject(): object
	{
		return $this->__object;
	}

	public function __get(string $name)
	{
		return $this->__object->{$name};
	}

	public function __set(string $name, $value): void
	{
		$this->__object->{$name} = $value;
	}

	public function __isset($name): bool
	{
		return isset($this->__object->{$name});
	}

	public function __unset(string $name): void
	{
		unset($this->__object->{$name});
	}

	public function __call(string $name, array $arguments)
	{
		return $this->__object->{$name}(...$arguments);
	}

	public function __invoke(...$arguments)
	{
		$object = $this->__object;
		return $object(...$arguments);
	}

	public function __clone()
	{
		throw new Error('Trying to clone an uncloneable object proxy object');
	}
}

final class MysqliClientFactory implements ClientFactoryInterface
{
	public static function make($config)
	{
		return new MysqliClient($config);
	}
}

class MysqliConfig
{
	/** @var string */
	protected $host = '127.0.0.1';

	/** @var int */
	protected $port = 3306;

	/** @var string|null */
	protected $unixSocket = '';

	/** @var string */
	protected $dbname = 'test';

	/** @var string */
	protected $charset = 'utf8mb4';

	/** @var string */
	protected $username = 'root';

	/** @var string */
	protected $password = 'root';

	/** @var array */
	protected $options = [];

	public function getHost(): string
	{
		return $this->host;
	}

	public function withHost($host): self
	{
		$this->host = $host;
		return $this;
	}

	public function getPort(): int
	{
		return $this->port;
	}

	public function getUnixSocket(): string
	{
		return $this->unixSocket;
	}

	public function withUnixSocket(?string $unixSocket): self
	{
		$this->unixSocket = $unixSocket;
		return $this;
	}

	public function withPort(int $port): self
	{
		$this->port = $port;
		return $this;
	}

	public function getDbname(): string
	{
		return $this->dbname;
	}

	public function withDbname(string $dbname): self
	{
		$this->dbname = $dbname;
		return $this;
	}

	public function getCharset(): string
	{
		return $this->charset;
	}

	public function withCharset(string $charset): self
	{
		$this->charset = $charset;
		return $this;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function withUsername(string $username): self
	{
		$this->username = $username;
		return $this;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function withPassword(string $password): self
	{
		$this->password = $password;
		return $this;
	}

	public function getOptions(): array
	{
		return $this->options;
	}

	public function withOptions(array $options): self
	{
		$this->options = $options;
		return $this;
	}
}

class MysqliClient extends ClientProxy
{
	public const IO_METHOD_REGEX = '/^autocommit|begin_transaction|change_user|close|commit|kill|multi_query|ping|prepare|query|real_connect|real_query|reap_async_query|refresh|release_savepoint|rollback|savepoint|select_db|send_query|set_charset|ssl_set$/i';

	public const IO_ERRORS = [
		2002, // MYSQLND_CR_CONNECTION_ERROR
		2006, // MYSQLND_CR_SERVER_GONE_ERROR
		2013, // MYSQLND_CR_SERVER_LOST
	];

	/** @var mysqli */
	protected object $__object;

	/** @var string */
	protected $charsetContext;

	/** @var array|null */
	protected $setOptContext;

	/** @var array|null */
	protected $changeUserContext;

	/** @var callable */
	protected $constructor;

	/** @var int */
	protected $round = 0;

	protected $config;

	public function __construct(MysqliConfig $config)
	{
		$this->config = $config;
		$this->makeClient();
		return $this;
	}

	public function __call(string $name, array $arguments)
	{
		for ($n = 3; $n--;) {
			$ret = @$this->__object->{$name}(...$arguments);
			if ($ret === false) {
				/* non-IO method */
				if (!preg_match(static::IO_METHOD_REGEX, $name)) {
					break;
				}
				/* no more chances or non-IO failures */
				if (!in_array($this->__object->errno, static::IO_ERRORS, true) || ($n === 0)) {
					throw new Exception($this->__object->error, $this->__object->errno);
				}
				$this->reconnect();
				continue;
			}
			if (strcasecmp($name, 'prepare') === 0) {
				$ret = new MysqliStatementProxy($ret, $arguments[0], $this);
			} elseif (strcasecmp($name, 'stmt_init') === 0) {
				$ret = new MysqliStatementProxy($ret, null, $this);
			}
			break;
		}
		/* @noinspection PhpUndefinedVariableInspection */
		return $ret;
	}

	public function getRound(): int
	{
		return $this->round;
	}

	public function reconnect(): void
	{
		$this->makeClient();
		$this->round++;
		/* restore context */
		if ($this->charsetContext) {
			$this->__object->set_charset($this->charsetContext);
		}
		if ($this->setOptContext) {
			foreach ($this->setOptContext as $opt => $val) {
				$this->__object->set_opt($opt, $val);
			}
		}
		if ($this->changeUserContext) {
			$this->__object->change_user(...$this->changeUserContext);
		}
	}

	public function heartbeat(): void
	{
		$this->__object->query('SELECT 1');
	}

	public function options(int $option, $value): bool
	{
		$this->setOptContext[$option] = $value;
		return $this->__object->options($option, $value);
	}

	public function set_opt(int $option, $value): bool
	{
		return $this->options($option, $value);
	}

	public function set_charset(string $charset): bool
	{
		$this->charsetContext = $charset;
		return $this->__object->set_charset($charset);
	}

	public function change_user(string $user, string $password, string $database): bool
	{
		$this->changeUserContext = [$user, $password, $database];
		return $this->__object->change_user($user, $password, $database);
	}

	protected function makeClient()
	{
		$client = new mysqli();
		foreach ($this->config->getOptions() as $option => $value) {
			$client->set_opt($option, $value);
		}
		$client->real_connect(
			$this->config->getHost(),
			$this->config->getUsername(),
			$this->config->getPassword(),
			$this->config->getDbname(),
			$this->config->getPort(),
			$this->config->getUnixSocket()
		);
		if ($client->connect_errno) {
			throw new Exception($client->connect_error, $client->connect_errno);
		}
		$this->__object = $client;
	}
}

class MysqliStatementProxy extends ClientProxy
{
	public const IO_METHOD_REGEX = '/^close|execute|fetch|prepare$/i';

	/** @var mysqli_stmt */
	protected object $__object;

	/** @var string|null */
	protected $queryString;

	/** @var array|null */
	protected $attrSetContext;

	/** @var array|null */
	protected $bindParamContext;

	/** @var array|null */
	protected $bindResultContext;

	/** @var Mysqli|MysqliClient */
	protected $parent;

	/** @var int */
	protected $parentRound;

	public function __construct(mysqli_stmt $object, ?string $queryString, MysqliClient $parent)
	{
		parent::__construct($object);
		$this->queryString = $queryString;
		$this->parent      = $parent;
		$this->parentRound = $parent->getRound();
	}

	public function __call(string $name, array $arguments)
	{
		for ($n = 3; $n--;) {
			$ret = @$this->__object->{$name}(...$arguments);
			if ($ret === false) {
				/* non-IO method */
				if (!preg_match(static::IO_METHOD_REGEX, $name)) {
					break;
				}
				/* no more chances or non-IO failures or in transaction */
				if (!in_array($this->__object->errno, $this->parent::IO_ERRORS, true) || ($n === 0)) {
					throw new Exception($this->__object->error, $this->__object->errno);
				}
				if ($this->parent->getRound() === $this->parentRound) {
					/* if not equal, parent has reconnected */
					$this->parent->reconnect();
				}
				$parent         = $this->parent->__getObject();
				$this->__object = $this->queryString ? @$parent->prepare($this->queryString) : @$parent->stmt_init();
				if ($this->__object === false) {
					throw new Exception($parent->error, $parent->errno);
				}
				if ($this->bindParamContext) {
					$this->__object->bind_param($this->bindParamContext[0], ...$this->bindParamContext[1]);
				}
				if ($this->bindResultContext) {
					$this->__object->bind_result($this->bindResultContext);
				}
				if ($this->attrSetContext) {
					foreach ($this->attrSetContext as $attr => $value) {
						$this->__object->attr_set($attr, $value);
					}
				}
				continue;
			}
			if (strcasecmp($name, 'prepare') === 0) {
				$this->queryString = $arguments[0];
			}
			break;
		}
		/* @noinspection PhpUndefinedVariableInspection */
		return $ret;
	}

	public function attr_set($attr, $mode): bool
	{
		$this->attrSetContext[$attr] = $mode;
		return $this->__object->attr_set($attr, $mode);
	}

	public function bind_param($types, &...$arguments): bool
	{
		$this->bindParamContext = [$types, $arguments];
		return $this->__object->bind_param($types, ...$arguments);
	}

	public function bind_result(&...$arguments): bool
	{
		$this->bindResultContext = $arguments;
		return $this->__object->bind_result(...$arguments);
	}
}

final class RedisClientFactory implements ClientFactoryInterface
{
	public static function make($config)
	{
		$redis     = new Redis();
		$arguments = [
			$config->getHost(),
			$config->getPort(),
		];
		if ($config->getTimeout() !== 0.0) {
			$arguments[] = $config->getTimeout();
		}
		if ($config->getRetryInterval() !== 0) {
			/* reserved should always be NULL */
			$arguments[] = null;
			$arguments[] = $config->getRetryInterval();
		}
		if ($config->getReadTimeout() !== 0.0) {
			$arguments[] = $config->getReadTimeout();
		}
		$redis->connect(...$arguments);
		if ($config->getAuth()) {
			$redis->auth($config->getAuth());
		}
		if ($config->getDbIndex() !== 0) {
			$redis->select($config->getDbIndex());
		}
		return $redis;
	}
}

class RedisConfig
{
	/** @var string */
	protected $host = '127.0.0.1';

	/** @var int */
	protected $port = 6379;

	/** @var float */
	protected $timeout = 0.0;

	/** @var string */
	protected $reserved = '';

	/** @var int */
	protected $retry_interval = 0;

	/** @var float */
	protected $read_timeout = 0.0;

	/** @var string */
	protected $auth = '';

	/** @var int */
	protected $dbIndex = 0;

	public function getHost()
	{
		return $this->host;
	}

	public function withHost($host): self
	{
		$this->host = $host;
		return $this;
	}

	public function getPort(): int
	{
		return $this->port;
	}

	public function withPort(int $port): self
	{
		$this->port = $port;
		return $this;
	}

	public function getTimeout(): float
	{
		return $this->timeout;
	}

	public function withTimeout(float $timeout): self
	{
		$this->timeout = $timeout;
		return $this;
	}

	public function getReserved(): string
	{
		return $this->reserved;
	}

	public function withReserved(string $reserved): self
	{
		$this->reserved = $reserved;
		return $this;
	}

	public function getRetryInterval(): int
	{
		return $this->retry_interval;
	}

	public function withRetryInterval(int $retry_interval): self
	{
		$this->retry_interval = $retry_interval;
		return $this;
	}

	public function getReadTimeout(): float
	{
		return $this->read_timeout;
	}

	public function withReadTimeout(float $read_timeout): self
	{
		$this->read_timeout = $read_timeout;
		return $this;
	}

	public function getAuth(): string
	{
		return $this->auth;
	}

	public function withAuth(string $auth): self
	{
		$this->auth = $auth;
		return $this;
	}

	public function getDbIndex(): int
	{
		return $this->dbIndex;
	}

	public function withDbIndex(int $dbIndex): self
	{
		$this->dbIndex = $dbIndex;
		return $this;
	}
}

class ConnectionPoolManager
{
	private static ?ClientPool $mysqliPool = null;
	private static ?ClientPool $redisPool = null;

	private static function initializeMySQLiPool()
	{
		if (self::$mysqliPool === null) {
			$mysqliConfig = (new MySQLiConfig())
				->withHost($_ENV['MYSQL_DB_HOST'])
				->withUsername($_ENV['MYSQL_DB_USER'])
				->withPassword($_ENV['MYSQL_DB_PASS'])
				->withDbname($_ENV['MYSQL_DB_NAME']);

			self::$mysqliPool = new ClientPool(MySQLiClientFactory::class, $mysqliConfig, (int)(config['MYSQL_CONNECTION_POOL_SIZE_MAX'] ?? 8), true);
		}
	}

	private static function initializeRedisPool()
	{
		if (self::$redisPool === null) {
			$redisConfig = (new RedisConfig())
				->withHost($_ENV['REDIS_HOST'])
				->withPort((int)($_ENV['REDIS_PORT']))
				->withAuth($_ENV['REDIS_PASS'] ?? null)
				->withDbIndex((int)($_ENV['REDIS_DB'] ?? 0));

			self::$redisPool = new ClientPool(RedisClientFactory::class, $redisConfig, (int)(config['REDIS_CONNECTION_POOL_SIZE_MAX'] ?? 8), false);
		}
	}

	public static function getMySQLiConnection()
	{
		if (!self::$mysqliPool) {
			self::initializeMySQLiPool();
		}
		return self::$mysqliPool->get();
	}

	public static function releaseMySQLiConnection($connection)
	{
		if (self::$mysqliPool) {
			self::$mysqliPool->put($connection);
		}
	}

	public static function getRedisConnection()
	{
		if (!self::$redisPool) {
			self::initializeRedisPool();
		}
		return self::$redisPool->get();
	}

	public static function releaseRedisConnection($connection)
	{
		if (self::$redisPool) {
			self::$redisPool->put($connection);
		}
	}
}
