<?php

namespace Disko\CoreBundle\Services;

/**
 * Class CacheService
 *
 * Object manager of user
 *
 * @package Disko\CoreBundle\Services
 */
class CacheService extends BaseService
{
    /**
     * @var array
     */
    protected $cache;

    /**
     * @param null $cacheKey
     * @return int
     */
    public function esi($cacheKey = null, $rand = true)
    {
        $ttl = 0;
        if (isset($this->cache['esi'][$cacheKey])) {
            $ttl = $this->cache['esi'][$cacheKey];
            if($rand) {
                $rand = $this->cache['random_percent'];
                $ttl = round($ttl * (1 + rand(-1 * $rand, $rand) / 100));
            }
        }

        return $ttl;
    }

    /**
     * @param null $cacheKey
     * @return int
     */
    public function data($cacheKey = null, $rand = true)
    {
        $ttl = 0;
        if (isset($this->cache['data'][$cacheKey])) {
            $ttl = $this->cache['data'][$cacheKey];
            if($rand) {
                $rand = $this->cache['random_percent'];
                $ttl = round($ttl * (1 + rand(-1 * $rand, $rand) / 100));
            }
        }

        return $ttl;
    }

    /**
     * @param $ttl
     * @param null $date
     *
     * @return \DateTime
     */
    public function roundDate($ttl, \DateTime $date = null)
    {
        if(is_null($date)) $date = new \DateTime();

        $date->setTimestamp(round($date->getTimestamp() / $ttl) * $ttl);

        return $date;
    }
}
