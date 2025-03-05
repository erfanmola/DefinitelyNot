# Architecture

Welcome to the **Definitely Not** architecture breakdown—where we explain how we built a fully functional trading bot without fully testing its swaps.  

This bot is split into **two main components**:  

1. **The Bot (PHP + OpenSwoole)** – Handles Telegram interactions, user commands, storage, and **real-time price tracking**.
2. **The Controller (Bun + TypeScript)** – Manages blockchain operations, WebSockets, API interactions, and **trade execution**.

## **The Bot (PHP + OpenSwoole)**
This is the **brain** of Definitely Not—except, unlike a real brain, it doesn’t know anything about the blockchain. Instead, it focuses on:
- Handling **Telegram messages, inline buttons, and user interactions**.
- Managing **wallet creation, exporting, and displaying balances**.
- Storing data in **MySQL & Redis** to keep things fast.
- Using **WebSockets** to receive updates from the controller.
- Preventing spam with **anti-flooding mechanisms** (because Telegram users love spamming buttons).
- **Processing price alerts & sending real-time updates** for **TON, SOL, jettons, and tokens**.
- **Providing instant price lookups via Telegram's inline query**.
- **Queuing conditional trades** and executing swaps when price conditions are met.

### **Why PHP + OpenSwoole?**
Because **fast**.  
- **OpenSwoole** lets us run an event-driven architecture, meaning we handle thousands of requests without breaking a sweat.  
- **Coroutine-based execution** helps with handling multiple users at once.  
- **Custom concurrency mechanisms** optimize API calls (like price fetching and alerts).
- Also, we just like **writing PHP in a way that makes traditional PHP developers uncomfortable**.  

## **The Controller (Bun + TypeScript)**
The **controller** is where all the **actual blockchain interactions** (or placeholders for them) happen.  
It takes care of:
- **Generating wallets for TON & Solana** (works great!).  
- **Swapping assets on TON** (we assume this works, but again—untested).  
- **Polling smart contracts** and **retrieving jetton data** via Stonfi.  
- **Handling WebSocket connections** to push real-time updates to the bot.  
- **Managing API requests** from the bot, because even PHP needs a backend sometimes.  

### **Why Bun + TypeScript?**
Because **faster than Node.js**, and we like living on the edge.  
- Bun is **blazing fast** (seriously, it makes Node.js look slow).  
- Everything is **non-blocking & async**, so we avoid bottlenecks.  
- **FFI with Rust** for ultra-fast filtering of large jetton data (not actively used yet, but cool to have).
- Plus, we wanted an excuse to play with Bun before everyone else did.  

## **How They Communicate**
The **Bot** and **Controller** talk to each other via:
- **HTTP API Requests** – The bot sends commands to the controller for blockchain-related actions.  
- **WebSockets** – The controller sends real-time updates back to the bot.  
- **Redis & MySQL** – Because you need to store things somewhere.  

## **Why This Setup?**
- **Separation of Concerns** – Bot handles users, controller handles blockchain.  
- **Performance-Optimized** – OpenSwoole & Bun = speed.  
- **Scalable** – We can easily expand to support more chains (if we ever get around to it).  
- **Efficient Price Tracking** – Handles **alerts, real-time updates, and inline queries** without spamming APIs.

Now that you understand how this works, check out **[Trading & Wallets](./wallets.md)** to see what users can actually do!
