<?php
namespace OCA\Openhab\Controller;

use OCA\Openhab\Services\ApiService;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\Util;

class PageController extends Controller {

	private $apiService;

	public function __construct($appName,
								IRequest $request,
								ApiService $apiService){
		parent::__construct($appName, $request);

		$this->apiService = $apiService;
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		Util::addScript($this->appName, 'openhab-main');
		return new TemplateResponse($this->appName, 'main');
	}

	    /**
     * @NoAdminRequired
     */
    public function getSitemaps() {
        return $this->apiService->sendRequest('/rest/sitemaps');
    }

     /**
      * @NoAdminRequired
      *
      * @param string $id
      */
     public function getSitemap(string $id) {
         return $this->apiService->sendRequest('/rest/sitemaps/' . $id);
     }

	/**
      * @NoAdminRequired
      *
      * @param string $id
      */
     public function getItemPersistence(string $item) {
         return $this->apiService->sendRequest('/rest/persistence/items/' . $item);
     }
}
