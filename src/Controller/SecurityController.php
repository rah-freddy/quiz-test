<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    private $em;
    private $encoders;
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoders)
    {
        $this->em = $em;
        $this->encoders = $encoders;
    }
    #[Route('/register', name: 'security_registration')]
    public function registrationAction(Request $request): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form['username']->getData();
            $email = $form['email']->getData();
            $roles = ["ROLE_USER"];
            $hash = $this->encoders->encodePassword($user, $user->getPassword());
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setPassword($hash);

            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'security_login')]
    public function loginAction(): Response
    {
        return $this->render('security/login.html.twig');
    }

    #[Route('/logout', name: 'security_logout')]
    public function LogoutAction(): Response
    {
        return $this->redirectToRoute('security_login');
    }
}
