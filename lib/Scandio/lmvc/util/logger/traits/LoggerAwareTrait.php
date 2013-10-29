<?php

namespace Scandio\lmvc\modules\logger\traits;

/**
 * Basic Implementation of LoggerAwareInterface
 * not needed as trait will be mixed into most loggers.
 */
trait LoggerAwareTrait
{
    /** @var LoggerInterface */
    protected $logger;

    /**
     * Sets a logger.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}