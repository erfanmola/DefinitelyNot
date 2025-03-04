---
# https://vitepress.dev/reference/default-theme-home-page
layout: home

hero:
  name: "Definitely Not"
  text: "Documentations"
  tagline: "Documentations about a bot that is Definitely Not the best trading bot available right now, cause I suck at blockchain, web3 and that kind of stuff."
  actions:
    - theme: brand
      text: Get Started
      link: /overview/introduction
    - theme: alt
      text: Telegram Bot
      link: https://t.me/ItsDefinitelyNotBot

features:
  - title: Multi-Wallet Support
    details: Automatically generates and exports TON & Solana wallets for users.

  - title: TON Swaps (via Stonfi)
    details: Supports swapping TON for Jettons using the Stonfi API.

  - title: Real-Time Price Alerts
    details: Tracks TON and Jettons price and notifies users when their set thresholds are reached.

  - title: High-Performance Bot
    details: Built with PHP (OpenSwoole) & Bun (TypeScript) for speed and efficiency.

  - title: Dynamic API Switching
    details: Uses multiple TON clients (Toncenter, Orb Network) to prevent rate limits.

  - title: WebSocket-Powered Updates
    details: Pushes real-time updates for balances, trades, and price changes.

  - title: Secure & Configurable
    details: Implements rate-limiting, anti-flooding, and customizable bot settings.

  - title: Modular Trading Infrastructure
    details: Designed to support additional trading features like copy trading and TP/SL in future updates.
---

