<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services;

use BlackSeaDigital\Parser\Dtos\Models\PageModelDto;
use BlackSeaDigital\Parser\Enums\PageStatus;
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
            'document_id' => $pageModelDto->documentId,
            'status_id' => $pageModelDto->statusId,
            'parsed_at' => $pageModelDto->parsedAt,
            'changed_at' => $pageModelDto->changedAt,
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
            'document_id' => $pageModelDto->documentId,
            'status_id' => $pageModelDto->statusId,
            'parsed_at' => $pageModelDto->parsedAt,
            'changed_at' => $pageModelDto->changedAt,
            'sent_at' => $pageModelDto->sentAt,
            'title' => $pageModelDto->title,
            'content' => $pageModelDto->content,
        ]);

        return $page;
    }

    public function updatePageStatus(Page $page, PageStatus $statusId): Page
    {
        $page->status_id = $statusId;
        $page->save();

        return $page;
    }

    public function updatePageChatGptData(Page $page, PageStatus $statusId, string $documentId): Page
    {
        $page->status_id = $statusId;
        $page->document_id = $documentId;
        $page->save();

        return $page;
    }

    public function delete(Page $page): void
    {
        $page->delete();
    }
}
