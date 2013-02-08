<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Rene\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import new namespaces
use Rene\BlogBundle\Entity\Enquiry;
use Rene\BlogBundle\Form\EnquiryType;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();

        
        $blogs = $em->getRepository('ReneBlogBundle:Blog')
                    ->getLatestBlogs();

        return $this->render('ReneBlogBundle:Page:index.html.twig', array(
            'blogs' => $blogs
        ));
    }
    
    public function aboutAction()
    {
        return $this->render('ReneBlogBundle:Page:about.html.twig');
    }
    public function contactAction()
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                // Perform some action, such as sending an email

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                 $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from symblog')
                    ->setFrom('enquiries@symblog.co.uk')
                    ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                    ->setBody($this->renderView('ReneBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                 $this->get('mailer')->send($message);

                 $this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('ReneBlogBundle_contact'));
            }
        }   

        return $this->render('ReneBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
?>
