export default class {

	static getValue(item, defaultValue = '') {
		const index = item.indexOf('[')

		if (index !== -1) {
			return item.substring(index + 1, item.length - 1)
		} else {
			return defaultValue
		}
	}

	static getLabel(item) {
		const index = item.indexOf('[')

		if (index !== -1) {
			return item.substring(0, index)
		} else {
			return item
		}
	}

}
