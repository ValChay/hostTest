<?php


namespace App\Controller;


use App\Repository\MealRepository;
use App\Repository\TableRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/hostSpace")
 */
class HostController extends AbstractController
{
    /**
     * @Route("/detail_host", name="host_detail", methods={"GET"})
     *
     */
       public function tableHost(TableRepository $tableRepository, MealRepository $mealRepository): Response
       {
           $user = $this->getUser();
           $table = $tableRepository->findBy(['user' => $user]);
           $meal = $mealRepository->findBy(['user' => $user]);

           return $this->render('user/show.html.twig', [
               'user' => $user,
               'table' => $table,
               'meal' => $meal,
           ]);
       }
}