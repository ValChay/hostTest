<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Entity\Reservation;
use App\Form\MealCreateType;
use App\Form\MealType;
use App\Form\ReservationInMealType;
use App\Form\ReservationInTableType;
use App\Repository\MealRepository;
use App\Services\PersisterFlusher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/meal")
 */
class MealController extends AbstractController
{
    /**
     * @Route("/", name="meal_index", methods={"GET"})
     */
    public function index(MealRepository $mealRepository): Response
    {
        return $this->render('meal/index.html.twig', [
            'meals' => $mealRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="meal_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meal->setRemainingCapacity($meal->getCapacity());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meal);
            $entityManager->flush();

            return $this->redirectToRoute('meal_index');
        }

        return $this->render('meal/new.html.twig', [
            'meal' => $meal,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/create", name="create_meal", methods={"GET","POST"})
     * @IsGranted("ROLE_HOST")
     */
    public function createMeal(Request $request, PersisterFlusher $flusher): Response
    {
        $meal = new Meal();
        $form = $this->createForm(MealCreateType::class, $meal, array('user' => $this->getUser()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meal->setRemainingCapacity($meal->getCapacity());
            $mealID = $flusher->persistAndFlush($meal);
            return $this->redirectToRoute('meal_show', array('id' => $mealID));
        }

        return $this->render('meal/new.html.twig', [
            'meal' => $meal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="meal_show", methods={"GET"})
     */
    public function show(Meal $meal): Response
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationInMealType::class, $reservation, [
            'action' => $this->generateUrl('reservation_meal', array('id' => $meal->getId())),
        ]);
        return $this->render('meal/show.html.twig', [
            'meal' => $meal,
            'form_resa' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="meal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Meal $meal): Response
    {
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('meal_index', [
                'id' => $meal->getId(),
            ]);
        }

        return $this->render('meal/edit.html.twig', [
            'meal' => $meal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="meal_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Meal $meal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('meal_index');
    }
}
