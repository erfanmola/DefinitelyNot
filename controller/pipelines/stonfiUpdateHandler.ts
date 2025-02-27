import { stonfiUpdates, stonfiUpdatesFFI } from "../handler/stonfiUpdates";

export const pipelineStonfiUpdateHandler = async () => {
	stonfiUpdates();

	// Let's not use it for now, pulling ~10MB/s is not a good idea unless the contracts grow large in number
	// stonfiUpdatesFFI();
};
