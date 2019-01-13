<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchFormType;
use App\Repository\HostTableRepository;
use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(HostTableRepository $hostTableRepository, MealRepository $mealRepository, Request $request)
    {

        // Création d'un formulaire de recherche
        $searchForm = $this->createForm(SearchFormType::class);
        // Gestion de la request
        $searchForm->handleRequest($request);

        // Quand le formulaire est validé, va faire une recherche avec les donnés du formulaire (voir HostTableRepository pour le détail)
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $listTable = $hostTableRepository->findIndexSearch($searchForm->getData());
            $listMeal = $mealRepository->findIndexSearch($searchForm->getData());
        } else {
            // Quand le formulaire n'est pas valider, revoi les 4 dernieres tables
            $listTable = $hostTableRepository->findLimit();
            $listMeal = $mealRepository->findLimit();
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Best table',
            'listTable' => $listTable,
            'listMeal' => $listMeal,
            'searchForm' => $searchForm->createView()
        ]);
    }
}
