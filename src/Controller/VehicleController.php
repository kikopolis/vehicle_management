<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleType;
use App\Repository\VehicleRepository;
use App\Repository\VehicleTypeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/{_locale}/vehicles", name="vehicle_", requirements={"_locale":"en|et"})
 */
class VehicleController extends AbstractController {
	/**
	 * @Route("", name="index", methods={"GET"})
	 */
	public function index(VehicleTypeRepository $vehicleTypeRepository): Response {
		return $this->render('vehicle/index.html.twig', ['types' => $vehicleTypeRepository->findPublic()]);
	}
	
	/**
	 * @Route("/type/{slug}", name="list_by_type", methods={"GET"}, requirements={"slug":"^[a-zA-Z0-9]+(?:-[a-zA-Z0-9\-\_]+)*$"})
	 */
	public function byType(VehicleType $vehicleType, TranslatorInterface $translator, VehicleRepository $vehicleRepository): Response {
		return $this->render('vehicle/list.html.twig', [
			'vehicles' => $vehicleRepository->findForUserByType($this->getUser(), $vehicleType),
			'title'    => $translator->trans('vehicle.title.by_type', ['type' => $vehicleType->getName()]),
		]);
	}
	
	/**
	 * @Route("/{id}", name="by_id", methods={"GET"}, requirements={"id":"\d+"})
	 * @IsGranted("VIEW", subject="vehicle")
	 */
	public function vehicleById(Vehicle $vehicle): Response {
		return $this->render('vehicle/show.html.twig', ['vehicle' => $vehicle]);
	}
}