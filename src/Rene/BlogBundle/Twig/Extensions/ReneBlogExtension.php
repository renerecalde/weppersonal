<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Clase php que maneja la duracion de los tiempos de los comentarios.
 */
// src/Blogger/BlogBundle/Twig/Extensions/BloggerBlogExtension.php

namespace Rene\BlogBundle\Twig\Extensions;

class ReneBlogExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'created_ago' => new \Twig_Filter_Method($this, 'createdAgo'),
        );
    }

    public function createdAgo(\DateTime $dateTime)
    {
        $delta = time() - $dateTime->getTimestamp();
        if ($delta < 0)
            throw new \InvalidArgumentException("createdAgo is unable to handle dates in the future");

        $duration = "";
        if ($delta < 60)
        {
            // Seconds
            $time = $delta;
            $duration =  " hace ". $time . " segundo" . (($time > 1) ? "s" : "") ;
        }
        else if ($delta <= 3600)
        {
            // Mins
            $time = floor($delta / 60);
            $duration = " hace ".$time . " minuto" . (($time > 1) ? "s" : "") ;
        }
        else if ($delta <= 86400)
        {
            // Hours
            $time = floor($delta / 3600);
            $duration = " hace ".$time . " hora" . (($time > 1) ? "s" : "") ;
        }
        else
        {
            // Days
            $time = floor($delta / 86400);
            $duration = " hace ".$time . " dia" . (($time > 1) ? "s" : "") ;
        }

        return $duration;
    }

    public function getName()
    {
        return 'rene_blog_extension';
    }
}
?>
