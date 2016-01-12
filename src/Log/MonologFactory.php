<?php

namespace SocialCrawler\Log;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MonologFactory
{

    public function create($type = Logger::INFO)
    {
        $fileName = [
            Logger::DEBUG => 'debug.log',
            Logger::INFO => 'info.log',
            Logger::NOTICE => 'notice.log',
            Logger::WARNING => 'warning.log',
            Logger::ERROR => 'error.log',
            Logger::CRITICAL => 'critical.log',
            Logger::ALERT => 'alert.log',
            Logger::EMERGENCY => 'emergency.log',
        ];

        $log = new Logger('social-crawler');

        $stream = sprintf(
            '%s%s',
            __DIR__ . '/../../log/',
            $fileName[$type]
        );

        $log->pushHandler(new StreamHandler($stream, $type));

        return $log;
    }
}