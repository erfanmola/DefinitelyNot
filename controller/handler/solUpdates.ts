import { pipeline } from "../utils/pipeline";
import { raydiumUpdates } from "./raydiumUpdates";

export const solUpdateHandler = async () => {
	pipeline([raydiumUpdates]);
};
