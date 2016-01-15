<?php

// src/AppBundle/Security/Authentication/Handler/LoginFailureHandler.php

namespace AppBundle\Security\Authentication\Handler;

use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoginFailureHandler extends DefaultAuthenticationFailureHandler {

    protected $httpKernel;
    protected $httpUtils;
    protected $logger;
    protected $options;
    protected $defaultOptions = array(
        'failure_path' => null,
        'failure_forward' => false,
        'login_path' => '/login',
        'failure_path_parameter' => '_failure_path',
    );
    private $router;
    private $fosUM;
    private $mailer;
    private $templating;

    /**
     * Constructor.
     *
     * @param HttpKernelInterface $httpKernel
     * @param HttpUtils           $httpUtils
     * @param array               $options    Options for processing a failed authentication attempt.
     * @param LoggerInterface     $logger     Optional logger
     */
    public function __construct(HttpKernelInterface $httpKernel, HttpUtils $httpUtils, array $options = [], LoggerInterface $logger = null, Router $router, UserManager $fosUM, ContainerInterface $container) {
        $this->httpKernel = $httpKernel;
        $this->httpUtils = $httpUtils;
        $this->logger = $logger;
        $this->setOptions($options);

        $this->mailer = $container->get('mailer');
        $this->templating = $container->get('templating');
        $this->router = $router;
        $this->fosUM = $fosUM;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        if ($request->request->has('_username')) {
            $username = $request->request->get('_username');
        } else {
            $username = '';
        }
        //if ($exception->getMessage() === 'Captcha is invalid') {
            
        //} else {
            
            $failedLoginIp = $request->getClientIp();
            $user = $this->fosUM->findUserByUsername($username);
            if($user){
                $failedLogin = $user->getFailedLogin();
                $failedLogin++;
                $user->setFailedLogin($failedLogin);
                $user->setFailedLoginIp($failedLoginIp);

                if ($failedLogin === 3 ){

                    //email do użytkownika i admina
                    $message = \Swift_Message::newInstance()
                            ->setSubject('Nieautoryzowane próby dostępu do konta')
                            ->setFrom('noreply@bms.klimbest.pl')
                            ->setTo(array('pawel.zajder@klimbest.pl', $user->getEmail()))
                            ->setBody($username . ' próbował zalogować się zbyt wiele razy z adresu IP: ' . $failedLoginIp . ' ' . $exception->getMessage());

                    $this->mailer->send($message);
                }
                if($failedLogin === 5){
                    $user->setLocked(1);
                }

                $this->fosUM->updateUser($user);
            }
            
        //}
        $url = 'fos_user_security_login';
        $response = new RedirectResponse($this->router->generate($url));

        return $response;
    }

}
