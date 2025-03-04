import type { WSMessageInit, WSMessageRates } from "../types";
import { assetsData, nativeAssetsRate } from "../store";
import env, { isMainNet } from "../utils/env";
import { filterUpdatedObjectsInArray, objectClone } from "../utils/object";

import { sleep } from "bun";
import { tonJettons } from "../utils/jettons";

let ws = new WebSocket(`ws://${env.BOT_HOST}:${env.BOT_PORT}`);
let wsData: WSMessageRates | undefined = undefined;
let initialized = false;

export const wsUpdateHandler = async () => {
	if (ws.readyState !== ws.OPEN) {
		if (ws.readyState === ws.CLOSED) {
			wsData = undefined;
			initialized = false;
			ws.terminate();
			ws = new WebSocket(`ws://${env.BOT_HOST}:${env.BOT_PORT}`);
		}
	} else {
		if (!initialized) {
			wsInitDataHandler();
		}

		if (!wsData) {
			wsData = objectClone({
				type: "rates",
				native: { ...nativeAssetsRate },
				assets: {
					jettons: {
						stonfi: assetsData.jettons.stonfi,
					},
					tokens: {
						raydium: assetsData.tokens.raydium,
					},
				},
			});

			ws.send(JSON.stringify(wsData));
		} else {
			const data: WSMessageRates = {
				type: "rates",
				native: { ...nativeAssetsRate },
				assets: {
					jettons: {
						stonfi: filterUpdatedObjectsInArray(assetsData.jettons.stonfi),
					},
					tokens: {
						raydium: filterUpdatedObjectsInArray(assetsData.tokens.raydium),
					},
				},
			};

			if (JSON.stringify(data) !== JSON.stringify(wsData)) {
				wsData = objectClone(data);
				ws.send(JSON.stringify(wsData));
			}
		}
	}

	await sleep(1e3);
	setTimeout(wsUpdateHandler);
};

const wsInitDataHandler = async () => {
	initialized = true;
	ws.send(
		JSON.stringify({
			type: "init",
			jettons: tonJettons[isMainNet ? "mainnet" : "testnet"],
			tokens: [],
		} as WSMessageInit),
	);
};
