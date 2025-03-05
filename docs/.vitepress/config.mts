import { defineConfig } from "vitepress";

// https://vitepress.dev/reference/site-config
export default defineConfig({
	title: "Definitely Not, Well, Maybe",
	description:
		"Documentations about a bot that is Definitely Not the best trading bot available right now, cause I suck at blockchain, web3 and that kind of stuff.",
	themeConfig: {
		// https://vitepress.dev/reference/default-theme-config
		nav: [
			{ text: "Home", link: "/" },
			{ text: "Getting Started", link: "/overview/introduction" },
			{
				text: "Telegram Bot",
				link: "https://t.me/ItsDefinitelyNotBot",
			},
			{ text: "GitHub", link: "https://github.com/erfanmola/DefinitelyNot" },
		],
		socialLinks: [
			{ icon: "github", link: "https://github.com/erfanmola/DefinitelyNot" },
		],
		sidebar: [
			{
				text: "Overview",
				items: [
					{ text: "Introduction", link: "/overview/introduction" },
					{ text: "Features", link: "/overview/features" },
					{ text: "Architecture", link: "/overview/architecture" },
					{ text: "Wallet Management", link: "/overview/wallets" },
					{ text: "Security & Config", link: "/overview/configuration" },
					{ text: "TON APIs", link: "/overview/ton-apis" },
					{ text: "Database Schema", link: "/overview/database" },
					{ text: "Setup", link: "/overview/setup" },
				],
			},
		],
	},
});
