<?php
/**
 * Equaltrue
 *
 * This source file is subject to the Equaltrue license
 *
 * @category  Support
 * @package   Equaltrue_Support
 * @copyright Copyright (c) Equaltrue (https://equaltrue.com)
 * @author    Suvankar Paul
 */

declare(strict_types=1);

namespace Equaltrue\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * System Configuration Getter
 *
 * Get Store System Configuration Data
 *
 */
class SysConfig extends AbstractHelper
{
    /**
     * Store's System Configuration Data Getter
     *
     * @param string $path <p>
     * Full Config Path Store Configuration Values.
     * Specifically from core_config_data table
     * </p>
     * @return mixed
     */
    public function getConfig(string $path): mixed
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }
}
