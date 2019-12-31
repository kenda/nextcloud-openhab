<?php

namespace OCA\Openhab\Controller;

use OCP\IRequest;
use OCP\AppFramework\Controller;
use OCP\IConfig;
use \OCP\ILogger;

class PersistenceController extends Controller {

	private $server;

	private $logger;

    public function __construct($appName,
								IConfig $config,
								ILogger $logger,
                                IRequest $request) {
        parent::__construct($appName, $request);

		$this->logger = $logger;

		$this->server = [
			'url' => $config->getAppValue('openhab', 'server.url', 'http://localhost:8080'),
			'ignoreSSL' => $config->getAppValue('openhab', 'server.ignoreSSL', false)
		];
    }

     /**
      * @NoAdminRequired
      *
      * @param string $id
      */
     public function show(string $id) {
		 return $this->sendRequest($this->server['url'] . '/rest/persistence/items/' . $id);
     }

	private function sendRequest(string $url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Accept: application/json"
		));

		if ($this->server['ignoreSSL'] == true) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		$data = curl_exec($ch);
		curl_close($ch);

		return json_decode($data);
	}
}
