<?php

/**
 * Service
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\CoreBundle\Services;

use Doctrine\ORM\EntityManager;

/**
 * Abstract class for the service which manage the Entity Manager
 *
 * @author Jerphagnon Adrien <woydadrien@gmail.com>
 * @author Paulin Vincent
 */
abstract class BaseService
{

    /**
     * @var EntityManager The Entity Manager
     */
    protected $em;

    /**
     * Getter of the Entity Manager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Setter of the Entity Manager
     *
     * @param EntityManager $em the Entity Manager
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    /**
     * Add a repository to this service
     *
     * @param integer $key   Key
     * @param string  $class Class
     *
     * @return void
     */
    public function addRepository($key, $class)
    {
        $this->$key = $this->em->getRepository($class);
    }

    /**
     * Add a service to this service
     *
     * @param integer $key     Key
     * @param string  $service Class
     *
     * @return void
     */
    public function addService($key, $service)
    {
        $this->$key = $service;
    }

    /**
     * Clear result cache
     *
     * @param string $prefix
     */
    public function clearResultCache($prefix = '')
    {
        $config = $this->em->getConfiguration();
        $cacheDriver = $config->getResultCacheImpl();
        $cacheDriver->flushAll();

        if (get_class($cacheDriver) == 'MemcachedCache')
        {
            $cacheDriver->doFlush();
        }
    }

}
