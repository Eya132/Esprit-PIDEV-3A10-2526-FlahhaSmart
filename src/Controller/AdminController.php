<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\AdminUserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/dashboard/admin')]
class AdminController extends AbstractController
{
    #[Route('/users', name: 'admin_users')]
    public function users(Request $request, UserRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $search = $request->query->get('search', '');
        $role   = $request->query->get('role', '');
        $status = $request->query->get('status', '');

        $qb = $repo->createQueryBuilder('u')->orderBy('u.date_creation', 'DESC');

        if ($search) {
            $qb->andWhere('u.nom LIKE :search OR u.prenom LIKE :search OR u.email LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
        if ($role) {
            $qb->andWhere('u.role = :role')->setParameter('role', $role);
        }
        if ($status !== '') {
            $qb->andWhere('u.actif = :status')->setParameter('status', $status === 'actif');
        }

        $users = $qb->getQuery()->getResult();

        $stats = [
            'total'        => $repo->count([]),
            'admins'       => $repo->count(['role' => 'ADMINISTRATEUR']),
            'agriculteurs' => $repo->count(['role' => 'AGRICULTEUR']),
            'clients'      => $repo->count(['role' => 'CLIENT']),
            'actifs'       => $repo->count(['actif' => true]),
            'inactifs'     => $repo->count(['actif' => false]),
        ];

        return $this->render('admin/users.html.twig', [
            'users'  => $users,
            'search' => $search,
            'role'   => $role,
            'status' => $status,
            'stats'  => $stats,
        ]);
    }

    #[Route('/users/new', name: 'admin_user_new')]
    public function newUser(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new Users();
        $form = $this->createForm(AdminUserFormType::class, $user, ['is_new' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($hasher->hashPassword($user, $plainPassword));
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur créé avec succès !');
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/user_form.html.twig', [
            'form'  => $form->createView(),
            'title' => 'Ajouter un utilisateur',
            'user'  => null,
        ]);
    }

    #[Route('/users/{id}/edit', name: 'admin_user_edit')]
    public function editUser(
        int $id,
        Request $request,
        UserRepository $repo,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $repo->find($id);
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable.');
            return $this->redirectToRoute('admin_users');
        }

        $form = $this->createForm(AdminUserFormType::class, $user, ['is_new' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $user->setPassword($hasher->hashPassword($user, $plainPassword));
            }
            $em->flush();
            $this->addFlash('success', 'Utilisateur modifié avec succès !');
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/user_form.html.twig', [
            'form'  => $form->createView(),
            'title' => 'Modifier ' . $user->getFullName(),
            'user'  => $user,
        ]);
    }

    #[Route('/users/{id}/toggle', name: 'admin_user_toggle', methods: ['POST'])]
    public function toggleUser(
        int $id,
        UserRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $repo->find($id);
        if ($user) {
            $user->setActif(!$user->isActif());
            $em->flush();
            $this->addFlash('success', 'Statut mis à jour.');
        }
        return $this->redirectToRoute('admin_users');
    }

    #[Route('/users/{id}/delete', name: 'admin_user_delete', methods: ['POST'])]
    public function deleteUser(
        int $id,
        UserRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $repo->find($id);
        if ($user) {
            if ($user->getEmail() === $this->getUser()->getUserIdentifier()) {
                $this->addFlash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
                return $this->redirectToRoute('admin_users');
            }
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur supprimé.');
        }
        return $this->redirectToRoute('admin_users');
    }
}