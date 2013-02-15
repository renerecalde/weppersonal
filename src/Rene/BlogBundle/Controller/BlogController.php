<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// src/Blogger/BlogBundle/Controller/BlogController.php

namespace Rene\BlogBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Blog controller.
 */
class BlogController extends Controller
{
    /**
     * Show a blog entry
     */
    public function showAction($id, $slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $blog = $em->getRepository('ReneBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('No es posible encontrar este blog.');
        }

        $comments = $em->getRepository('ReneBlogBundle:Comment')
                   ->getCommentsForBlog($blog->getId());

        return $this->render('ReneBlogBundle:Blog:show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }
}
?>
