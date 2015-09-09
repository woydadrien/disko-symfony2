<?php

namespace Disko\UserBundle\Services;

use Disko\CoreBundle\Services\TransactionalService;

use Disko\UserBundle\Entity\Localisation;

/**
 * Class LocalisationService
 * `
 * Object manager of user
 *
 * @package Disko\PageBundle\Services
 */
class LocalisationService extends TransactionalService
{
    /**
     * @var LocalisationRepository
     */
    protected $localisationRepository;

    /**
     * Save a localisation
     *
     * @param Localisation $localisation
     */
    public function save(Localisation $localisation)
    {
        $this->getEntityManager()->persist($localisation);
        $this->getEntityManager()->flush();

        return $localisation;
    }
}
