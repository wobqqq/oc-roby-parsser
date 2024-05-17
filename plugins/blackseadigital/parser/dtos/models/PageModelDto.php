<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Dtos\Models;

use BlackSeaDigital\Parser\Enums\PageStatus;
use October\Rain\Argon\Argon;

final readonly class PageModelDto
{
    public function __construct(
        public int $resourceId,
        public string $url,
        public bool $isActive,
        public string $externalId,
        public PageStatus $statusId,
        public string $title,
        public string $content,
        public Argon $parsedAt,
        public Argon $changedAt,
        public string $contentId,
        public ?string $documentId = null,
        public ?Argon $sentAt = null,
    ) {
    }
}
