<?php

//src/AppBundle/Form/NewInviteType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewInviteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('email', TextType::class, array(
            'attr' => array(
                'placeholder' => 'Podaj adres email zapraszanej osoby',
            ),
            'label' => false
        ));
    }

    public function getBlockPrefix() {
        return 'invitation_email';
    }

}
