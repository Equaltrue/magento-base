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

namespace Equaltrue\Core\Helper\Logger;

use Exception;
use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Filesystem\Driver\File;

class EqLogger extends AbstractHelper
{
    private const FILE   = 'equaltrue.log';
    private const FOLDER = BP . '/var/log/equaltrue';           // @phpstan-ignore-line
    private const EXCEPTION_FOLDER = BP . '/var/log/exception'; // @phpstan-ignore-line

    /**
     * @param File $file
     * @param Context $context
     */
    public function __construct(
        private readonly File $file,
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Logger Function
     *
     * @param mixed $message Message mixed data
     * @param string $folder Folder where file will save
     * @param string $file File name must have filename.log
     * @param string $type Error type
     * @return bool
     */
    public function write(
        mixed $message,
        string $folder = self::FOLDER,
        string $file = self::FILE,
        string $type = "info"
    ): bool {
        try {
            $this->file->createDirectory($folder);
        } catch (Exception) {
            return false;
        }
        $file = $folder . '/' . $file;
        $writer = new Stream($file);
        $logger = new Logger();
        $logger->addWriter($writer);

        switch ($type) {
            case "emergency":
                $logger->emerg($message);
                break;
            case "alert":
                $logger->alert($message);
                break;
            case "error":
                $logger->err($message);
                break;
            case "critical":
                $logger->crit($message);
                break;
            case "warning":
                $logger->warn($message);
                break;
            case "debug":
                $logger->debug($message);
                break;
            case "notice":
                $logger->notice($message);
                break;
            default:
                $logger->info($message);
        }
        return true;
    }

    /**
     * Logger Write Exception
     *
     * @param mixed $exception
     * @param string $exceptionTitle
     * @param string $folder
     * @param string $file
     * @return bool
     */
    public function writeException(
        mixed $exception,
        string $exceptionTitle = '',
        string $folder = self::EXCEPTION_FOLDER,
        string $file = self::FILE
    ): bool {
        try {
            $this->file->createDirectory($folder);
        } catch (Exception) {
            return false;
        }
        $file = $folder . '/' . $file . $this->logFileByDate();
        $writer = new Stream($file);
        $logger = new Logger();
        $logger->addWriter($writer);

        //-- Exception Write Format
        $message  = "Exception : $exceptionTitle \n";
        $message .= "Message   : " . $exception->getMessage() . "\n";
        $message .= "File      : " . $exception->getFile() . ":" . $exception->getLine() . "\n";
        $message .= "Trace     : " . $exception->getTraceAsString();
        $logger->err($message);

        return true;
    }

    /**
     * Log file name by date wise
     *
     * @param string $format Date Format
     * @return string
     */
    public function logFileByDate(string $format = 'Y-m-d'): string
    {
        return '-' . date($format) . '.log';
    }
}
