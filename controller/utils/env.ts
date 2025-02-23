import dotenv from "dotenv";
import { z, type ZodError } from "zod";

const EnvSchema = z.object({
	CONTROLLER_HOST: z.string().default("0.0.0.0"),
	CONTROLLER_PORT: z.coerce.number(),
	NETWORK: z.enum(["testnet", "mainnet"]).default("testnet"),
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

export default env;
