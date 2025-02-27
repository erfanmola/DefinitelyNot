import { contractsData, trackingContracts } from "../store";

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

	for (const contract of fetchedContracts) {
		const currentContractIndex = contractsData.TON.stonfi.findIndex(
			(item) => item.contract_address === contract.contract_address,
		);

		if (currentContractIndex > -1) {
			contractsData.TON.stonfi[currentContractIndex] = contract;
		} else {
			contractsData.TON.stonfi.push(contract);
		}
	}

	setTimeout(stonfiUpdates, 1e3);
};

export const stonfiUpdatesFFI = async () => {
	const worker = new Worker(
		`${__dirname}/../workers/fetchStonfiAssetsFilteredFFI.ts`,
	);

	worker.onmessage = (event) => {
		contractsData.TON.stonfi = event.data;
	};

	const handler = () => {
		worker.postMessage({
			contracts: trackingContracts.TON,
		});
		setTimeout(handler, 1e3);
	};

	handler();
};
