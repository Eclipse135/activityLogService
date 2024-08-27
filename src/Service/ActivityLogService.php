<?php

namespace App\Service;

use App\Entity\ActivityLog;
use App\Entity\Product;
use App\Entity\User;
use App\Enum\ActivityLogType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActivityLogService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    private function log(ActivityLogType $type, array $data): void
    {
        $activityLog = new ActivityLog();
        $activityLog->setType($type);
        $activityLog->setData($data);

        $this->entityManager->persist($activityLog);
        $this->entityManager->flush();
    }

    public function getActivityType(ActivityLog $activityLog): string
    {
        return match ($activityLog->getType()) {
            ActivityLogType::USER_BUYS_PRODUCT => 'User bought product',
            ActivityLogType::PRODUCT_GRANTED_TO_USER_VIA_ADMIN_PANEL => 'Product granted to user via admin panel',
            ActivityLogType::ADMIN_EDITED_PRODUCT => 'Admin edited product',
        };
    }

    public function getActivityMessage(ActivityLog $activityLog): string
    {
        $data = $activityLog->getData();

        return match ($activityLog->getType()) {
            ActivityLogType::USER_BUYS_PRODUCT => sprintf(
                'User <a class="underline" href="%s">%s</a> bought product <a class="underline" href="%s">%s</a>',
                $this->urlGenerator->generate('app_user_show', ['id' => $data['userId']]),
                $data['userName'],
                $this->urlGenerator->generate('app_product_show', ['id' => $data['productId']]),
                $data['productName']
            ),
            ActivityLogType::PRODUCT_GRANTED_TO_USER_VIA_ADMIN_PANEL => sprintf(
                'Admin <a class="underline" href="%s">%s</a> granted product <a class="underline" href="%s">%s</a> to user <a class="underline" href="%s">%s</a> via admin panel',
                $this->urlGenerator->generate('app_user_show', ['id' => $data['adminId']]),
                $data['adminName'],
                $this->urlGenerator->generate('app_product_show', ['id' => $data['productId']]),
                $data['productName'],
                $this->urlGenerator->generate('app_user_show', ['id' => $data['userId']]),
                $data['userName']
            ),
            ActivityLogType::ADMIN_EDITED_PRODUCT => sprintf(
                'Admin <a class="underline" href="%s">%s</a> edited product <a class="underline" href="%s">%s</a>',
                $this->urlGenerator->generate('app_user_show', ['id' => $data['adminId']]),
                $data['adminName'],
                $this->urlGenerator->generate('app_product_show', ['id' => $data['productId']]),
                $data['productName']
            ),
        };
    }

    public function logUserBuysProduct(User $user, Product $product): void
    {
        $this->log(ActivityLogType::USER_BUYS_PRODUCT, [
            'userId' => $user->getId(),
            'userName' => $user->getName(),
            'productId' => $product->getId(),
            'productName' => $product->getName(),
        ]);
    }

    public function logProductGrantedToUser(User $admin, User $user, Product $product): void
    {
        $this->log(ActivityLogType::PRODUCT_GRANTED_TO_USER_VIA_ADMIN_PANEL, [
            'userId' => $user->getId(),
            'userName' => $user->getName(),
            'productId' => $product->getId(),
            'productName' => $product->getName(),
            'adminId' => $admin->getId(),
            'adminName' => $admin->getName(),
        ]);
    }

    public function logAdminEditedProduct(User $admin, Product $product): void
    {
        $this->log(ActivityLogType::ADMIN_EDITED_PRODUCT, [
            'adminId' => $admin->getId(),
            'adminName' => $admin->getName(),
            'productId' => $product->getId(),
            'productName' => $product->getName(),
        ]);
    }

    public function getActivityLogs(int $limit = 50, int $offset = 0): array
    {
        $activityLogs = $this->entityManager
            ->getRepository(ActivityLog::class)
            ->findBy([], ['createdAt' => 'DESC'], $limit, $offset);

        foreach ($activityLogs as $activityLog) {
            $activityLog->setMessage($this->getActivityMessage($activityLog));
            $activityLog->setTypeTitle($this->getActivityType($activityLog));
        }

        return $activityLogs;
    }
}
