<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\Clock\now;

class DemoController extends AbstractController
{
    #[Route('/', name: 'app_demo')]
    public function index(): Response
    {
        $logs = [
            [
                'date' => now()->format('Y-m-d'),
                'type' => 'test_type',
                'message' => 'Hello World!',
            ],
        ];

        return $this->render('demo/index.html.twig',
            compact('logs'),
        );
    }

    #[Route('/', name: 'app_demo_action', methods: ['POST'])]
    public function action(Request $request)
    {
        $action = $request->request->get('action');

        if (!$action) {
            throw new BadRequestHttpException('Action required!');
        }

        return $this->redirectToRoute('app_demo');
    }
}
