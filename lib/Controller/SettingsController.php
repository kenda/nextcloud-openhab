<?php
namespace OCA\Openhab\Controller;

use OCP\IRequest;
use OCP\IConfig;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;

class SettingsController extends Controller {

	private $config;

	public function __construct($appName,
								IConfig $config,
								IRequest $request){
		parent::__construct($appName, $request);

		$this->config = $config;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		$settings = [
			'server.type',
			'server.url',
			'server.username',
			'server.password',
			'server.ignoreSSL',
			'server.interval',
        ];

		foreach ($settings as $setting) {
            $result[$setting] = $this->config->getAppValue(
                $this->appName,
                $setting
            );
        }

        return $result;
	}

	/**
     * @NoAdminRequired
     */
    public function update() {
        return $this->apiService->sendRequest('/rest/sitemaps');
    }
}
