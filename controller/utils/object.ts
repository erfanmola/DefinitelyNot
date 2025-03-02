export const objectClone = (object: any) => {
	return JSON.parse(JSON.stringify(object));
};

export const objectEquals = (a: object, b: object) => {
	return JSON.stringify(a) === JSON.stringify(b);
};

export const filterUpdatedObjectsInArray = (
	objects: (any & { updated: boolean })[],
) => {
	return objects.filter((item) => {
		if (item.updated) {
			item.updated = false;
			return true;
		}

		return false;
	});
};
