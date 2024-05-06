<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Queries;

use BlackSeaDigital\Parser\Models\Page;
use BlackSeaDigital\Parser\Models\Resource;

final readonly class PageQuery
{
    /**
     * @return array<string, string>
     */
    public function getPageUrlsByResource(Resource $resource): array
    {
        return Page::whereresourceId($resource->id)->lists('url', 'url');
    }
}
