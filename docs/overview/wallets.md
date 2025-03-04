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
✔ **Viewing Balances** – Works perfectly on TON & SOL with efficient caching.

### **What’s Not Available?**
⚠ **Solana Trading** – You get a wallet, but that’s it. No swaps, no tracking.
⚠ **Wallet Import** – Planned, but not functional yet.



## 3. Trading Features
This is where we separate the working features from the *"just for show"* ones.

### **What Works?**
✔ **TON Swaps (via Stonfi)** – You can swap TON to Jettons and back.

✔ **TON Price Alerts** – Get notified when TON or Jettons hit a target price.

⚠ **Stop Loss / Take Profit / Limit Order** – Implemented, but functionality relies on doubts.

### **What’s In Progress?**
⚠ **Copy Trading** – Exists in the UI, but clicking does nothing.

### **What’s Missing Completely?**
❌ **Solana Trading** – No swaps, no price tracking, just a placeholder wallet.



## 4. How Trading Works
- **Swaps** – The bot calls Stonfi’s API to execute trades (we assume it works, but haven’t fully tested it).
- **Alerts** – The bot constantly monitors TON’s price and notifies users instantly.
- **Future Plans** – Copy trading, and maybe (just maybe) Solana trading.



## 5. Summary  
- **Wallets?** ✅ Works for both TON & Solana.
- **Trading?** ✅ Only works on TON.
- **Solana Features?** ❌ Just a wallet, nothing else.
- **Price Alerts?** ✅ Actually functional.

Next, check out **[Security & Configuration](../overview/configuration.md)** to see how we keep things secure and customizable.
