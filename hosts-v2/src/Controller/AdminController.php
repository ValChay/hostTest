<?php

namespace App\Controller;

use App\Repository\HostTableRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(HostTableRepository $hostTableRepository, UserRepository $userRepository, ReservationRepository $reservationRepository)
    {
        $tables = $hostTableRepository->findLimit();
        $tablesUser = $userRepository->findLimit();
        $tablesResa = $reservationRepository->findLimit();


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'tables' => $tables,
            'tablesUser' => $tablesUser,
            'tablesResa' => $tablesResa,
        ]);
    }


}
