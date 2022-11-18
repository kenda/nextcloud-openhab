const path = require('path')
const webpackConfig = require('@nextcloud/webpack-vue-config')

webpackConfig.entry['admin'] = path.join(__dirname, 'src', 'admin.js')
webpackConfig.entry['widget'] = path.join(__dirname, 'src', 'widget.js')

module.exports = webpackConfig
