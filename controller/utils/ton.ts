import {
	Address,
	TonClient,
	WalletContractV5R1,
	fromNano,
	toNano,
	type OpenedContract,
} from "@ton/ton";
import type { TonClientProvider, Wallet } from "../types";
import env, { isMainNet } from "./env";
import { mnemonicNew, mnemonicToWalletKey } from "@ton/crypto";

import { DEX, dexFactory, pTON } from "@ston-fi/sdk";
import { StonApiClient } from "@ston-fi/api";
import { getHttpEndpoint } from "@orbs-network/ton-access";
import nacl from "tweetnacl";

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

export const getTonClient = (): TonClientProvider => {
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

export const swapTonJetton = async (
	offerAddress: string | "TON",
	askAddress: string | "TON",
	offerUnits: number,
	walletCredentials: {
		address: string;
		secret: string;
	},
) => {
	const stonApiClient = new StonApiClient();
	const tonClient = getTonClient().client;
	const router = tonClient.open(new DEX.v1.Router());
	const routerInfo = await stonApiClient.getRouter(router.address.toString());

	try {
		const secretKey = Buffer.from(walletCredentials.secret, "hex");
		const keyPair = nacl.sign.keyPair.fromSeed(secretKey.subarray(0, 32));

		const wallet = WalletContractV5R1.create({
			publicKey: Buffer.from(keyPair.publicKey),
			workchain: 0,
		});

		const walletContract = tonClient.open(
			wallet,
		) as OpenedContract<WalletContractV5R1>;

		const swap = await stonApiClient.simulateSwap({
			askAddress:
				askAddress === "TON" ? routerInfo.ptonMasterAddress : askAddress,
			offerAddress:
				offerAddress === "TON" ? routerInfo.ptonMasterAddress : offerAddress,
			offerUnits: offerUnits.toString(),
			slippageTolerance: "0.01",
		});

		if (offerAddress === "TON") {
			await router.sendSwapTonToJetton(walletContract.sender(secretKey), {
				userWalletAddress: wallet.address,
				offerAmount: toNano(swap.offerUnits),
				minAskAmount: swap.minAskUnits,
				askJettonAddress: swap.askAddress,
				proxyTon: new pTON.v1(),
			});
		} else if (askAddress === "TON") {
			await router.sendSwapJettonToTon(walletContract.sender(secretKey), {
				userWalletAddress: wallet.address,
				offerAmount: toNano(swap.offerUnits),
				minAskAmount: swap.minAskUnits,
				proxyTon: new pTON.v1(),
				offerJettonAddress: swap.offerAddress,
			});
		} else {
			await router.sendSwapJettonToJetton(walletContract.sender(secretKey), {
				userWalletAddress: wallet.address,
				offerJettonAddress: swap.offerAddress,
				offerAmount: toNano(swap.offerUnits),
				askJettonAddress: swap.askAddress,
				minAskAmount: swap.minAskUnits,
			});
		}

		return true;
	} catch (error) {
		// console.error("Error during swapJettonToJetton:", error);
	}

	return false;
};

initializeAdditionalTonClients();
