import { tonAPINativePriceUpdate, tonAPISleep } from "../utils/tonapi";

import { nativeAssetsRate } from "../store";
import { pipeline } from "../utils/pipeline";

export const tonUpdateHandler = async () => {
	const [, tonPrice] = await pipeline([
		tonAPISleep,
		tonAPINativePriceUpdate,
		tonAPISleep,
	]);

	nativeAssetsRate.TON = tonPrice ?? nativeAssetsRate.TON;

	setTimeout(tonUpdateHandler);
};
