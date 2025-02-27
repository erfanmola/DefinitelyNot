import {
	controllerWalletBalance,
	controllerWalletCreate,
} from "./sections/controllerWallet";

import env from "./utils/env";
import { pipeline } from "./utils/pipeline";
import { pipelinePregenerateWallets } from "./pipelines/pregenerateWallets";
import { pipelineStonfiUpdateHandler } from "./pipelines/stonfiUpdateHandler";
import { pipelineTONUpdateHandler } from "./pipelines/tonUpdateHandler";
import { pipelineWSUpdateHandler } from "./pipelines/wsUpdateHandler";

const server = Bun.serve({
	hostname: env.CONTROLLER_HOST,
	port: env.CONTROLLER_PORT,
	async fetch(request) {
		const url = new URL(request.url);
		let body: any;

		try {
			body = await request.json();
		} catch (e) {}

		switch ([request.method, url.pathname].join("|")) {
			case ["POST", "/wallet/create"].join("|"):
				return await controllerWalletCreate(body);
			case ["POST", "/wallet/balance"].join("|"):
				return await controllerWalletBalance(body);
		}

		return Response.json({
			status: "failed",
			result: "Nothing to do",
		});
	},
});

pipeline([
	pipelineTONUpdateHandler,
	pipelineWSUpdateHandler,
	pipelineStonfiUpdateHandler,
	pipelinePregenerateWallets,
]);

console.log(
	`Started serving at ${[env.CONTROLLER_HOST, env.CONTROLLER_PORT].join(":")}`,
);
