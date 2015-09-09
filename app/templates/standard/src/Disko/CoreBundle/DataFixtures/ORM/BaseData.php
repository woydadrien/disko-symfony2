<?php

/**
 * Fixtures
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Base
 *
 * class abstract
 */
class BaseData extends AbstractFixture implements FixtureInterface,  ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * Container
     *
     * @var ContainerInterface
     */
    private $container;


    /**
     * Set container
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Load
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

    }

    /**
     * Stuff entity
     *
     * @param $entity   Entity to stuff
     * @param $settings array setttings
     *
     * @return void
     */
    protected function stuff($entity, $settings)
    {
        if (is_array($settings))
        {
            foreach ($settings as $key => $setting) {
                $method = 'set'.ucfirst($key);
                if (method_exists($entity, $method))
                {
                    $entity->$method($setting);
                }
            }
        }

        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 0;
    }
}
