# Database Schema  

## 1. Overview  
The **Definitely Not** trading bot stores user data, alerts, wallets, and trade conditions in a **MySQL database**.  
This section provides a detailed breakdown of each table, its structure, and its relationships.

---

## 2. Database Tables  

### **1. `users` Table**  
Stores user information, including their Telegram details and language preferences.  

| Column       | Type             | Description                                      |
|-------------|----------------|--------------------------------------------------|
| `id`        | `int(11)`       | Primary key (Auto Increment).                    |
| `user_id`   | `bigint(20)`    | Unique Telegram user ID.                         |
| `first_name`| `varchar(64)`   | User's first name.                              |
| `last_name` | `varchar(64)`   | User's last name (nullable).                     |
| `username`  | `varchar(32)`   | Telegram username (nullable).                    |
| `locale`    | `varchar(6)`    | User's preferred language (default: `'en'`).    |
| `created_at`| `timestamp`     | Timestamp when the user was added.               |
| `updated_at`| `timestamp`     | Timestamp of the last update.                    |

**Indexes:**
- `PRIMARY KEY (id)`
- `UNIQUE KEY (user_id)`

---

### **2. `wallets` Table**  
Stores blockchain wallets associated with users.  

| Column       | Type             | Description                                      |
|-------------|----------------|--------------------------------------------------|
| `id`        | `int(11)`       | Primary key (Auto Increment).                    |
| `user_id`   | `bigint(20)`    | User ID (nullable, links to `users.user_id`).    |
| `type`      | `varchar(3)`    | Blockchain type (`TON` or `SOL`).                |
| `address`   | `varchar(128)`  | Unique wallet address.                           |
| `public_key`| `varchar(128)`  | Wallet public key.                               |
| `secret_key`| `varchar(128)`  | Wallet secret key.                               |
| `mnemonic`  | `text`          | Wallet mnemonic (stored as JSON array).         |
| `balance`   | `double`        | Current balance (default: `0`).                  |

**Indexes:**
- `PRIMARY KEY (id)`
- `UNIQUE KEY (address)`
- `INDEX (type)`
- `INDEX (user_id)`

---

### **3. `alerts` Table**  
Stores **price alerts** for users on different assets.  

| Column       | Type             | Description                                      |
|-------------|----------------|--------------------------------------------------|
| `id`        | `int(11)`       | Primary key (Auto Increment).                    |
| `user_id`   | `bigint(20)`    | User ID (links to `users.user_id`).              |
| `type`      | `tinyint(4)`    | Alert type (e.g., `1 = increase`, `2 = decrease`). |
| `price`     | `double`        | Alert price threshold.                          |
| `blockchain`| `varchar(3)`    | Blockchain (`TON` or `SOL`).                     |
| `asset`     | `varchar(128)`  | Asset name (TON, SOL, Jettons, Tokens).         |
| `status`    | `tinyint(4)`    | Alert status (`0 = pending`, `1 = triggered`).  |

**Indexes:**
- `PRIMARY KEY (id)`
- `INDEX (user_id)`

---

### **4. `trade_conditions` Table**  
Stores user-defined **trade conditions** that trigger automated swaps.  

| Column       | Type             | Description                                      |
|-------------|----------------|--------------------------------------------------|
| `id`        | `int(11)`       | Primary key (Auto Increment).                    |
| `user_id`   | `bigint(20)`    | User ID (links to `users.user_id`).              |
| `wallet_id` | `int(11)`       | Wallet ID (links to `wallets.id`).               |
| `type`      | `tinyint(4)`    | Trade type (`1 = buy`, `2 = sell`).             |
| `price`     | `double`        | Price condition for trade execution.           |
| `amount`    | `double`        | Amount of asset to trade.                       |
| `blockchain`| `varchar(3)`    | Blockchain (`TON` or `SOL`).                     |
| `asset`     | `varchar(128)`  | Asset name (Jettons, Tokens, etc.).             |
| `status`    | `tinyint(4)`    | Condition status (`0 = pending`, `1 = executed`). |

**Indexes:**
- `PRIMARY KEY (id)`
- `INDEX (user_id)`
- `INDEX (wallet_id)`

**Foreign Keys:**
- `user_id` → `users.user_id`
- `wallet_id` → `wallets.id`

---

## 3. Table Relationships  

```plaintext
(users) 1 ───> * (wallets)
(users) 1 ───> * (alerts)
(users) 1 ───> * (trade_conditions)
(wallets) 1 ───> * (trade_conditions)
