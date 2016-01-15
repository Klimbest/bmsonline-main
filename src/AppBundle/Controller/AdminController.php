<?php

//src/AppBundle/Controller/AdminController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Invitation;
use AppBundle\Form\NewInviteType;
use AppBundle\Entity\Target;
use AppBundle\Form\NewTargetType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\SchemaTool;

class AdminController extends Controller {

    //Strona główna panelu administratora
    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        //pobranie z bazy tablicy z obiektami wszsytkich
        // użytkowników zarejestrowanych w systemie
        $users = $em->createQueryBuilder()
                ->select('u')
                ->from('AppBundle:User', 'u')
                ->orderBy('u.locked', 'DESC')
                ->getQuery()
                ->getResult();
        //pobranie z bazy tablicy z obiektami wszsytkich
        //obiektów utworzonych w systemie
        $targets = $em->createQueryBuilder()
                ->select('t')
                ->from('AppBundle:Target', 't')
                ->getQuery()
                ->getResult();
        //wyrenderowanie szablonu strony głównej panelu admina
        //przekazanie tablic użytkowników i obiektów do szablonu
        return $this->render('AppBundle:Admin:index.html.twig', array(
                    'users' => $users,
                    'targets' => $targets
        ));
    }

    public function inviteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $invite = new Invitation();
        $form = $this->createForm(NewInviteType::class, $invite);
        //Jeśli przekierowanie na kontroler wystąpiło przez przesłanie danych z formularza
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            //Jeśli formularz poprawnie wypełniony
            if ($form->isValid()) {
                $email = $form['email']->getData();

                $invite->setEmail($email);
                $invite->send();
                $em->persist($invite);
                $em->flush();

                $code = $invite->getCode();
                $message = \Swift_Message::newInstance()
                        ->setSubject('Zaproszenie do systemu BMS')
                        ->setFrom('noreply@bms.klimbest.pl')
                        ->setTo($email)
                        ->setBody(
                        $this->renderView(
                                'Emails/invitation.html.twig', array('code' => $code = $invite->getCode())
                        ), 'text/html'
                );
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('app_admin_page'));
            }
        }
        return $this->render('AppBundle:Admin:invite.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    //Odblokowanie użytkownika w systemie
    public function enableAction($username) {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        $user->setLocked(false);
        $userManager->updateUser($user);

        return $this->redirect($this->generateUrl('app_admin_page'));
    }

    //Zablokowanie użytkownika w systemie
    public function disableAction($username) {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        $user->setLocked(true);
        $userManager->updateUser($user);

        return $this->redirect($this->generateUrl('app_admin_page'));
    }

    //Przejście do edycji użytkownika
    public function editUserAction($username) {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        //Pobranie obiektów do których ma dostęp użytkownik
        $user_targets = $em->createQueryBuilder()
                ->select('t')
                ->from('AppBundle:Target', 't')
                ->innerJoin('t.users', 'u')
                ->where('u.id = :userID')
                ->setParameter('userID', $user_id = $user->getId())
                ->getQuery()
                ->getResult();
        //Pobranie pozostałych dostępnych obiektów
        $qb = $em->createQueryBuilder()
                ->select('t')
                ->from('AppBundle:Target', 't');
        foreach ($user_targets as $user_target)
            $qb = $qb->andWhere('t.id != ' . $user_target->getId());
        $targets = $qb->getQuery()->getResult();
        return $this->render('AppBundle:Admin:editUser.html.twig', array(
                    'user' => $user,
                    'targets' => $targets,
                    'user_targets' => $user_targets
        ));
    }

    //Dodanie uprawnień użytkownikowi
    public function addRoleAction($username, Request $request) {
        //Pobranie menadżerów pobierania danych z bazy
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');
        //Pobranie użytkownika z bazy danych 
        $user = $userManager->findUserByUsername($username);
        //Pobranie z formularza zaznaczonych uprawnień
        $roles = $request->get('targets');
        //Dodanie użytkonikowi nowych uprawnień
        if (isset($roles)) {
            foreach ($roles as $role) {
                $user->addRole("ROLE_" . $role);
                $target = $em->find("\AppBundle\Entity\Target", $role);
                $target->addUser($user);
                $user->addTarget($target);
                $em->persist($user);
                $em->persist($target);
                $em->flush();
            }
        }
        //Odblokowanie jeśli jest zablokowany
        if ($user->isLocked()) {
            $user->setLocked(false);
        }
        //Zaktualizowanie obiektu 
        $userManager->updateUser($user);

        return $this->redirect($this->generateUrl('app_admin_edit_role', array(
                            'username' => $username
        )));
    }

    //Usunięcie uprawnień użytkownikowi
    public function removeRoleAction($username, Request $request) {
        //Pobranie menadżerów pobierania danych z bazy
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');
        //Pobranie użytkownika z bazy danych 
        $user = $userManager->findUserByUsername($username);
        //Pobranie z formularza zaznaczonych uprawnień
        $roles = $request->get('targets');
        //Usunięcie użytkonikowi zaznaczonych uprawnień
        if (isset($roles)) {
            foreach ($roles as $role) {
                $user->removeRole("ROLE_" . $role);
                $target = $em->find("\AppBundle\Entity\Target", $role);
                $target->removeUser($user);
                $user->removeTarget($target);
                $em->persist($user);
                $em->persist($target);
                $em->flush();
            }
        }
        //Zaktualizowanie obiektu 
        $userManager->updateUser($user);


        return $this->redirect($this->generateUrl('app_admin_edit_role', array(
                            'username' => $username
        )));
    }

    public function addTargetAction(Request $request) {
        $target = new Target();
        $form = $this->createForm(NewTargetType::class, $target);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            //Jeśli formularz poprawnie wypełniony
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $name = $form['name']->getData();

                $target->setName($name);

                $em->persist($target);
                $em->flush();


                /** @var ClassMetadata $metadata */
                $metadata = $em->getClassMetadata('AppBundle:Device');
                $metadata->setPrimaryTable(array($target->getId() . '_' . 'name' => $metadata->getTableName()));

                $schemaTool = new SchemaTool($em);
                $schemaTool->createSchema(array($metadata));

                return $this->redirect($this->generateUrl('app_admin_page'));
            }
        }
        return $this->render('AppBundle:Admin:newTarget.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
