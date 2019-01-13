<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\HostTableRepository;
use App\Repository\MealRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

   /* public function findLimit(UserRepository $UserShow)
    {
        $user = $UserShow->findLatest();

        return $this->render( 'baseadmin.html.twig', [
            'users'=>$user,
        ]);
    }*/

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        // Si on est connecté on ne pourra pas accéder à l'inscription
        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_USER')){
            return $this->redirectToRoute('home');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('Password')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id" = "\d+"} , name="user_show", methods={"GET"})
     *
     */
    // Il a fallut mettre une option sur la route sinon on accéder pas à la route detailUser
    // il interprété /detail en /id
    public function show(User $user): Response
    {

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * @Route("/detail_user", name="user_detail", methods={"GET"})
     * @isGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function detailUser(ReservationRepository $reservationRepository, HostTableRepository $hostTableRepository): Response
    {
        $user = $this->getUser();
        dump($user);
        $resa= $reservationRepository->findBy(['user' => $user]);
        dump($resa);
        $tables = $hostTableRepository->findBy(['user' => $user]);

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'reservations' => $resa,
            'tables' => $tables
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     *
     */
    public function edit(Request $request, User $user): Response
    {

        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
