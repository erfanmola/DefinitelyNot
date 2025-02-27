import * as bip39 from "bip39";

import {
	Connection,
	Keypair,
	LAMPORTS_PER_SOL,
	PublicKey,
} from "@solana/web3.js";

import type { Wallet } from "../types";
import bs58 from "bs58";
import { derivePath } from "ed25519-hd-key";
import { isMainNet } from "./env";

const connection = new Connection(
	isMainNet
		? "https://api.mainnet-beta.solana.com"
		: "https://api.testnet.solana.com",
);

export const createSolWallet = async (): Promise<Wallet> => {
	const mnemonic = bip39.generateMnemonic();

	const seed = await bip39.mnemonicToSeed(mnemonic);

	const derivationPath = "m/44'/501'/0'/0'";
	const derivedSeed = derivePath(derivationPath, seed.toString("hex")).key;

	const keypair = Keypair.fromSeed(derivedSeed);

	return {
		type: "SOL",
		mnemonic: mnemonic.split(" "),
		publicKey: keypair.publicKey.toBase58(),
		secretKey: bs58.encode(keypair.secretKey),
		address: keypair.publicKey.toBase58(),
	};
};

export const getSolBalance = async (pubKey: string): Promise<number> => {
	try {
		const publicKey = new PublicKey(pubKey);
		const balance = await connection.getBalance(publicKey);
		return balance / LAMPORTS_PER_SOL;
	} catch (e) {
		return -1;
	}
};

export const getSolRate = async (): Promise<number | null> => {
	const request = await fetch(
		"https://api.coingecko.com/api/v3/simple/price?ids=solana&vs_currencies=usd",
	);

	try {
		return (await request.json()).solana.usd as number;
	} catch (e) {}

	return null;
};
