<?php

/**
 * Bundle definition needed for kernel
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class UserBundle
 *
 * @package Disko\UserBundle
 */
class UserBundle extends Bundle
{
    /**
     * Get parent bundle
     *
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
