<?php

namespace OCA\Openhab\Services;

use OCP\IRequest;
use OCP\IConfig;

class ApiService {

	private $server;

    public function __construct($appName,
								IConfig $config) {

		$this->server = [
			'url' => $config->getAppValue('openhab', 'server.url', 'http://localhost:8080'),
			'type' => $config->getAppValue('openhab', 'server.type', 'custom'),
			'username' => $config->getAppValue('openhab', 'server.username', ''),
			'password' => $config->getAppValue('openhab', 'server.password', ''),
			'ignoreSSL' => $config->getAppValue('openhab', 'server.ignoreSSL', false)
		];
    }

	public function sendRequest(string $path) {
		$ch = curl_init();

		$host = $this->server['url'];
		if ($this->server['type'] == 'myopenhab') {
			$host = 'https://home.myopenhab.org';
		}
		curl_setopt($ch, CURLOPT_URL, $host . $path);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Accept: application/json"
		));

		if ($this->server['type'] == 'custom' && $this->server['ignoreSSL'] == true) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		if ($this->server['type'] == 'myopenhab') {
			curl_setopt($ch, CURLOPT_USERPWD, $this->server['username'] . ':' . $this->server['password']);
		}

		$data = curl_exec($ch);
		curl_close($ch);

		return json_decode($data);
	}
}
