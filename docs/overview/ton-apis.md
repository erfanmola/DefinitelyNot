# TON APIs Used  

## 1. Overview  
**Definitely Not** relies on multiple TON API providers to ensure smooth operation and prevent rate limits. Instead of relying on a single provider, we **dynamically switch between different TON clients** from various providers for reliability.  

We use a combination of:  
- **`tonapi.io`** – For real-time TON price retrieval.  
- **`toncenter` & `Orb Network`** – Used with multiple `TonClient` instances to distribute requests.  
- **`Stonfi`** – For jetton prices, balances, and swaps.  



## 2. TON Client Providers  
Since different APIs have rate limits, we use **multiple instances** of `TonClient` from:  
- **Orb Network**  
- **Toncenter**  

When one provider **reaches its rate limit**, the bot **automatically switches** to another available instance, ensuring continuous access to blockchain data.



## 3. Stonfi API Usage  
We rely on **Stonfi** for various trading and jetton-related operations.

### **Jetton Prices**  
- Retrieves **real-time jetton prices** for swaps and alerts.  

### **User Jetton Balances**  
- Fetches **balances of jettons** held by a user.  

### **Swaps**  
- Executes **TON <> Jetton swaps** using Stonfi’s swap API.  



## 4. TonAPI Usage  
We use **TonAPI** specifically for:  
- Fetching the **current TON price** (used in alerts and UI).  

TonAPI provides a **reliable price feed**, ensuring accurate notifications and tracking.



## 5. Summary  
- **Multiple `TonClient` instances** prevent rate limits.  
- **Stonfi** handles **jetton prices, balances, and swaps**.  
- **TonAPI** provides **TON price data**.  
- **Toncenter & Orb Network** are used for blockchain interactions.  

