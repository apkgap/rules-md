module.exports = {
	extends: [ 'plugin:@wordpress/eslint-plugin/recommended' ],
	parserOptions: {
		ecmaFeatures: {
			jsx: true,
		},
		sourceType: 'module',
	},
	env: {
		browser: true,
		es2021: true,
		node: true,
	},
};
