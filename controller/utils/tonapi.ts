import env from "./env";
import { sleep } from "bun";

export const tonAPISleep = async () => {
	await sleep(1e3);
};

const tonAPIRequest = async (
	path: string,
	method: "GET" | "POST" = "GET",
	params: any = null,
) => {
	try {
		const request = await fetch(`https://tonapi.io${path}`, {
			method: method,
			body: params ? JSON.stringify(params) : undefined,
			headers: {
				Accept: "Application/JSON",
				Authorization: `Bearer ${env.TONCONSOLE_KEY}`,
			},
		});

		return await request.json();
	} catch (e) {
		return null;
	}
};

export const tonAPINativePriceUpdate = async () => {
	return (
		(await tonAPIRequest("/v2/rates?tokens=ton&currencies=usd"))?.rates?.TON
			?.prices?.USD ?? null
	);
};
