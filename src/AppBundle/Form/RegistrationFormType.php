<?php
//src/AppBundle/Form/RegistrationFormType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                        'invitation', 
                        'app_invitation_type', 
                        array(
                            'label' => 'Kod zaproszenia:'
                        ))
                ->remove('username');
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}