# Trading & Wallets

## 1. Overview  
Welcome to the **Definitely Not** trading and wallet management system—where we give you wallets, but only let you trade on TON (for now).

This section covers:
- **Wallet Management** – How users create, export, and manage wallets.
- **Trading Features** – What works, what’s in progress, and what’s just a placeholder.

## 2. Wallet Management
**We generate wallets so you don’t have to.**

### **What Works?**
✔ **TON & Solana Wallet Generation** – Automatically assigned to users.

✔ **Exporting Wallets** – Because you should always have control over your keys.

✔ **Viewing Balances** – Works perfectly on **TON & SOL** with efficient caching.

### **What’s Not Available?**
⚠ **Solana Trading** – You get a wallet, but that’s it. No swaps, no tracking.

⚠ **Wallet Import** – Planned, but not functional yet.

## 3. Trading Features
This is where we separate the working features from the *"just for show"* ones.

### **What Works?**
✔ **TON Swaps (via Stonfi)** – Swap **TON for Jettons** and vice versa.

✔ **TON & SOL Price Alerts** – Get notified when **TON, SOL, Jettons, or Tokens** hit a target price.

✔ **Live Price Updates (Inline Query)** – Check **real-time prices** without leaving Telegram.

✔ **Instant Swaps** – Execute trades instantly with a single tap.

✔ **Conditional Trades** – Define trade conditions, and when they’re met, the bot **queues a swap** for execution.

### **What’s In Progress?**
⚠ **Copy Trading** – Exists in the UI, but clicking does nothing.

⚠ **Stop Loss / Take Profit / Limit Orders** – Implemented, but depends on the **swap function** (which is untested).

### **What’s Missing Completely?**
❌ **Solana Trading** – No swaps.

## 4. How Trading Works
- **Swaps** – The bot calls Stonfi’s API to execute trades (**still untested, but just one API call away**).
- **Alerts** – The bot constantly monitors **TON, SOL, and Jettons** and notifies users instantly.
- **Instant Trades** – Unlike conditional trades, instant swaps execute immediately.
- **Conditional Trades** – When user-defined conditions are met, a **swap task is queued** and sent to the controller.

## 5. Summary  
- **Wallets?** ✅ Works for both TON & Solana.
- **Trading?** ✅ Perhaps Works on TON, with instant & conditional swaps.
- **Solana Features?** ❌ No Swaps.
- **Price Alerts?** ✅ **Fully functional** (TON, SOL, Jettons, and Tokens).
- **Live Prices?** ✅ Get instant updates via Telegram’s **inline query**.

Next, check out **[Security & Configuration](./configuration.md)** to see how we keep things secure and customizable.
