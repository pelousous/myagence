<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PropertyController extends AbstractController
{
	/**
	* @var PropertyRepository
	**/
	private $repository;
	
	/**
	* @var ObjectManager
	**/
	
	public function __construct(PropertyRepository $repository) 
	{
		$this->repository = $repository;
	}
	
	/**
	* @Route("/biens", name="property.index")
	* @return Response
	**/
	public function index(): Response
	{
		$property = $this->repository->findAllVisible();

		return $this->render('property/index.html.twig', [
			'current_menu' => 'property'
		]);		
	}
	
	/**
	* @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
	* @return Response
	**/
	public function show($slug, $id): Response
	{
		
		$property = $this->repository->find($id);

		if($property->getSlug() !== $slug) {
			return $this->redirectToRoute('property.show', [
				'slug' => $property->getSlug(), 
				'id' => $property->getId()
			], 301);
		}
		
		return $this->render('property/show.html.twig', [
			'current_menu' => 'property',
			'property' => $property
		]);		
	}
}