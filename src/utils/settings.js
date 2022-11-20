export const loadSettings = (settingKeys) => {
    return new Promise(async (resolve, reject) => {
        const settings = {};

        for (const setting of settingKeys) {
            try {
                const resDocument = await new Promise((resolve, reject) =>
                    OCP.AppConfig.getValue('openhab', setting, null, {
                        success: resolve,
                        error: reject,
                    })
                );
                if (resDocument.querySelector('status').textContent !== 'ok') {
                    reject(resDocument);
                    return;
                }
                const dataEl = resDocument.querySelector('data');
                settings[setting] = dataEl.firstElementChild.textContent;

                if (['true', 'false'].includes(settings[setting])) {
                    settings[setting] = (settings[setting] === 'true');
                }
            } catch (e) {
                reject(e);
            }
        }

        resolve(settings);
    });
};
