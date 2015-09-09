<?php

/**
 * Form type
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *  Form Type
 *
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class UserType extends AbstractType
{
    /**
     * Build Form
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('civility', 'choice', array(
            'choices'   => array(
                'm' => 'form.user.civility.m',
                'mme' => 'form.user.civility.mme',
                'mlle' => 'form.user.civility.mlle'
            ),
            'empty_value' => false,
            'required'  => false,
        ));
        $builder->add('firstName', 'text');
        $builder->add('lastName', 'text');
        $builder->add('email', 'email');
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'options' => array('required' => false),
            'first_options'   =>  array('label' => 'Mot de passe'),
            'second_options'  =>  array('label' => 'Confirmer mot de passe'),
            'invalid_message' =>  'form.general.invalid.password'
        ));

        $builder->add('birthday', 'date', array(
            'widget' => 'single_text',
            'input' => 'datetime',
            'format' => 'dd/MM/y',
        ));

        $builder->add('localisations', 'collection', array(
            'type' => new LocalisationType(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'cascade_validation' => true
        ));

        $builder->add('locked', 'checkbox', array('required' => false));
        $builder->add('news', 'checkbox', array('required' => false));
        $builder->add('enabled', 'checkbox', array('required' => false));
    }

    /**
     * Defualt options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Disko\UserBundle\Entity\User',
            'validation_groups' => array('Default', 'Admin'),
            'intention'  => 'Admin',
        ));
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
}
