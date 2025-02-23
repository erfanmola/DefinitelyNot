import { config } from "../config";
import { createSolWallet } from "../utils/solana";
import { createTonWallet } from "../utils/ton";
import { pregeneratedWallets } from "../store";

export const pipelinePregenerateWallets = async () => {
	for (
		let i = pregeneratedWallets.TON.length;
		i <= config.PRE_GENERATED_TON_WALLETS;
		i++
	) {
		pregeneratedWallets.TON.push(await createTonWallet());
	}

	for (
		let i = pregeneratedWallets.SOL.length;
		i <= config.PRE_GENERATED_SOL_WALLETS;
		i++
	) {
		pregeneratedWallets.SOL.push(await createSolWallet());
	}
};
