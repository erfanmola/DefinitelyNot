import type { ContractsData, Wallet, WalletType } from "./types";

import { isMainNet } from "./utils/env";
import { tonJettons } from "./utils/jettons";

export const pregeneratedWallets: { [key in WalletType]: Wallet[] } = {
	SOL: [],
	TON: [],
};

export const nativeAssetsRate: { [key in WalletType]: number } = {
	SOL: 0,
	TON: 0,
};

export const trackingContracts: { [key in WalletType]: string[] } = {
	SOL: [],
	TON: tonJettons[isMainNet ? "mainnet" : "testnet"].map(
		(item) => item.contract,
	),
};

export const contractsData: ContractsData = {
	SOL: [],
	TON: {
		stonfi: [],
	},
};
