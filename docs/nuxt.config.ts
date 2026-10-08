export default defineNuxtConfig({
	extends: ["github:idmarinas/nuxt-layers/docs-bundle#master", "docus"],
	docsBundle: {
		libraries: [
			{
				title: "Symfony Components",
				icon: "i-tabler-brand-symfony",
				to: "https://www.symfony.com/components",
				description: "This project relies on these components for most of its features.",
			},
			{
				title: "Doctrine ORM",
				icon: "i-tabler-brand-doctrine",
				to: "https://www.doctrine-project.org/projects/orm.html",
				description: "Object-relational mapper for PHP providing data persistence.",
			},
			{
				title: "Doctrine DBAL",
				icon: "i-tabler-brand-doctrine",
				to: "https://www.doctrine-project.org/projects/dbal.html",
				description: "Database abstraction layer for PHP with powerful schema and query features.",
			},
			{
				title: "SymfonyCasts Password Resetting for Symfony",
				icon: "i-tabler-password",
				to: "https://github.com/SymfonyCasts/reset-password-bundle",
				description: "Provides the functionality to reset the password.",
			},
			{
				title: "SymfonyCasts Verify Email Bundle",
				icon: "i-tabler-mail",
				to: "https://github.com/SymfonyCasts/verify-email-bundle",
				description: "It provides the functionality to verify the email.",
			},
			{
				title: "Doctrine Behavioral Extensions",
				icon: "i-tabler-brand-doctrine",
				to: "https://github.com/doctrine-extensions/DoctrineExtensions",
				description: "Provides functionalities for Doctrine such as Blameable, Timestampable and others",
			},
			{
				title: "IDMarinas Common Bundle",
				icon: "i-tabler-package",
				to: "https://github.com/idmarinas/common-bundle",
				description: "Common utilities and extensions used across IDMarinas bundles.",
			},
		],
		socials: {
			x: "https://x.com/idmarinas",
			reddit: "https://reddit.com/u/idmarinas",
			paypal: "https://www.paypal.me/idmarinas",
			bitly: "https://bit.ly/m/idmarinas",
			githubsponsors: "https://github.com/sponsors/idmarinas",
			linkedin: "https://linkedin.com/in/idmarinas",
		},
		support_links: {
			title: "Support me",
			links: [
				{
					icon: "i-tabler-brand-paypal",
					label: "PayPal.Me",
					to: "https://www.paypal.me/idmarinas",
					target: "_blank",
				},
				{
					icon: "i-tabler-brand-github",
					label: "GitHub Sponsor",
					to: "https://github.com/sponsors/idmarinas",
					target: "_blank",
				},
			],
		},
	},
	devServer: { host: "localhost" },
	vite: {
		optimizeDeps: {
			include: ["@vue/devtools-core", "@vue/devtools-kit"],
		},
	},
});
