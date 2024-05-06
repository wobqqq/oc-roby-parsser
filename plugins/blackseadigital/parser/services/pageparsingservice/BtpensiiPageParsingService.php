<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services\PageParsingService;

final class BtpensiiPageParsingService extends CommonPageParsingService
{
    protected const array CLASSES_TO_EXCLUDE = [
        '.bt-modal',
        '.breadcrumb',
        '.filters',
        '.sidebar .left',
        '.sidebar .right',
        '.sidebar .grid .center .bt-box-ad-06',
        '.bt-file-list',
    ];
}
