<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Dtos;

final readonly class ChatGptDocumentDto
{
    public function __construct(
        public string $documentId,
        public ?string $text,
        public ?string $question,
        public ?string $message,
    ) {
    }
}
