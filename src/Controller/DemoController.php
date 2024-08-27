<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Service\ActivityLogService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

class DemoController extends AbstractController
{
    #[Route('/', name: 'app_demo')]
    public function index(ActivityLogService $activityLogService): Response
    {
        $logs = $activityLogService->getActivityLogs();

        return $this->render('demo/index.html.twig',
            compact('logs'),
        );
    }

    #[Route('/action', name: 'app_demo_action', methods: ['POST'])]
    public function action(Request $request, ActivityLogService $activityLogService, EntityManagerInterface $entityManager): Response
    {
        $action = $request->request->get('action');

        if (!$action) {
            throw new BadRequestHttpException('Action required!');
        }

        $productRepository = $entityManager->getRepository(Product::class);
        $userRepository = $entityManager->getRepository(User::class);

        switch ($action) {
            case 'buy_product':
                $activityLogService->logUserBuysProduct($userRepository->findRandom(), $productRepository->findRandom());
                break;
            case 'edit_product':
                $activityLogService->logAdminEditedProduct($userRepository->findRandomAdmin(), $productRepository->findRandom());
                break;
            case 'grant_product':
                $activityLogService->logProductGrantedToUser($userRepository->findRandomAdmin(), $userRepository->findRandom(), $productRepository->findRandom());
                break;
            default:
                throw new BadRequestHttpException('Action does not exist!');
        }

        $this->addFlash('success', 'Log Added!');

        return $this->redirectToRoute('app_demo');
    }
}
