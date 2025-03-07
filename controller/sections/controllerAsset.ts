import type {
	Asset,
	ControllerAssetSwapParams,
	ControllerAssetsTrackParams,
	Jetton,
	Token,
} from "../types";
import { assetsData, trackingContracts } from "../store";

import { sleep } from "bun";
import { swapTonJetton } from "../utils/ton";

export const controllerAssetsTrack = async (
	params: ControllerAssetsTrackParams,
): Promise<Response> => {
	const result = (
		await Promise.all(
			params.assets.map(
				(asset) =>
					new Promise((resolve) => {
						if (!trackingContracts[asset.type].includes(asset.address)) {
							trackingContracts[asset.type].push(asset.address);
						}

						Promise.race([
							sleep(3e3),
							new Promise((res, rej) => {
								let tries = 0;

								const handler = () => {
									switch (asset.type) {
										case "TON": {
											const item = assetsData.jettons.stonfi.find(
												(item) => item.contract_address === asset.address,
											);
											if (item) {
												res({
													type: asset.type,
													name: item.display_name,
													symbol: item.symbol,
													address: item.contract_address,
												} as Asset);
											} else if (tries >= 30) {
												rej(null);
											} else {
												tries++;
												setTimeout(handler, 1e2);
											}
											break;
										}
										case "SOL": {
											// TODO: Implement SOL
											break;
										}
									}
								};

								handler();
							}),
						]).then((value) => {
							if (value) {
								resolve(value);
							} else {
								resolve(null);
							}
						});
					}),
			),
		)
	).filter(Boolean) as Asset[];

	return Response.json({
		status: "success",
		result: {
			jettons: result
				.filter((item: Asset) => item.type === "TON")
				.map(
					(item: Asset) =>
						({
							name: item.name,
							address: item.address,
							symbol: item.symbol,
						}) as Jetton,
				),
			tokens: result
				.filter((item: Asset) => item.type === "SOL")
				.map(
					(item: Asset) =>
						({
							name: item.name,
							address: item.address,
							symbol: item.symbol,
						}) as Token,
				),
		},
	});
};

export const controllerAssetSwap = async (
	params: ControllerAssetSwapParams,
): Promise<Response> => {
	switch (params.type) {
		case "TON":
			return Response.json({
				status: "success",
				result: {
					swap: await swapTonJetton(
						params.swap.offerAddress,
						params.swap.askAddress,
						params.swap.offerUnits,
						params.swap.walletCredentials,
					),
				},
			});
		case "SOL":
			return Response.json({
				status: "success",
				result: {
					// TODO: Implement SOL
					swap: false,
				},
			});
	}
};
