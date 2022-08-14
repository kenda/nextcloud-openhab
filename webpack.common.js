const path = require('path')
const { VueLoaderPlugin } = require('vue-loader')

module.exports = {
	entry: {
		main: path.join(__dirname, 'src', 'main.js'),
		admin: path.join(__dirname, 'src', 'admin.js')
	},
	output: {
		path: path.resolve(__dirname, './js'),
		publicPath: '/js/',
		filename: `[name].js`,
		chunkFilename: 'chunks/[name]-[hash].js'
	},
	module: {
		rules: [
			{
				test: /\.css$/,
				use: ['vue-style-loader', 'css-loader']
			},
			{
				test: /\.scss$/,
				use: ['vue-style-loader', 'css-loader', 'sass-loader']
			},
			{
				test: /\.(js|vue)$/,
				use: 'eslint-loader',
				enforce: 'pre'
			},
			{
				test: /\.vue$/,
				loader: 'vue-loader'
			},
			{
				test: /\.js$/,
				loader: 'babel-loader',
				exclude: /node_modules/
			},
			{
				test: /\.(png|jpg|gif|svg)$/,
				loader: 'file-loader',
				options: {
					name: '[name].[ext]?[hash]'
				}
			}
		]
	},
	plugins: [
		new VueLoaderPlugin(),
	],
	resolve: {
		extensions: ['*', '.js', '.vue', '.json']
	}
}
