import type { TonClient } from "@ton/ton";
import type { number } from "zod";

export type WalletType = "SOL" | "TON";

export type TonEndpointProviders = "toncenter" | "orbs";

export type TonClientProvider = {
	provider: TonEndpointProviders;
	client: TonClient;
};

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
	address: string;
};

export type Token = {
	name: string;
	symbol: string;
	address: string;
};

export type Asset = (Jetton | Token) & {
	type: WalletType;
};

export type ControllerWalletCreateParams = {
	type: WalletType;
};

export type ControllerWalletBalanceParams = {
	type: WalletType;
	address: string;
};

export type ControllerWalletAssetsParams = {
	type: WalletType;
	address: string;
	assets: string[];
};

export type ControllerAssetsTrackParams = {
	assets: {
		type: WalletType;
		address: string;
	}[];
};

export type ControllerAssetSwapTON = {
	type: "TON";
	swap: {
		offerAddress: string | "TON";
		askAddress: string | "TON";
		offerUnits: number;
		walletCredentials: {
			address: string;
			secret: string;
		};
	};
};

export type ControllerAssetSwapSOL = {
	type: "SOL";
	swap: {
		offerAddress: string | "SOL";
		askAddress: string | "SOL";
		offerUnits: number;
		walletCredentials: {
			address: string;
			secret: string;
		};
	};
};

export type ControllerAssetSwapParams =
	| ControllerAssetSwapTON
	| ControllerAssetSwapSOL;

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
	updated?: boolean;
	balance?: string;
};

export type RaydiumTokenData = Token & {
	price: number;
	updated?: boolean;
};

export type AssetsData = {
	jettons: { stonfi: StonfiContractData[] };
	tokens: { raydium: RaydiumTokenData[] };
};

export type WSMessageInit = {
	type: "init";
	jettons: Jetton[];
	tokens: [];
};

export type WSMessageRates = {
	type: "rates";
	native: Record<WalletType, number>;
	assets: AssetsData;
};
