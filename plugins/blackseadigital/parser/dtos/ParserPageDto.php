<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Dtos;

use October\Rain\Argon\Argon;

final readonly class ParserPageDto
{
    public function __construct(
        public string $url,
        public string $externalId,
        public int $resourceId,
        public Argon $parsedAt,
        public string $title,
        public string $content
    ) {
    }
}
