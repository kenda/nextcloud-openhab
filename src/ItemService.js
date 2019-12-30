export default class {

	static getValue(item, defaultValue = '') {
		if (item) {
			const index = item.indexOf('[')

			if (index !== -1) {
				return item.substring(index + 1, item.length - 1)
			} else {
				return defaultValue
			}
		} else {
			return defaultValue
		}
	}

	static getLabel(item, defaultValue = '') {
		if (item) {
			const index = item.indexOf('[')

			if (index !== -1) {
				return item.substring(0, index)
			} else {
				return item
			}
		} else {
			return defaultValue
		}
	}

}
