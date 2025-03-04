# Security & Configuration  

## 1. Overview  
Security and configuration are essential for running **Definitely Not** efficiently. This section covers:  
- **Security Measures** – How we handle user data, rate limits, and bot protection.  
- **Configuration Options** – All the environment variables and settings you can tweak.  
- **Performance & Caching Settings** – How the bot optimizes performance using connection pools and caching.  

---

## 2. Security Measures  
Not only we **don’t guarantee profitable trades**, we do not guarantee:

### **User Data Protection**  
✔ **Wallet Security** – Wallets are generated and stored in MySQL.

✔ **Rate Limiting** – API calls are limited per user to prevent spam and abuse.

✔ **Database Security** – Uses **MySQL & Redis** with authentication for storing user and transaction data.  

### **Spam & Flood Control**  
✔ **Anti-Flooding Measures** – Prevents excessive requests from users.  

---

## 3. Configuration Options  
You can **customize the bot's behavior** using environment variables and pre-defined settings.

### **Bot Settings**  
| Variable                  | Description                                  |
|---------------------------|----------------------------------------------|
| `BOT_TOKEN`               | Telegram Bot Token (required).              |
| `BOT_HOST`                | Bot server host address.                     |
| `BOT_PORT`                | Port on which the bot runs.                  |
| `BOT_API_SERVER`          | Custom Telegram API server (if applicable).  |
| `BOT_REPORT_ADMIN_ID`     | Admin Telegram ID for bot alerts.            |

---

### **Database Settings**  
| Variable                  | Description                                  |
|---------------------------|----------------------------------------------|
| `MYSQL_DB_USER`           | MySQL database username.                     |
| `MYSQL_DB_PASS`           | MySQL database password.                     |
| `MYSQL_DB_HOST`           | MySQL server host address.                   |
| `MYSQL_DB_NAME`           | MySQL database name.                         |
| `REDIS_HOST`              | Redis server host address.                   |
| `REDIS_PORT`              | Redis server port.                           |
| `REDIS_PASS`              | Redis password (if authentication is used).  |
| `REDIS_DB`                | Redis database index.                        |

---

### **Controller Settings**  
| Variable                  | Description                                  |
|---------------------------|----------------------------------------------|
| `CONTROLLER_HOST`         | Controller backend host address.             |
| `CONTROLLER_PORT`         | Controller backend port.                     |

---

### **General Network Settings**  
| Variable                  | Description                                  |
|---------------------------|----------------------------------------------|
| `NETWORK`                 | Blockchain network (`testnet` or `mainnet`). |
| `TONCENTER_TESTNET_KEY`   | API key for Toncenter testnet.               |
| `TONCENTER_MAINNET_KEY`   | API key for Toncenter mainnet.               |
| `TONCONSOLE_KEY`          | API key for TonConsole.                      |

---

### **Wallet Configuration**  
By default, the bot pre-generates wallets for users. You can configure how many wallets are created in advance.

| Setting                     | Description                                      | Default Value |
|-----------------------------|--------------------------------------------------|--------------|
| `PRE_GENERATED_TON_WALLETS` | Number of pre-generated TON wallets.            | `5`          |
| `PRE_GENERATED_SOL_WALLETS` | Number of pre-generated Solana wallets.         | `5`          |
| `TOTAL_WALLETS_MIN`         | Minimum wallets a user can have.                | `1`          |
| `TOTAL_WALLETS_MAX`         | Maximum wallets a user can have.                | `4`          |

---

## 4. Performance & Caching Settings  
To ensure high performance, **Definitely Not** uses caching and connection pooling.

### **Worker & Reactor Threads**  
| Setting                   | Description                                    | Default Value |
|---------------------------|------------------------------------------------|--------------|
| `PROCESS_WORKER_NUM`      | Number of worker processes for OpenSwoole.    | `4`          |
| `PROCESS_REACTOR_NUM`     | Number of reactor threads for OpenSwoole.     | `4`          |

### **Database Connection Pooling**  
| Setting                         | Description                                | Default Value |
|----------------------------------|--------------------------------------------|--------------|
| `MYSQL_CONNECTION_POOL_SIZE_MAX` | Maximum MySQL connections in the pool.    | `8`          |
| `REDIS_CONNECTION_POOL_SIZE_MAX` | Maximum Redis connections in the pool.    | `8`          |

### **Caching Configuration**  
| Setting                         | Description                                      | Default Value |
|----------------------------------|--------------------------------------------------|--------------|
| `CACHE_TABLE_BALANCE_SIZE`       | Cache size for balance storage.                 | `1024`       |
| `CACHE_TABLE_BALANCE_TIME`       | Cache expiration time for balance (seconds).    | `30`         |
| `CACHE_TABLE_ASSETS_BALANCE_SIZE`| Cache size for asset balance storage.           | `2048`       |
| `CACHE_TABLE_ASSETS_BALANCE_TIME`| Cache expiration time for asset balance (seconds). | `30`         |
| `TABLE_JETTONS_SIZE`             | Maximum number of jettons stored in cache.      | `128`        |
| `TABLE_TOKENS_SIZE`              | Maximum number of tokens stored in cache.       | `128`        |

### **Trade Configuration**  
| Setting                          | Description                                       | Default Value |
|-----------------------------------|---------------------------------------------------|--------------|
| `TRADE_CONDITIONS_PENDING_MAX`    | Maximum pending trade conditions per user.       | `10`         |

---

## 5. Summary  
- **Security?** ✅ We rate-limit users, and restrict API abuse.
- **Customizable?** ✅ Configure network, database, and API settings easily.  
- **Wallet Pre-Generation?** ✅ Yes, set how many wallets are created in advance.  
- **Performance Optimized?** ✅ OpenSwoole workers, connection pooling, and caching ensure efficiency.  
- **Flooding the bot with spam?** ❌ Won’t work, we got that covered.  

Now that you know how to configure and secure the bot, check out **[TON APIs](../overview/ton-apis.md)** to see how it all works behind the scenes!
