<?php

declare(strict_types = 1);

namespace App\Controller\Auth;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterController extends AbstractController {
	public function __construct(private EntityManagerInterface $em) { }
	
	/**
	 * @Route("/{_locale}/register", name="auth_register", methods={"GET", "POST"}, requirements={"_locale": "en|et"})
	 */
	public function register(Request $request, UserPasswordHasherInterface $hasher): Response {
		$user = new User();
		$form = $this->createForm(RegisterType::class, $user);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$user->setPassword($hasher->hashPassword($user, $form->get('plainPassword')->getData()));
			$user->eraseCredentials();
			$this->em->persist($user);
			$this->em->flush();
			return $this->render('auth/register_success.html.twig', ['user' => $user]);
		}
		return $this->render('auth/register.html.twig', ['registerForm' => $form->createView()]);
	}
	
	/**
	 * @Route("/register/check-username", name="auth_check_username", methods={"POST"})
	 */
	public function isUsernameInUse(Request $request, UserRepository $userRepository): Response {
		$user = $userRepository->findOneBy(['email' => $request->get('email')]);
		if ($user === null) {
			return $this->json([]);
		}
		return $this->json([], 400);
	}
}