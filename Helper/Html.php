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

namespace Equaltrue\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Html extends AbstractHelper
{
    /**
     * Minify Html Content
     *
     * @param string $html
     * @return string
     */
    public function minifyHtml(string $html = ''): string
    {
        $search = [
            // Remove whitespaces after tags
            '/\>[^\S ]+/s',
            // Remove whitespaces before tags
            '/[^\S ]+\</s',
            // Remove multiple whitespace sequences
            '/(\s)+/s',
            // Removes comments
            '/<!--(.|\s)*?-->/'
        ];
        $replace = ['>', '<', '\\1'];
        return preg_replace($search, $replace, $html);
    }
}
