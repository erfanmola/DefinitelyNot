import { Address, TonClient, WalletContractV5R1, fromNano } from "@ton/ton";
import { mnemonicNew, mnemonicToWalletKey } from "@ton/crypto";

import type { Wallet } from "../types";
import env from "./env";

const tonClient = new TonClient({
	endpoint:
		env.NETWORK === "mainnet"
			? "https://toncenter.com/api/v2/jsonRPC"
			: "https://testnet.toncenter.com/api/v2/jsonRPC",
});

export const createTonWallet = async (): Promise<Wallet> => {
	const mnemonic = await mnemonicNew();

	const keyPair = await mnemonicToWalletKey(mnemonic);

	const wallet = WalletContractV5R1.create({
		workchain: 0,
		publicKey: keyPair.publicKey,
	});

	const address = wallet.address.toString({ bounceable: false });

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
