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

use Equaltrue\Core\Helper\Logger\EqLogger;
use Exception;
use InvalidArgumentException;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Serialize extends AbstractHelper
{
    /**
     * @param Context $context
     * @param EqLogger $eqLogger
     */
    public function __construct(
        Context $context,
        private readonly EqLogger $eqLogger
    ) {
        parent::__construct($context);
    }

    /**
     * Unserialize String
     *
     * @param string $value
     * @return array|mixed
     */
    public function unserialize(string $value): mixed
    {
        try {
            $unSerialized = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $unSerialized;
            }
            return unserialize($value); // @phpcs:ignore
        } catch (Exception) {
            return [];
        }
    }

    /**
     * Check UTF Character
     *
     * @param mixed $mixed
     * @return array|bool|string|null
     */
    protected function utf8ize(mixed $mixed): array|bool|string|null
    {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->utf8ize($value);
            }
        } elseif (is_string($mixed)) {
            return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
        }
        return $mixed;
    }

    /**
     * Serialize Utf Value
     *
     * @param mixed $data
     * @return string
     */
    public function serializeUtf(mixed $data): string
    {
        $result = json_encode($this->utf8ize($data));
        if (false === $result) {
            $this->eqLogger->write("Unable to serialize value. Error: " . json_last_error_msg(), 'error');
            throw new InvalidArgumentException("Unable to serialize value. Error: " . json_last_error_msg());
        }
        return $result;
    }
}
