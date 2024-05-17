<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Transformers;

use BlackSeaDigital\Parser\Dtos\Models\PageModelDto;
use BlackSeaDigital\Parser\Dtos\ParserPageDto;
use BlackSeaDigital\Parser\Enums\PageStatus;
use BlackSeaDigital\Parser\Models\Page;
use BlackSeaDigital\Parser\Models\Resource;
use October\Rain\Argon\Argon;

final class ParserTransformer
{
    public static function pageFromParserPageDto(ParserPageDto $parserPageDto, ?Page $page = null): PageModelDto
    {
        return new PageModelDto(
            $parserPageDto->resourceId,
            $parserPageDto->url,
            !empty($page) ? $page->is_active : true,
            $parserPageDto->externalId,
            $parserPageDto->statusId,
            $parserPageDto->title,
            $parserPageDto->content,
            $parserPageDto->parsedAt,
            $parserPageDto->changedAt,
            !empty($page) ? $page->document_id : null,
            !empty($page) ? $page->sent_at : null
        );
    }

    public static function parserPageFromParser(
        string $url,
        string $externalId,
        PageStatus $statusId,
        Resource $resource,
        string $title,
        string $content,
        Argon $changedAt,
    ): ParserPageDto {
        return new ParserPageDto(
            $url,
            $externalId,
            $statusId,
            $resource->id,
            Argon::now(),
            $title,
            $content,
            $changedAt,
        );
    }
}
