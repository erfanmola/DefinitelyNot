import { Address, TonClient, WalletContractV5R1, fromNano } from "@ton/ton";
import env, { isMainNet } from "./env";
import { mnemonicNew, mnemonicToWalletKey } from "@ton/crypto";

import type { Wallet } from "../types";

const tonClient = new TonClient({
	endpoint: isMainNet
		? "https://toncenter.com/api/v2/jsonRPC"
		: "https://testnet.toncenter.com/api/v2/jsonRPC",
	apiKey: isMainNet ? env.TONCENTER_MAINNET_KEY : env.TONCENTER_TESTNET_KEY,
});

// const tonClientV4 = new TonClient4({
// 	endpoint: isMainNet
// 		? "https://mainnet-v4.tonhubapi.com/"
// 		: "https://testnet-v4.tonhubapi.com/",
// });

export const createTonWallet = async (): Promise<Wallet> => {
	const mnemonic = await mnemonicNew();

	const keyPair = await mnemonicToWalletKey(mnemonic);

	const wallet = WalletContractV5R1.create({
		workchain: 0,
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
		return fromNano(await tonClient.getBalance(Address.parse(address)));
	} catch (e) {
		return "-1";
	}
};
