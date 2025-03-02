import type { AssetsData, Wallet, WalletType } from "./types";

import { isMainNet } from "./utils/env";
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
	SOL: [],
	TON: tonJettons[isMainNet ? "mainnet" : "testnet"].map(
		(item) => item.contract,
	),
};

export const assetsData: AssetsData = {
	jettons: {
		stonfi: [],
	},
	tokens: {
		meteora: null,
	},
};
