const path = require('path')
const webpackConfig = require('@nextcloud/webpack-vue-config')

webpackConfig.entry['admin'] = path.join(__dirname, 'src', 'admin.js')

module.exports = webpackConfig
