<?php

declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
	/**
	 * @Route("/", name="index", methods={"GET"})
	 */
	public function index(Request $request): RedirectResponse {
		return $this->redirectToRoute('home', ['_locale' => $request->getLocale()]);
	}
	
	/**
	 * @Route("/{_locale}", name="home", methods={"GET"}, requirements={"_locale": "en|et"})
	 */
	public function homeLocale(): Response {
		return $this->render('home/home.html.twig');
	}
	
	/**
	 * @Route("/{_locale}/terms-and-conditions", name="terms_and_conditions", methods={"GET"}, requirements={"_locale": "en|et"})
	 */
	public function terms(): Response {
		return $this->render('home/terms-and-conditions.html.twig');
	}
}