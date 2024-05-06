<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services\PageParsingService;

final class BtcodecraftersPageParsingService extends CommonPageParsingService
{
    protected const array CLASSES_TO_EXCLUDE = [
        '.breadcrumb',
        '.filters',
        '.heading p',
        '.body .share',
        '.cc-blog-post-listing',
        '.cc-masonry-listing',
        '.cc-pagination',
    ];
}
