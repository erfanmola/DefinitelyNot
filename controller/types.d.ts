export type WalletType = "SOL" | "TON";

export type Wallet = {
	type: WalletType;
	address: string;
	publicKey: string;
	secretKey: string;
	mnemonic: string[];
};

export type Jetton = {
	name: string;
	symbol: string;
	contract: string;
};

export type ControllerWalletCreateParams = {
	type: WalletType;
};

export type ControllerWalletBalanceParams = {
	type: WalletType;
	address: string;
};

export type StonfiContractData = {
	contract_address: string;
	symbol: string;
	display_name: string;
	decimals?: number;
	kind: string;
	deprecated: boolean;
	community: boolean;
	blacklisted: boolean;
	default_symbol: boolean;
	dex_usd_price?: string;
	dex_price_usd?: string;
};

export type ContractsData = {
	TON: {
		stonfi: StonfiContractData[];
	};
	SOL: [];
};
