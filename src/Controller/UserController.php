<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/users')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        // todo list users, with pagination
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/{id}', name: 'app_user_show')]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig',
            compact('user')
        );
    }
}
