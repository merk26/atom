<?php



namespace Apix\Log\Logger;

use Apix\Log\LogEntry;

/**
 * Nil (Null) log wrapper.
 *
 * @author             Franck Cassedanne <franck at ouarz.net>
 * @codeCoverageIgnore
 */
class Nil extends AbstractLogger implements LoggerInterface
{

    /**
     * {@inheritDoc}
     */
    public function write(LogEntry $log)
    {
        return false;
    }

}
