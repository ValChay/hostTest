<?php

namespace App\Controller;

use App\Entity\HostTable;
use App\Entity\Meal;
use App\Entity\Reservation;
use App\Form\ReservationInMealType;
use App\Form\ReservationInTableType;
use App\Form\ReservationType;
use App\Repository\MealRepository;
use App\Repository\ReservationRepository;
use App\Services\ReservationChecker;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    /*public function findLatest(UserRepository $UserShow)
    {
        $user = $UserShow->findLatest();

        return $this->render( 'baseadmin.html.twig', [
            'users'=>$user,
        ]);
    }*/

    /**
     * @Route("/new", name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setCreatedAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newResa", name="new_reservation", methods={"POST"})
     *
     */
    public function newResa(Request $request, MealRepository $mealRepository): Response
    {
//        dump($request->request);

//        $meal = $mealRepository->find($request->request['reservation']['meal']);

        $reservation = new Reservation();
        $form = $this->createForm(ReservationInTableType::class, $reservation);
        $form->handleRequest($request);

        $reservation->setUser($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_show', array('id' => $reservation->getId()));
        }

        // Si la reservation ne peut pas être créé, redirige vers la page de la table
        $this->addFlash('warning', 'La reservation n\'a pas été créée.');
        return $this->redirect($request->headers->get('referer'));

    }

    /**
     * @Route("/resaMeal/{id}", name="reservation_meal", methods={"POST"})
     *
     */
    public function resaMeal(Meal $meal, Request $request, MealRepository $mealRepository, ReservationChecker $checker): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationInMealType::class, $reservation);
        $form->handleRequest($request);
        $reservation->setUser($this->getUser())->setMeal($meal);

        $isCapacityOk = $checker->checkIfCapacityOk($meal, $reservation);

        if ($form->isSubmitted() && $form->isValid() && $isCapacityOk) {
            $meal->setRemainingCapacity($meal->getRemainingCapacity() - $reservation->getGuestNumber());
            $reservationId = $this->flushReservation($reservation);
            return $this->redirectToRoute('reservation_show', array('id' => $reservationId));
        }

        // Si la reservation ne peut pas être créé, redirige vers la page de la table
        $this->addFlash('warning', $checker->getErrorMessage($meal, $reservation));
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index', [
                'id' => $reservation->getId(),
            ]);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }
        return $this->redirectToRoute('reservation_index');
    }

    public function flushReservation(Reservation $reservation)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reservation);
        $entityManager->flush();
        return $reservation->getId();
    }
}
