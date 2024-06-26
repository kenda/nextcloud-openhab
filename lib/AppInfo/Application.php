<?php

declare(strict_types=1);

namespace OCA\Openhab\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCA\Openhab\Dashboard\Widget;

class Application extends App implements IBootstrap {

    public const APP_ID = 'openhab';

    public function __construct(array $urlParams = []) {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void {
        $context->registerDashboardWidget(Widget::class);
    }

    public function boot(IBootContext $context): void {
    }
}
