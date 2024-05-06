<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services;

use BlackSeaDigital\Parser\Dtos\Models\PageModelDto;
use BlackSeaDigital\Parser\Models\Page;

final class PageService
{
    public function create(PageModelDto $pageModelDto): Page
    {
        return Page::create([
            'resource_id' => $pageModelDto->resourceId,
            'url' => $pageModelDto->url,
            'active' => $pageModelDto->isActive,
            'external_id' => $pageModelDto->externalId,
            'parsed_at' => $pageModelDto->parsedAt,
            'sent_at' => $pageModelDto->sentAt,
            'title' => $pageModelDto->title,
            'content' => $pageModelDto->content,
        ]);
    }

    public function update(PageModelDto $pageModelDto, Page $page): Page
    {
        $page->update([
            'resource_id' => $pageModelDto->resourceId,
            'url' => $pageModelDto->url,
            'active' => $pageModelDto->isActive,
            'external_id' => $pageModelDto->externalId,
            'parsed_at' => $pageModelDto->parsedAt,
            'sent_at' => $pageModelDto->sentAt,
            'title' => $pageModelDto->title,
            'content' => $pageModelDto->content,
        ]);

        return $page;
    }
}
