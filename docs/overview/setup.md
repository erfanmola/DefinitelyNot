# Setup Guide  

## 1. Overview  
Setting up **Definitely Not** isn’t too complicated—unless you’re dealing with **OpenSwoole**, in which case, good luck. Due to time constraints for the contest deadline, this guide is **not fully detailed**, but it should give you a general idea of what’s needed.  

## 2. Requirements  

### **1. Controller (Bun + TypeScript)**
✅ Install [Bun](https://bun.sh/) (it’s **faster than Node.js**).  
✅ Run the controller with:  
```sh
bun install
bun run index.ts
```

### **2. Bot (PHP + OpenSwoole)**
⚠️ **This requires OpenSwoole**—if you’re not familiar with it, you **might need an expert** to install and configure it properly.  

#### **Steps:**  
1. Install PHP **8.2+**  
2. Install **OpenSwoole** (requires compilation)  
3. Install **MySQL & Redis**  
4. Clone the bot repo, set up dependencies, and run  

⚠️ **Setting up OpenSwoole with necessary hooks is tricky.** If you run into issues, you **might need help from someone experienced in PHP server environments.**  

## 3. Database Setup (MySQL)  
- Create a MySQL database (`DefinitelyNot`).  
- Import the database schema (see **[Database Schema](./database.md)**).  
- Ensure **MySQL & Redis are running** before launching the bot.  

## 4. Environment Variables  
Before running the bot, make sure to configure the **`.env` file** with the correct values:  

### **Bot Configuration**
```sh
BOT_TOKEN=your_telegram_bot_token
BOT_HOST=your_host
BOT_PORT=your_port
BOT_API_SERVER=your_api_server
BOT_REPORT_ADMIN_ID=your_admin_id
RATES_CHANNEL_USERNAME=your_channel_username
```

### **Database Configuration**
```sh
MYSQL_DB_USER=your_mysql_user
MYSQL_DB_PASS=your_mysql_password
MYSQL_DB_HOST=your_mysql_host
MYSQL_DB_NAME=DefinitelyNot

REDIS_HOST=your_redis_host
REDIS_PORT=your_redis_port
REDIS_PASS=your_redis_password
REDIS_DB=your_redis_db
```

### **Controller Configuration**
```sh
CONTROLLER_HOST=your_controller_host
CONTROLLER_PORT=your_controller_port
```

### **Network Configuration**
```sh
NETWORK=mainnet # testnet | mainnet
TONCENTER_TESTNET_KEY=your_testnet_key
TONCENTER_MAINNET_KEY=your_mainnet_key
TONCONSOLE_KEY=your_tonconsole_key
```
Don't use testnet, it's like a deseret.

## 5. Running the Bot  
Once everything is set up, start the bot with:  
```sh
php run.php
```
Make sure **OpenSwoole is running properly** before attempting to start the bot.  

## 6. Need Help?  
If you run into **setup issues**, contact **[@Eyfan](https://t.me/Eyfan) on Telegram**.