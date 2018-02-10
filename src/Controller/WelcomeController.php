<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        return $this->render('welcome/index.html.twig');
//        return new Response('hello', Response::HTTP_OK);
    }

    /**
     * @Route(
     *     "/hello_page/{name}", name="hello_page"
     * )
     */
    public function hello(/*Request $request,*/ $name='')
    {
//        $request->query->get('name','noname');
        return $this->render('hello_page.html.twig',
            [
                'name' => $name,
            ]
        );
    }
}
