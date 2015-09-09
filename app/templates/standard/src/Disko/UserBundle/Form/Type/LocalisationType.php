<?php

namespace Disko\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *  Form Type
 *
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class LocalisationType extends AbstractType
{
    /**
     * Build Form
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('required' => false));
        $builder->add('address', 'text', array('required' => false));
        $builder->add('addressMore', 'textarea', array('required' => false));
        $builder->add('code', 'text', array('required' => false));
        $builder->add('phone', 'text', array('required' => false));
        $builder->add('city', 'text', array('required' => false));
        $builder->add('country', 'country', array(
            'empty_value' => 'Choose a country',
            'preferred_choices' => array('FR', 'GB', 'US', 'CA'),
        ));
    }

    /**
     * Set default options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Disko\UserBundle\Entity\Localisation',
        ));
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'localisation';
    }
}
