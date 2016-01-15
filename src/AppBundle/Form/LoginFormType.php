<?php

//src/AppBundle/Form/LoginFormType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class LoginFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('_csrf_token', HiddenType::class)
                ->add('_username', EmailType::class, array(
                    'label' => 'form.email',
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array('placeholder' => 'Adres e-mail'
            )))
                ->add('_password', PasswordType::class, array(
                    'label' => 'form.password',
                    'translation_domain' => 'FOSUserBundle',
                    'mapped' => false,
                    'attr' => array('placeholder' => 'Hasło'
            )))
                ->add('captcha', CaptchaType::class, array(
                    'label' => 'Przepisz kod z obrazka',
                    'reload' => "/login",
                    'as_url' => true
        ));
    }

    public function getBlockPrefix() {
        return null;
    }

}
