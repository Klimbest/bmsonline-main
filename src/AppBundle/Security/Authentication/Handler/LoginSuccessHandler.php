<?php

// src/AppBundle/Security/Authentication/Handler/AuthenticationListener.php

namespace AppBundle\Security\Authentication\Handler;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use FOS\UserBundle\Doctrine\UserManager;

/**
 * Custom authentication success handler
 */
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    private $router;
    private $fosUM;
    private $authorization_checker;

    /**
     * 
     * @param Router $router
     * @param UserManager $fosUM
     * @param AuthorizationChecker $authorization_checker
     */
    public function __construct(Router $router, UserManager $fosUM, AuthorizationChecker $authorization_checker) {
        $this->router = $router;
        $this->fosUM = $fosUM;
        $this->authorization_checker = $authorization_checker;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This 
     * is called by authentication listeners inheriting from AbstractAuthenticationListener.
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

        $user = $token->getUser();
        $failedLogin = 0;
        $user->setFailedLogin($failedLogin);
        $failedLoginIp = null;
        $user->setFailedLoginIp($failedLoginIp);
        $this->fosUM->updateUser($user);

        if ($this->authorization_checker->isGranted('ROLE_SUPERADMIN')) {
            $url = 'app_admin_page';
            $response = new RedirectResponse($this->router->generate($url));
        } else {
            $targets = $user->getTargets();
            if (sizeof($targets) != 1) {
                $url = 'app_homepage_menu';
                $response = new RedirectResponse($this->router->generate($url));
            } else {
                $url = 'bms_index';
                $tid = $targets[0]->getId();
                $tname = $targets[0]->getName();
                $session = $request->getSession();
                $session->set('target_id', $tid);
                $session->set('target_name', $tname);
                $session->set('target', $targets[0]);
                //$response = new RedirectResponse("http://tid.bmsonline.dev/app_dev.php/");
                $response = new RedirectResponse("http://tid.bmsonline.dev/app_dev.php/");
            }
        }

        return $response;
    }

}
