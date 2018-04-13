<?php
/**
 * Created by PhpStorm.
 * User: zmaslo
 * Date: 13.04.18
 * Time: 11:48
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('hello!');
    }

    /**
     * @Route("/student/{student}")
     */
    public function show($student){
        return new Response(sprintf('Strona o uczniu: %s',
            $student
        ));
    }
}