import * as bip39 from "bip39";

import {
	Connection,
	Keypair,
	LAMPORTS_PER_SOL,
	PublicKey,
} from "@solana/web3.js";

import type { Wallet } from "../types";
import { derivePath } from "ed25519-hd-key";
import env from "./env";

const connection = new Connection(
	env.NETWORK === "mainnet"
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
		secretKey: Buffer.from(keypair.secretKey).toString("hex"),
		address: keypair.publicKey.toBase58(),
	};
};

export const getSolBalance = async (pubKey: string): Promise<number> => {
	const publicKey = new PublicKey(pubKey);
	const balance = await connection.getBalance(publicKey);
	return balance / LAMPORTS_PER_SOL;
};
