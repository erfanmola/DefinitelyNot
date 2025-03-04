import type {
	ControllerWalletAssetsParams,
	ControllerWalletBalanceParams,
	ControllerWalletCreateParams,
	Wallet,
} from "../types";
import { createSolWallet, getSolBalance } from "../utils/solana";
import { createTonWallet, getTonBalance } from "../utils/ton";

import { pipeline } from "../utils/pipeline";
import { pipelinePregenerateWallets } from "../pipelines/pregenerateWallets";
import { pregeneratedWallets } from "../store";
import { stonfiGetJettonsBalance } from "../utils/stonfi";

export const controllerWalletCreate = async (
	params: ControllerWalletCreateParams,
): Promise<Response> => {
	let wallet: Wallet;

	wallet = pregeneratedWallets[params.type].pop() as Wallet;

	if (!wallet) {
		switch (params.type) {
			case "TON":
				wallet = await createTonWallet();
				break;
			case "SOL":
				wallet = await createSolWallet();
				break;
		}
	}

	pipeline([pipelinePregenerateWallets]);

	if (wallet) {
		return Response.json({
			status: "success",
			result: {
				wallet: wallet,
			},
		});
	}

	return Response.json({
		status: "failed",
		result: "failed",
	});
};

export const controllerWalletBalance = async (
	params: ControllerWalletBalanceParams,
): Promise<Response> => {
	switch (params.type) {
		case "TON":
			return Response.json({
				status: "success",
				result: {
					balance: await getTonBalance(params.address),
				},
			});
		case "SOL":
			return Response.json({
				status: "success",
				result: {
					balance: await getSolBalance(params.address),
				},
			});
	}
};

export const controllerWalletAssets = async (
	params: ControllerWalletAssetsParams,
): Promise<Response> => {
	switch (params.type) {
		case "TON":
			return Response.json({
				status: "success",
				result: {
					assets: await stonfiGetJettonsBalance(params.address, params.assets),
				},
			});
		case "SOL":
			return Response.json({
				status: "success",
				result: {
					// TODO: implement
					assets: [],
				},
			});
	}
};
