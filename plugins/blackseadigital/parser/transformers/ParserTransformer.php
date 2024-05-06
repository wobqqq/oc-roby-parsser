<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Transformers;

use BlackSeaDigital\Parser\Dtos\Models\PageModelDto;
use BlackSeaDigital\Parser\Dtos\ParserPageDto;
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
            $parserPageDto->title,
            $parserPageDto->content,
            $parserPageDto->parsedAt,
            !empty($page) ? $page->sent_at : null
        );
    }

    public static function parserPageFromParser(
        string $url,
        string $externalId,
        Resource $resource,
        string $title,
        string $content
    ): ParserPageDto {
        return new ParserPageDto(
            $url,
            $externalId,
            $resource->id,
            Argon::now(),
            $title,
            $content
        );
    }
}
