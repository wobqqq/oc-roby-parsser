<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services\PageParsingService;

use BlackSeaDigital\Parser\Models\Resource;
use Symfony\Component\DomCrawler\Crawler;

interface IPageParsingService
{
    public function serve(string $urlKey, Crawler $crawler, Resource $resource): void;
}
