<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Queries;

use BlackSeaDigital\Parser\Enums\PageStatus;
use BlackSeaDigital\Parser\Models\Page;
use BlackSeaDigital\Parser\Models\Resource;
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

    public function findPageByContentId(string $contentId): ?Page
    {
        return Page::whereContentId($contentId)->first();
    }

    public function countPagesToSendToChatGpt(int $resourceId): int
    {
        return $this->queryToSendPagesToChatGpt($resourceId)->count();
    }

    public function chunkToSendPagesToChatGpt(int $resourceId, callable $callback, int $count = 100): void
    {
        $this->queryToSendPagesToChatGpt($resourceId)->chunk($count, $callback);
    }

    private function queryToSendPagesToChatGpt(int $resourceId): Builder
    {
        return Page::whereResourceId($resourceId)
            ->where(
                fn (Builder|Page $q) => $q
                ->where(
                    fn (Builder|Page $q) => $q
                    ->whereIsActive(true)
                    ->whereIn('status_id', [PageStatus::CREATE, PageStatus::UPDATE->value, PageStatus::DELETE->value])
                )
                ->orWhere(
                    fn (Builder|Page $q) => $q
                    ->whereIsActive(false)
                    ->whereNot('status_id', PageStatus::DELETED_MANUALLY->value)
                )
            );
    }
}
