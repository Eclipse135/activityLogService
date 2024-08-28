<?php

namespace App\Service\ActivityLogService;

use App\Entity\ActivityLog;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

interface ActivityLogInterface
{
    public function getTypeTitle(ActivityLog $activityLog): string;

    public function getMessage(ActivityLog $activityLog, UrlGeneratorInterface $urlGenerator): string;

    public function normalize(array $data): array;
}
