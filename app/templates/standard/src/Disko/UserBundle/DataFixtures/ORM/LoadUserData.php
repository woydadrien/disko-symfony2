<?php

/**
 * Fixture
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Disko\UserBundle\Entity\User;
use Disko\UserBundle\Entity\Localisation;

/**
 * Class LoadUserData
 *
 * Load user's fixtures
 *
 * @package Disko\UserBundle\DataFixtures\ORM
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * Container
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = $this->addUser(array(
            'username' => 'admin',
            'firstname'=> 'admin',
            'lastname' => 'admin'.'ing',
            'email'    => 'admin@example.com',
            'password' => 'admin',
            'role'     => 'ROLE_SUPER_ADMIN',
            'enabled'  => true
        ));
        $this->addReference('admin-user', $user);

        $user = $this->addUser(array(
            'username' => 'adminfr',
            'firstname'=> 'adminfr',
            'lastname' => 'adminfr'.'ing',
            'email'    => 'adminfr@example.com',
            'password' => 'adminfr',
            'role'     => 'ROLE_FR',
            'enabled'  => true
        ));
        $this->addReference('admin-user-fr', $user);

        $user = $this->addUser(array(
            'username' => 'adminen',
            'firstname'=> 'adminen',
            'lastname' => 'adminen'.'ing',
            'email'    => 'adminen@example.com',
            'password' => 'adminen',
            'role'     => 'ROLE_EN',
            'enabled'  => true
        ));
        $this->addReference('admin-user-en', $user);

        $users = array('aba', 'lilian', 'stemhane', 'eliot', 'francine', 'carmine', 'devil', 'kondor', 'odor',
            'popo', 'karl', 'remi', 'estab', 'somal', 'gress', 'carn', 'toust', 'simbad', 'pierre', 'jimmy');

        for ($i = 0; $i <= 9; $i++) {
            foreach ($users as $user) {
                $tmp = $user.$i;
                $this->addUser(array(
                    'username' => $tmp,
                    'firstname'=> $tmp,
                    'lastname' => $tmp.'ing',
                    'email'    => $tmp.'@example.com',
                    'password' => $tmp,
                    'enabled'  => true
                ));
            }
        }
    }

    /**
     * Add user on base
     *
     * @param $settings
     */
    protected function addUser($settings)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername($settings['username']);
        $user->setEmail($settings['email']);
        $user->setFirstName($settings['firstname']);
        $user->setLastName($settings['lastname']);
        $user->setPlainPassword($settings['password']);
        $user->setEnabled($settings['enabled']);

        if (isset($settings['role'])) {
            $user->addRole($settings['role']);
        }

        $userManager->updateUser($user, true);

        $localisation = new Localisation();
        $localisation->setTitle('Facturation');
        $localisation->setAddress('11 rue de la ginette');
        $localisation->setAddressMore('');
        $localisation->setPhone('04 75 53 07 39');
        $localisation->setCode('25000');
        $localisation->setCity('Bouligne');
        $localisation->setCountry('FR');
        $user->addLocalisation($localisation);

        $userManager->updateUser($user, true);

        $this->addReference('user-'.strtolower($settings['username']), $user);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
