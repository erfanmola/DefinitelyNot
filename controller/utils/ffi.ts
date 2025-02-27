import { dlopen } from "bun:ffi";

const lib = dlopen(
	`${__dirname}/../../controlle-rs/target/release/libcontrolle_rs.so`,
	{
		fetch_stonfi_assets_filtered: {
			args: ["cstring"],
			returns: "cstring",
		},
	},
);

const { fetch_stonfi_assets_filtered: ffi_fetch_stonfi_assets_filtered } =
	lib.symbols;

export const fetchStonfiAssetsFilteredFFI = (contracts: string[]) => {
	const resultPtr = ffi_fetch_stonfi_assets_filtered(
		Buffer.from(contracts.join(","), "utf-8"),
	);
	const data = resultPtr.toString();
	return JSON.parse(data);
};
