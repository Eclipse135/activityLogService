<?php

namespace App\Entity;

use App\Enum\ActivityLogType;
use App\Repository\ActivityLogRepository;
use App\Service\ActivityLogService;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ActivityLogRepository::class)]
class ActivityLog
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: ActivityLogType::class)]
    private ?ActivityLogType $type = null;

    #[ORM\Column]
    private array $data = [];

    private string $typeTitle;

    private string $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?ActivityLogType
    {
        return $this->type;
    }

    public function setType(ActivityLogType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getTypeTitle(): string
    {
        return $this->typeTitle;
    }

    public function setTypeTitle(string $typeTitle): void
    {
        $this->typeTitle = $typeTitle;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

}
