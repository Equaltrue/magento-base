<?php
/**
 * Equaltrue (shuvoenr@gmail.com)
 *
 * This source file is subject to the Equaltrue license
 *
 * @category  Core
 * @package   Equaltrue_Core
 * @copyright Copyright (c) Equaltrue (https://equaltrue.com)
 * @author    Suvankar Paul
 */

declare(strict_types=1);

namespace Equaltrue\Core\Helper;

use Exception;
use Equaltrue\Core\Helper\Logger\EqLogger;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Magento All in All URL Helper
 *
 * Provides All Necessary URL in Single Place
 *
 */
class URL extends AbstractHelper
{
    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param EqLogger $eqLogger
     */
    public function __construct(
        Context $context,
        private readonly StoreManagerInterface $storeManager,
        private readonly EqLogger $eqLogger
    ) {
        parent::__construct($context);
    }

    /**
     * Get Store Base URL
     *
     * This will Back the store's web secure URL (Storefront Base URL in Short)
     *
     * @return string|null
     */
    public function getBaseUrl(): ?string
    {
        try {
            return $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_WEB, true);
        } catch (Exception $exception) {
            $this->eqLogger->writeException($exception);
            return "";
        }
    }

    /**
     * Get Store Media URL
     *
     * This will Back the store's web secure URL (Storefront Base URL in Short)
     *
     * @return string|null
     */
    public function getMediaUrl(): ?string
    {
        try {
            return $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA, true);
        } catch (Exception $exception) {
            $this->eqLogger->writeException($exception);
            return "";
        }
    }

    /**
     * Get Store Media URL
     *
     * This will Back the store's web secure URL (Storefront Base URL in Short)
     *
     * @return string|null
     */
    public function getStaticUrl(): ?string
    {
        try {
            return $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_STATIC, true);
        } catch (Exception $exception) {
            $this->eqLogger->writeException($exception);
            return "";
        }
    }

    /**
     * Get Any Secure Storefront URL by Route
     *
     * @param string $route Route String Exclude Base URL
     * @param array $params URL Parameter key value array
     * @return string Full Url String
     * */
    public function getUrl(string $route, array $params = []): string
    {
        $params['_secure'] = true;
        return parent::_getUrl($route, $params);
    }
}
