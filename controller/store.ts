import type { AssetsData, Wallet, WalletType } from "./types";

import { isMainNet } from "./utils/env";
import { solTokens } from "./utils/tokens";
import { tonJettons } from "./utils/jettons";

export const pregeneratedWallets: Record<WalletType, Wallet[]> = {
	SOL: [],
	TON: [],
};

export const nativeAssetsRate: Record<WalletType, number> = {
	SOL: 0,
	TON: 0,
};

export const trackingContracts: Record<WalletType, string[]> = {
	SOL: solTokens[isMainNet ? "mainnet" : "testnet"].map((item) => item.address),
	TON: tonJettons[isMainNet ? "mainnet" : "testnet"].map(
		(item) => item.address,
	),
};

export const assetsData: AssetsData = {
	jettons: {
		stonfi: [],
	},
	tokens: {
		raydium: [],
	},
};
