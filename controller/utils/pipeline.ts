export const pipeline = async (tasks: (() => Promise<any>)[]) => {
	const results = [];

	for (const task of tasks) {
		try {
			const abortController = new AbortController();
			const { signal } = abortController;

			const sleepPromise = new Promise((resolve, reject) => {
				const timeoutId = setTimeout(resolve, 60_000);

				if (signal) {
					signal.addEventListener("abort", () => {
						clearTimeout(timeoutId);
						reject(false);
					});
				}
			});

			const result = await Promise.race([task(), sleepPromise]);

			abortController.abort();

			results.push(result);
		} catch (e) {
			results.push(e);
		}
	}

	return results;
};
