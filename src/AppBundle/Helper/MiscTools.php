<?php

namespace AppBundle\Helper;

use FOS\RestBundle\Request\ParamFetcherInterface;

class MiscTools
{
    /**
     * @param $string
     *
     * @return bool|null
     */
    public static function stringToBool($string)
    {
        if ($string === true || $string === false) {
            return $string;
        } elseif ($string !== null && (strtolower($string) === 'true' || $string === '1' || $string === 1)) {
            return true;
        } elseif ($string !== null && (strtolower($string) === 'false' || $string === '0' || $string === 0)) {
            return false;
        }
        return false;
    }


    /**
     * Transform the parameters to a valid array.
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return array $filters
     */
    public static function managingFilters(ParamFetcherInterface $paramFetcher)
    {
        $filters = [];

        foreach ($paramFetcher->all() as $name => $value) {
            // Take the valid parameters, not null and not reserved
            if (null !== $value) {
                // Transform the param name from snake case to camel case
                $filters[lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $name))))] = $value;
            }
        }

        return $filters;
    }
}