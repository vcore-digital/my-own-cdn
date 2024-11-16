const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = {
	mode: 'production',

	entry: {
		moc: path.resolve(__dirname, 'assets/_src/scripts/admin.js'),
	},

	output: {
		clean: {
			keep: /images/,
		},
		filename: '[name].min.js',
		path: path.resolve(__dirname, 'assets/js'),
	},

	module: {
		rules: [
			{
				test: /\.(js)$/,
				exclude: /node_modules/,
			},
			{
				test: /\.s[ac]ss$/i,
				use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
			},
		],
	},

	devtool: 'source-map',

	watchOptions: {
		ignored: /node_modules/,
		poll: 1000,
	},

	resolve: {
		extensions: ['.js', '.jsx'],
	},

	plugins: [
		new MiniCssExtractPlugin({
			filename: '../css/[name].min.css',
			chunkFilename: '[id].min.css',
		}),
	],

	optimization: {
		minimize: true,
		minimizer: [
			new TerserPlugin({
				extractComments: false,
				terserOptions: {
					output: {
						comments: false,
					},
				},
			}),
		],
	},
};
