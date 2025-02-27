import { fetchStonfiAssetsFilteredFFI } from "../utils/ffi";

declare const self: Worker;

self.onmessage = (event: MessageEvent) => {
	try {
		const { contracts } = event.data;
		const result = fetchStonfiAssetsFilteredFFI(contracts);
		postMessage(result);
	} catch (e) {
		console.warn("fetchStonfiAssetsFilteredFFI Worker", e);
	}
};
