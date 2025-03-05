# Features

Welcome to the **Definitely Not** feature list – where we tell you what works, what almost works, and what just looks nice in the UI.  

## **Core Functionalities**
Even though we have **zero blockchain expertise**, we somehow managed to put together these key features:

### ✅ **Wallet Management (TON & Solana)**
- Pre-generated wallets for **TON** and **Solana** (because we believe in making your life easy).
- Export your wallet details to make sure you don’t lose your funds (or give them away accidentally).
- No fancy multi-sig or staking—just simple, reliable wallets.  

### ✅ **TON Swaps (Powered by Stonfi)**
- Swap **TON for Jettons** and vice versa.
- We use **Stonfi**, which means *technically* it should work. We just haven't tested it fully because, well… priorities.  
- Don’t worry, it’s all **API calls**, so worst-case scenario, we just debug a few lines.  

### ✅ **TON & SOL Alerts (Price Tracking)**
- Set **real-time alerts** for **TON and SOL price movements**.
- Works seamlessly—one of the few things we actually tested properly.  
- Track **jetton and token prices** as well, so you’re never caught off guard.

### ✅ **Live Price Updates (Telegram Inline Query)**
- Get **real-time prices** of **TON, SOL, jettons, and tokens** directly via **Telegram inline query**.
- No need to leave Telegram—just type and get instant updates.

### ✅ **Instant & Conditional Trades**
- **Instant Swaps** – Buy/sell instantly, no waiting.
- **Conditional Trades** – Define your **price criteria**, and when it hits, we **queue a swap task** and send it to the controller.
- **TON swaps use Stonfi**, but we haven’t fully tested them (yet).
- **SOL swaps? Not happening.**

## **"Features" That Exist, But Don’t Work (Yet)**  
These are technically “in the code,” but don’t expect miracles.  

### ⚠ **Copy Trading** (Coming Soon™)  
- The UI is there. The logic? Not yet.  
- Someday, you’ll be able to **mirror the trades of pros** (or random Telegram users, your call).  

### ⚠ **Wallet Import** (Currently Just a Concept)  
- The button exists. Clicking it does nothing.  
- Eventually, you’ll be able to **import an existing wallet** instead of using the pre-generated ones.
- We default to **V5R1 wallets** because dealing with multiple wallet versions is just pain.

### ⚠ **Solana Trading & Swaps**
- If you thought you could trade Solana tokens here… *we have some bad news for you*.  
- Wallet generation works, but that’s about it.  
- It’s just **vibes** for now.

## **Why Use Definitely Not?**
- **Simple & Fast** – No overcomplicated setups. Just start and trade (as long as it’s on Telegram).
- **Actually Functional Alerts** – Unlike some of our other features, these actually work!  
- **Scalable Infrastructure** – The foundation is built, we just need time to finish the house.  

Check out the **[Architecture](./architecture.md)** section to see how this whole thing actually works (or at least how we claim it does).
