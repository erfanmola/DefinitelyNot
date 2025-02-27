import dotenv from "dotenv";
import { z, type ZodError } from "zod";

const EnvSchema = z.object({
	CONTROLLER_HOST: z.string().default("0.0.0.0"),
	CONTROLLER_PORT: z.coerce.number(),
	BOT_HOST: z.string().default("0.0.0.0"),
	BOT_PORT: z.coerce.number(),
	NETWORK: z.enum(["testnet", "mainnet"]).default("testnet"),
	TONCENTER_TESTNET_KEY: z.string().optional(),
	TONCENTER_MAINNET_KEY: z.string().optional(),
	TONCONSOLE_KEY: z.string().optional(),
});

export type env = z.infer<typeof EnvSchema>;

let env: env;

try {
	env = EnvSchema.parse(
		dotenv.config({ path: `${__dirname}/../../.env` }).parsed,
	);
} catch (e) {
	const error = e as ZodError;
	console.log("Invalid environment variables");
	console.log(error.flatten().fieldErrors);
	process.exit(1);
}

export const isMainNet = env.NETWORK === "mainnet";

export default env;
