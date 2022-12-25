<?php

namespace OCA\Openhab\Controller;

use OCA\Openhab\Services\ApiService;
use OCP\IRequest;
use OCP\AppFramework\Controller;

class SitemapController extends Controller {

    private $apiService;

    public function __construct($appName,
                                IRequest $request,
                                ApiService $apiService) {
        parent::__construct($appName, $request);

        $this->apiService = $apiService;
    }

    /**
     * @NoAdminRequired
     */
    public function index() {
        return $this->apiService->sendRequest('/rest/sitemaps');
    }

     /**
      * @NoAdminRequired
      *
      * @param string $id
      */
     public function show(string $id) {
         return $this->apiService->sendRequest('/rest/sitemaps/' . $id);
     }
}
