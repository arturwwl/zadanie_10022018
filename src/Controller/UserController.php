<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            // save User
            $em->persist($user);

            // execute query
            $em->flush();

        }
        return $this->render('users/register.html.twig',[
            'register_form' => $form->createView(),
        ]);
    }

    /**
     * @param User $user
     * @Route("/check/{id}", name="check")
     * @return Response
     */
    public function check(User $user)
    {
        return new Response('Found user with id'.$user->getId());
    }
}
