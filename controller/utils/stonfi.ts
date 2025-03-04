import { fromNano } from "@ton/core";

export const stonfiGetJettonsBalance = async (
	address: string,
	jettons: string[],
) => {
	return Object.fromEntries(
		(
			await Promise.all(
				jettons.map(
					(jetton) =>
						new Promise((resolve) => {
							try {
								fetch(
									`https://api.ston.fi/v1/wallets/${address}/assets/${jetton}`,
								).then((data) => {
									data
										.json()
										.then((json) => {
											resolve([jetton, fromNano(json.asset.balance)]);
										})
										.catch(() => resolve(null));
								});
							} catch (e) {
								resolve(null);
							}
						}),
				),
			)
		).filter(Boolean) as [string, string][],
	);
};
