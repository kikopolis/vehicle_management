<?php

declare(strict_types = 1);

namespace App\Controller\Auth;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController {
	/**
	 * @Route("/{_locale}/login", name="auth_login", requirements={"_locale":"en|et"})
	 */
	public function login(AuthenticationUtils $authenticationUtils): Response {
		$user = $this->getUser();
		if ($user instanceof User) {
			return $this->redirectToRoute('home', ['_locale' => $user->getLocale()]);
		}
		$error        = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();
		return $this->render('auth/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
	}
	
	/**
	 * @Route("/logout", name="auth_logout")
	 */
	public function logout(): void { }
}
