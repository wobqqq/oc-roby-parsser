<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Transformers;

use Arr;
use BlackSeaDigital\Parser\Dtos\ChatGptDocumentDto;

final class ChatGptTransformer
{
    public static function documentFromChatGpt(array $response): ChatGptDocumentDto
    {
        return new ChatGptDocumentDto(
            (string)Arr::get($response, 'id', Arr::get($response, 'document_id')),
            (string)Arr::get($response, 'text'),
            (string)Arr::get($response, 'question'),
            (string)Arr::get($response, 'message'),
        );
    }
}
