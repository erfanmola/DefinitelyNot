import { contractsData, nativeAssetsRate } from "../store";

import env from "../utils/env";
import { sleep } from "bun";

let ws = new WebSocket(`ws://${env.BOT_HOST}:${env.BOT_PORT}`);
let wsData = "";

export const wsUpdateHandler = async () => {
	if (ws.readyState !== ws.OPEN) {
		if (ws.readyState === ws.CLOSED) {
			ws.terminate();
			ws = new WebSocket(`ws://${env.BOT_HOST}:${env.BOT_PORT}`);
			wsData = "";
		}
	} else {
		const data = JSON.stringify({
			rates: {
				...nativeAssetsRate,
			},
			contractsData,
		});

		if (data !== wsData) {
			wsData = data;
			ws.send(wsData);
		}
	}

	await sleep(1e3);
	setTimeout(wsUpdateHandler);
};
