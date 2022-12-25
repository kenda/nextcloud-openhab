<?php

namespace OCA\Openhab\Controller;

use OCA\Openhab\Services\ApiService;
use OCP\IRequest;
use OCP\AppFramework\Controller;

class PersistenceController extends Controller {

    private $apiService;

    public function __construct($appName,
                                ApiService $apiService,
                                IRequest $request) {
        parent::__construct($appName, $request);

        $this->apiService = $apiService;
    }

     /**
      * @NoAdminRequired
      *
      * @param string $id
      */
     public function show(string $id) {
         return $this->apiService->sendRequest('/rest/persistence/items/' . $id);
     }
}
