export type WalletType = "SOL" | "TON";

export type Wallet = {
	type: WalletType;
	address: string;
	publicKey: string;
	secretKey: string;
	mnemonic: string[];
};

export type ControllerWalletCreateParams = {
	type: WalletType;
};

export type ControllerWalletBalanceParams = {
	type: WalletType;
	address: string;
};
