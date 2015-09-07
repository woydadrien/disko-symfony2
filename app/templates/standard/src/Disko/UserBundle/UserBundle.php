<?php

namespace Disko\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

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
