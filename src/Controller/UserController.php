<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ObjectManager $manager)
    {
        return $this->render('user/index.html.twig', [
            'users' => $manager->getRepository(User::class)->findAll()
        ]);
    }

    /**
     * @Route("/registration", name="security_registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profile', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('user/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request,AuthenticationUtils $authenticationUtils )
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
        return $this->render('user/logout.html.twig');
    }



    /**
     * @Route("/user/{id}", name="profile")
     * @param User $profile
     */
    public function profile(User $profile)
    {
        if (!$profile) {
            return $this->redirectToRoute('security_login');
        }

        return $this->render('user/profile.html.twig', [
            'profile' => $profile
        ]);
    }
}
