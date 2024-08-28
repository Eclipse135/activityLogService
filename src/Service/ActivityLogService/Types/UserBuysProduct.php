<?php

namespace App\Service\ActivityLogService\Types;

use App\Entity\ActivityLog;
use App\Service\ActivityLogService\ActivityLogInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserBuysProduct implements ActivityLogInterface
{
    public function getTypeTitle(ActivityLog $activityLog): string
    {
        return 'User bought product';
    }

    public function getMessage(ActivityLog $activityLog, UrlGeneratorInterface $urlGenerator): string
    {
        $data = $activityLog->getData();

        return sprintf(
            'User <a class="underline" href="%s">%s</a> bought product <a class="underline" href="%s">%s</a>',
            $urlGenerator->generate('app_user_show', ['id' => $data['user_id']]),
            $data['user_name'],
            $urlGenerator->generate('app_product_show', ['id' => $data['product_id']]),
            $data['product_name']
        );
    }

    public function normalize(array $data): array
    {
        return [
            'user_id' => $data['user']->getId(),
            'user_name' => $data['user']->getName(),
            'product_id' => $data['product']->getId(),
            'product_name' => $data['product']->getName(),
        ];
    }
}
