<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('dashboard_admin');
        }
        if ($this->isGranted('ROLE_AGRICULTEUR')) {
            return $this->redirectToRoute('dashboard_agriculteur');
        }
        return $this->redirectToRoute('dashboard_client');
    }

    #[Route('/dashboard/admin', name: 'dashboard_admin')]
    public function admin(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('dashboard/admin.html.twig', [
            'stats' => [
                'users'     => $userRepository->count([]),
                'articles'  => 0,
                'commandes' => 0,
                'threads'   => 0,
            ],
            'lastUsers' => $userRepository->findBy([], ['date_creation' => 'DESC'], 10),
        ]);
    }

    #[Route('/dashboard/client', name: 'dashboard_client')]
    public function client(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');

        return $this->render('dashboard/client.html.twig', [
            'user'      => $this->getUser(),
            'commandes' => [],
        ]);
    }

    #[Route('/dashboard/agriculteur', name: 'dashboard_agriculteur')]
    public function agriculteur(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_AGRICULTEUR');

        return $this->render('dashboard/agriculteur.html.twig', [
            'user'     => $this->getUser(),
            'articles' => [],
            'threads'  => [],
        ]);
    }
}
