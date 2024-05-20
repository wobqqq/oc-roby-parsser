<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Queries;

use BlackSeaDigital\Parser\Enums\PageStatus;
use BlackSeaDigital\Parser\Models\Page;
use BlackSeaDigital\Parser\Models\Resource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use October\Rain\Database\Builder;

final readonly class PageQuery
{
    /**
     * @return array<string, string>
     */
    public function getPageUrlsByResource(Resource $resource): array
    {
        return Page::whereresourceId($resource->id)->lists('url', 'url');
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPageUrlsByExternalIds(array $externalIds): Collection
    {
        return Page::whereIn('external_id', $externalIds)->get();
    }

    public function isDuplicatePageContent(?Page $page, string $contentId): bool
    {
        $page = Page::whereContentId($contentId)
            ->when(!empty($page), fn (Builder|Page $q) => $q->whereNot('id', $page->id))
            ->first();

        return !empty($page);
    }

    public function countPagesToSendToChatGpt(int $resourceId): int
    {
        return $this->queryToSendPagesToChatGpt($resourceId)->count();
    }

    /**
     * @return LengthAwarePaginator<int, Page>
     */
    public function getPagesToSendToChatGpt(
        int $resourceId,
        array $pageIdExceptions = [],
        int $count = 100
    ): LengthAwarePaginator {
        return $this->queryToSendPagesToChatGpt($resourceId, $pageIdExceptions)->paginate($count);
    }

    private function queryToSendPagesToChatGpt(int $resourceId, array $pageIdExceptions = []): Builder
    {
        return Page::whereResourceId($resourceId)
            ->when(!empty($pageIdExceptions), fn (Builder|Page $q) => $q->whereNotIn('id', $pageIdExceptions))
            ->where(
                fn (Builder|Page $q) => $q
                    ->where(
                        fn (Builder|Page $q) => $q
                            ->whereIsActive(true)
                            ->whereIn(
                                'status_id',
                                [PageStatus::CREATE, PageStatus::UPDATE->value, PageStatus::DELETE->value]
                            )
                    )
                    ->orWhere(
                        fn (Builder|Page $q) => $q
                            ->whereIsActive(false)
                            ->whereNot('status_id', PageStatus::DELETED_MANUALLY->value)
                    )
            );
    }
}
