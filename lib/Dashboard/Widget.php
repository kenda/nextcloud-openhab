<?php
namespace OCA\Openhab\Dashboard;

use OCP\Dashboard\IWidget;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\Util;

class Widget implements IWidget
{

    /** @var IURLGenerator */
    private $url;
    /** @var IL10N */
    private $l10n;

    public function __construct(
		$appName,
        IURLGenerator $url,
        IL10N $l10n
    )
    {
		$this->appName = $appName;
        $this->url = $url;
        $this->l10n = $l10n;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return 'openhab';
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return 'Openhab Viewer';
    }

    /**
     * @inheritDoc
     */
    public function getOrder(): int
    {
        return 20;
    }

    /**
     * @inheritDoc
     */
    public function getIconClass(): string
    {
        return 'icon-openhab';
    }

    /**
     * @inheritDoc
     */
    public function getUrl(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function load(): void
    {
		Util::addScript($this->appName, 'openhab-widget');
    }
}
