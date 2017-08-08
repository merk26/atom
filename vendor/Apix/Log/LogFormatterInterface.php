<?php

namespace Apix\Log;
interface LogFormatterInterface
{
    public function format(LogEntry $log);
}