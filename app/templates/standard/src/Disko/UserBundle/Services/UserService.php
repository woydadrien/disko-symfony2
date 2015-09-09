<?php

/**
 * Service
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\UserBundle\Services;

use Disko\CoreBundle\Services\BaseService;

use Disko\UserBundle\Entity\User;

/**
 * Class UserService
 * `
 * Object manager of user
 *
 * @package Disko\PageBundle\Services
 */
class UserService extends BaseService
{
    /**
     * Repository
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Manager
     *
     * @var UserManager Fos
     */
    protected $userManager;

    /**
     * Save a user
     *
     * @param User $user
     */
    public function save(User $user)
    {
        // Save user
        $this->userManager->updatePassword($user);
        $this->userManager->updateUser($user, true);

        $this->clearResultCache();

    }

    /**
     * Remove one user
     *
     * @param User $user
     */
    public function remove(User $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Get all user
     *
     * @param array $filters
     *
     * @return mixed
     */
    public function getQueryForSearch($filters = array())
    {
        return $this->userRepository->queryForSearch($filters);
    }

    /**
     * Find user by slug for edit profil
     *
     * @param string $id
     *
     * @return mixed
     */
    public function findOneToEdit($id)
    {
        return $this->userRepository->findOneToEdit($id);
    }

    /**
     * Find one by email
     *
     * @param $email
     * @return mixed
     */
    public function findOneByEmail($email)
    {
        return $this->userRepository->findOneBy(array('email' => $email));
    }
}
