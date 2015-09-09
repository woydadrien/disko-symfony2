<?php

/**
 * Form type
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 *  Form Type
 *
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class SearchUserType extends AbstractType
{
    /**
     * Build Form
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'text', array('required' => false));
        $builder->add('firstName', 'text', array('required' => false));
        $builder->add('lastName', 'text', array('required' => false));
        $builder->add('email', 'text', array('required' => false));
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'search';
    }
}
