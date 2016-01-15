<?php
//src/AppBundle/Controller/SecurityController.php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use AppBundle\Form\LoginFormType;

class SecurityController extends Controller {

    public function loginAction(Request $request) {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        if (class_exists('\Symfony\Component\Security\Core\Security')) {
            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;
        }

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        if ($this->has('security.csrf.token_manager')) {
            $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
        } else {
            // BC for SF < 2.4
            $csrfToken = $this->has('form.csrf_provider') ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate') : null;
        }

        $form = $this->get('form.factory')->create(new LoginFormType(), null);
        
        return $this->renderLogin(array(
                    'last_username' => $lastUsername,
                    'error' => $error,
                    'csrf_token' => $csrfToken,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data) {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($data['last_username']);
        
        if ($user) {
            $fl = $user->getFailedLogin();
        } else {
            $fl = 0;
        }

        if ($fl == 0) {
            return $this->render('FOSUserBundle:Security:login.html.twig', $data);
        } elseif ($fl == 1) {
            return $this->render('FOSUserBundle:Security:login2.html.twig', $data);
        } elseif ($fl == 2) {
            return $this->render('FOSUserBundle:Security:login3.html.twig', $data);
        } elseif ($fl == 3) {
            
            //blokada konta
            return $this->render('FOSUserBundle:Security:login3.html.twig', $data);
        } elseif ($fl > 3) {
            //brak reakcji na submit
            return $this->render('FOSUserBundle:Security:login3.html.twig', $data);
        }
    }

}
