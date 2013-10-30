<?php

namespace Scandio\lmvc\utils\logger\formatters;

use Scandio\lmvc\utils\logger\interfaces;

/**
 * Class AbstractLogger
 * @package Scandio\lmvc\utils\logger\formatters
 *
 * An abstract formatter abstracting from general purpose methods for
 * every subsequent child formatter.
 */
abstract class AbstractFormatter implements interfaces\FormatterInterface
{
    protected
        $dateFormat = null,
        $logFormat  = null;

    # This is what the concrete formatter does
    abstract public function format($message, $context);

    /**
     * Formats a given input by trying to normalize it into a decent string representation.
     *
     * @param $data mixed which shall be formatted
     * @return string formatted version of $data depending on its type
     */
    protected function normalize($data)
    {
        if ( is_scalar($data) OR $data === null ) { return $data; }
        elseif ( is_array($data) OR $data instanceof \Traversable ) { return $this->normalizeIterator($data); }
        elseif ( $data instanceof \DateTime ) { return $this->normalizeDate($data); }
        elseif ( $data instanceof \Exception ) { return $this->normalizeException($data); }
        elseif ( is_object($data) ) { return $this->normalizeObject($data); }
        else {
            return [
                'type' => 'Unknown',
                'type'  => gettype($data)
            ];
        }
    }

    /**
     * Normalizes an object into its string representation.
     *
     * @param $object object to be normalized
     * @return string representation of $object
     */
    protected function normalizeObject($object)
    {
        return [
            'type'      => 'Object',
            'extra'     => [get_class($object)],
            'payload'   => $object
        ];
    }

    /**
     * Normalizes an iterator into its string representation.
     *
     * @param $iterator  to be normalized
     * @return string representation of $object
     */
    protected function normalizeIterator($data)
    {
        $normalized = array();

        foreach ($data as $key => $value) {
            $normalized[$key] = $this->normalize($value);
        }

        return [
            'type'      => 'Traversable',
            'extra'     => [],
            'payload'   => $normalized
        ];
    }

    /**
     * Normalizes an date into its string representation.
     *
     * @param $date to be normalized
     * @return string representation of $object
     */
    protected function normalizeDate($date)
    {
        $formattedDate =  $date->format($this->dateFormat);

        return [
            'type'      => 'Date',
            'extra'     => [],
            'payload'   => $formattedDate
        ];
    }

    /**
     * Normalizes an exception into its string representation.
     *
     * @param $exception to be normalized
     * @return string representation of $object
     */
    protected function normalizeException($exception)
    {
        return [
            'type'      => 'Exception',
            'extra'     => [
                get_class($exception),
                $exception->getFile().':'.$exception->getLine()
            ],
            'payload'   => $exception->getMessage()
        ];
    }

    /**
     * Encodes an object into its Json representation.
     *
     * @param $data to be parsed into Json
     * @return string the json string
     */
    protected function toJson($data)
    {
        return json_encode($data);
    }
}