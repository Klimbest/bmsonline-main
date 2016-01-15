<?php
//src/AppBundle/Controller/HomepageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\OfferType;


class HomepageController extends Controller {

    public function indexAction() {
       /* $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_USER')) {
            $user = $this->getUser();
            $targets = $user->getTargets();
            $target = $targets[0];
            $url = $this->generateUrl('app_bms_index', array(
                        'target_id' => $target->getId() 
            ));
            return $this->redirect($url);
        } else {*/
        
        $form = $this->createForm(OfferType::class);
        
        
            
        return $this->render('AppBundle:Homepage:index.html.twig', array(
                    'form' => $form->createView()
        ));
        
    }
    
    public function contactAction(Request $request){
        
        $form = $this->createForm(OfferType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $contact = $form['contact']->getData();
            $name = $form['name']->getData();
            $message = $form['message']->getData();
            $mail = \Swift_Message::newInstance()
                        ->setSubject('Zainteresowanie ofertą od '.$name)
                        ->setFrom('noreply@bms.klimbest.pl')
                        ->setTo('pawel.zajder@klimbest.pl')
                        ->setBody(
                                $this->renderView(
                                    'Emails/offer.html.twig',
                                    array('contact' => $contact, 'name' => $name, 'message' => $message)
                                ),
                                'text/html'
                        );
                $this->get('mailer')->send($mail);
        }
       
        $url = $this->generateUrl('app_homepage');
        return $this->redirect($url);
    }
    
    public function menuAction(){
        return $this->render('AppBundle:Homepage:menu.html.twig');
    }
    
    public function aboutWhyAction(){
        return $this->render('AppBundle:Homepage:aboutWhy.html.twig');
    }

    public function aboutWhoAction(){
        return $this->render('AppBundle:Homepage:aboutWho.html.twig');
    }
    
    public function aboutHowMuchAction(){
        return $this->render('AppBundle:Homepage:aboutHowMuch.html.twig');
    }
    
    public function privatePolicyAction(){
        return $this->render('AppBundle:Homepage:privatePolicy.html.twig');
    }
}
