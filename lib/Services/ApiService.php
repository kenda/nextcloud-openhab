<?php

namespace OCA\Openhab\Services;

use OCP\IRequest;
use OCP\IConfig;
use Psr\Log\LoggerInterface;

class ApiService {

	private $server;

	protected $logger;

    public function __construct($appName,
								IConfig $config,
								LoggerInterface $logger) {
		$this->logger = $logger;

		$this->server = [
			'url' => $config->getAppValue('openhab', 'server.url', 'http://localhost:8080'),
			'type' => $config->getAppValue('openhab', 'server.type', 'custom'),
			'username' => $config->getAppValue('openhab', 'server.username', ''),
			'password' => $config->getAppValue('openhab', 'server.password', ''),
			'ignoreSSL' => $config->getAppValue('openhab', 'server.ignoreSSL', false)
		];
    }

	public function sendRequest(string $path, string $description) {
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
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Accept: application/json"
		));

		if ($this->server['type'] == 'custom' && $this->server['ignoreSSL'] == true) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		if ($this->server['type'] == 'myopenhab') {
			curl_setopt($ch, CURLOPT_USERPWD, trim($this->server['username']) . ':' . $this->server['password']);
		}

		$this->logger->debug($description . " - request send", curl_getinfo($ch));

		$data = curl_exec($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($data, 0, $header_size);
		$body = substr($data, $header_size);

		$this->logger->debug($description . " - response headers", explode("\r\n", $headers));
		if ($body != null) {
			$this->logger->debug($description . " - response body", json_decode($body, true));
		}

		if (curl_errno($ch)) {
			$this->logger->error($description . " - error while api request", [0 => curl_error($ch)]);
		} else {
			$this->logger->debug($description . " - request successful");
		}

		curl_close($ch);

		return json_decode($body);
	}
}
