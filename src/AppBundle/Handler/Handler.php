<?php

namespace AppBundle\Handler;

use FOS\RestBundle\Request\ParamFetcherInterface;

class Handler
{
    /**
     * Transform the parameters to a valid array.
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return array $filters
     */
    protected function managingFilters(ParamFetcherInterface $paramFetcher)
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