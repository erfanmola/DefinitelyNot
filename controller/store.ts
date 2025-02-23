import type { Wallet, WalletType } from "./types";

export const pregeneratedWallets: { [key in WalletType]: Wallet[] } = {
	SOL: [],
	TON: [],
};
