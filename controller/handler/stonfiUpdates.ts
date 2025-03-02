import { assetsData, trackingContracts } from "../store";

import type { StonfiContractData } from "../types";
import { objectEquals } from "../utils/object";

export const stonfiUpdates = async () => {
	const fetchedContracts = (
		await Promise.all(
			trackingContracts.TON.map(
				(address) =>
					new Promise((resolve, reject) => {
						try {
							fetch(`https://api.ston.fi/v1/assets/${address}`).then((data) => {
								data.json().then(resolve);
							});
						} catch (e) {
							reject(null);
						}
					}),
			),
		)
	)
		.filter(Boolean)
		.map((item: any) => item.asset);

	for (const contractFull of fetchedContracts) {
		const currentContractIndex = assetsData.jettons.stonfi.findIndex(
			(item) => item.contract_address === contractFull.contract_address,
		);

		const contract: StonfiContractData = {
			blacklisted: contractFull.blacklisted,
			community: contractFull.community,
			contract_address: contractFull.contract_address,
			default_symbol: contractFull.default_symbol,
			deprecated: contractFull.deprecated,
			display_name: contractFull.display_name,
			kind: contractFull.kind,
			symbol: contractFull.symbol,
			decimals: contractFull.decimals,
			dex_price_usd: contractFull.dex_price_usd,
			dex_usd_price: contractFull.dex_usd_price,
			updated: false,
		};

		if (currentContractIndex > -1) {
			if (
				!objectEquals(contract, assetsData.jettons.stonfi[currentContractIndex])
			) {
				contract.updated = true;
				assetsData.jettons.stonfi[currentContractIndex] = contract;
			}
		} else {
			contract.updated = true;
			assetsData.jettons.stonfi.push(contract);
		}
	}

	setTimeout(stonfiUpdates, 1e3);
};

export const stonfiUpdatesFFI = async () => {
	const worker = new Worker(
		`${__dirname}/../workers/fetchStonfiAssetsFilteredFFI.ts`,
	);

	worker.onmessage = (event) => {
		assetsData.jettons.stonfi = event.data;
	};

	const handler = () => {
		worker.postMessage({
			contracts: trackingContracts.TON,
		});
		setTimeout(handler, 1e3);
	};

	handler();
};
