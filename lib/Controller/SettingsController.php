<?php
namespace OCA\Openhab\Controller;

use OCA\Openhab\Services\ApiService;
use OCP\IRequest;
use OCP\IConfig;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use Psr\Log\LoggerInterface;

class SettingsController extends Controller {

	private $apiService;

	private $config;

	protected $logger;

	private $CONFIG_KEYS = [
								 'server.type',
								 'server.url',
								 'server.username',
								 'server.password',
								 'server.ignoreSSL',
								 'server.interval',
    ];

	public function __construct($appName,
								ApiService $apiService,
								IConfig $config,
								IRequest $request,
								LoggerInterface $logger){
		parent::__construct($appName, $request);

		$this->apiService = $apiService;

		$this->config = $config;

		$this->logger = $logger;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		foreach ($this->CONFIG_KEYS as $setting) {
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
    public function update($settings) {
      $this->logger->debug('Updating settings value', $settings);

      foreach ($settings as $settingsKey => $value) {
        $this->config->setAppValue($this->appName, $settingsKey, $value);
      }

      // send test request
      return $this->apiService->sendRequest('/rest/sitemaps', 'Get sitemaps to test changed server settings');
    }
}
