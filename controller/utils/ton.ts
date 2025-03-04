import { Address, TonClient, WalletContractV5R1, fromNano } from "@ton/ton";
import type { TonClientProvider, Wallet } from "../types";
import env, { isMainNet } from "./env";
import { mnemonicNew, mnemonicToWalletKey } from "@ton/crypto";

import { getHttpEndpoint } from "@orbs-network/ton-access";

const tonClients: TonClientProvider[] = [
	{
		provider: "toncenter",
		client: new TonClient({
			endpoint: isMainNet
				? "https://toncenter.com/api/v2/jsonRPC"
				: "https://testnet.toncenter.com/api/v2/jsonRPC",
			apiKey: isMainNet ? env.TONCENTER_MAINNET_KEY : env.TONCENTER_TESTNET_KEY,
		}),
	},
];

const initializeAdditionalTonClients = async () => {
	try {
		tonClients.push({
			provider: "orbs",
			client: new TonClient({
				endpoint: await getHttpEndpoint({
					network: isMainNet ? "mainnet" : "testnet",
				}),
			}),
		});
	} catch (e) {}
};

const getTonClient = (): TonClientProvider => {
	const client = tonClients.shift();
	if (client) {
		tonClients.push(client);
	}
	return client as TonClientProvider;
};

export const createTonWallet = async (): Promise<Wallet> => {
	const mnemonic = await mnemonicNew();

	const keyPair = await mnemonicToWalletKey(mnemonic);

	const wallet = WalletContractV5R1.create({
		publicKey: keyPair.publicKey,
	});

	const address = wallet.address.toString({
		bounceable: false,
		testOnly: !isMainNet,
	});

	return {
		type: "TON",
		mnemonic: mnemonic,
		publicKey: keyPair.publicKey.toString("hex"),
		secretKey: keyPair.secretKey.toString("hex"),
		address,
	};
};

export const getTonBalance = async (address: string): Promise<string> => {
	try {
		return fromNano(
			await getTonClient().client.getBalance(Address.parse(address)),
		);
	} catch (e) {
		return "-1";
	}
};

initializeAdditionalTonClients();
