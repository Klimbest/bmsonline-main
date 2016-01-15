<?php

//src/AppBundle/Form/OfferType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OfferType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', TextType::class, array('attr' => array(
                        'placeholder' => 'Twoje imie',
                    ),
                    'label' => false))
                ->add('contact', TextType::class, array('attr' => array(
                        'placeholder' => 'Twój numer lub e-mail',
                    ),
                    'label' => false))
                ->add('message', TextareaType::class, array('attr' => array(
                        'placeholder' => 'Wiadomość',
                        'rows' => 5
                    ),
                    'label' => false
        ));
    }

    public function getBlockPrefix() {
        return 'offer';
    }

}
