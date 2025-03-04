import type { RaydiumTokenData, StonfiContractData } from "../types";
import { assetsData, nativeAssetsRate, trackingContracts } from "../store";

import { isMainNet } from "../utils/env";
import { objectEquals } from "../utils/object";
import { solTokens } from "../utils/tokens";

export const raydiumUpdates = async () => {
	try {
		const request = await fetch("https://api.raydium.io/v2/main/price");
		const data = await request.json();

		const wSOLItem = solTokens[isMainNet ? "mainnet" : "testnet"].find(
			(item) => item.symbol === "SOL",
		);

		if (wSOLItem && wSOLItem.address in data) {
			nativeAssetsRate.SOL = data[wSOLItem.address] ?? nativeAssetsRate.SOL;
		}

		for (const [address, price] of Object.entries(data)) {
			const tokenItem = solTokens[isMainNet ? "mainnet" : "testnet"].find(
				(item) => item.address === address,
			);

			if (tokenItem) {
				const currentTokenIndex = assetsData.tokens.raydium.findIndex(
					(item) => item.address === address,
				);

				const token: RaydiumTokenData = {
					address: address,
					name: tokenItem.name,
					symbol: tokenItem.symbol,
					price: Number.parseFloat(price as string),
					updated: false,
				};

				if (currentTokenIndex > -1) {
					if (
						!objectEquals(token, assetsData.tokens.raydium[currentTokenIndex])
					) {
						token.updated = true;
						assetsData.tokens.raydium[currentTokenIndex] = token;
					}
				} else {
					token.updated = true;
					assetsData.tokens.raydium.push(token);
				}
			}
		}
	} catch (e) {
		console.error("unable to fetch");
	}

	setTimeout(raydiumUpdates, 3e3);
};
