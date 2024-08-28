<?php

namespace App\Service\ActivityLogService\Types;

use App\Entity\ActivityLog;
use App\Service\ActivityLogService\ActivityLogInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GrantProductToUserViaAdminPanel implements ActivityLogInterface
{
    public function getTypeTitle(ActivityLog $activityLog): string
    {
        return 'Product granted to user via admin panel';
    }

    public function getMessage(ActivityLog $activityLog, UrlGeneratorInterface $urlGenerator): string
    {
        $data = $activityLog->getData();

        return sprintf(
            'Admin <a class="underline" href="%s">%s</a> granted product <a class="underline" href="%s">%s</a> to user <a class="underline" href="%s">%s</a> via admin panel',
            $urlGenerator->generate('app_user_show', ['id' => $data['admin_id']]),
            $data['admin_name'],
            $urlGenerator->generate('app_product_show', ['id' => $data['product_id']]),
            $data['product_name'],
            $urlGenerator->generate('app_user_show', ['id' => $data['user_id']]),
            $data['user_name']
        );
    }

    public function normalize(array $data): array
    {
        return [
            'admin_id' => $data['admin']->getId(),
            'admin_name' => $data['admin']->getName(),
            'user_id' => $data['user']->getId(),
            'user_name' => $data['user']->getName(),
            'product_id' => $data['product']->getId(),
            'product_name' => $data['product']->getName(),
        ];
    }
}
