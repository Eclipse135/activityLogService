<?php

namespace App\Service\ActivityLogService;

use App\Entity\ActivityLog;
use App\Repository\ActivityLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActivityLogService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ActivityLogRepository $activityLogRepository,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function logActivity(ActivityLogInterface $activityLogClass, array $data): void
    {
        $activityLog = new ActivityLog();
        $activityLog->setType(get_class($activityLogClass));
        $activityLog->setData($activityLogClass->normalize($data));

        $this->entityManager->persist($activityLog);
        $this->entityManager->flush();
    }

    public function getActivityTypeTitle(ActivityLog $activityLog): string
    {
        $activityLogClass = $this->getActivityClass($activityLog->getType());

        return $activityLogClass->getTypeTitle($activityLog);
    }

    public function getActivityMessage(ActivityLog $activityLog): string
    {
        $activityLogClass = $this->getActivityClass($activityLog->getType());

        return $activityLogClass->getMessage($activityLog, $this->urlGenerator);
    }

    public function getActivityLogs(int $limit = 50, int $offset = 0): array
    {
        $activityLogs = $this->activityLogRepository->findBy([], ['createdAt' => 'DESC'], $limit, $offset);

        foreach ($activityLogs as $activityLog) {
            $activityLog->setMessage($this->getActivityMessage($activityLog));
            $activityLog->setTypeTitle($this->getActivityTypeTitle($activityLog));
        }

        return $activityLogs;
    }

    private function getActivityClass(string $activityTypeClass): ActivityLogInterface
    {
        /*
         * Not sure if I shouldn't use container->get() instead of creating new object...
         * but using container as far as I checked is discouraged in symfony
         */

        return new $activityTypeClass();
    }
}
