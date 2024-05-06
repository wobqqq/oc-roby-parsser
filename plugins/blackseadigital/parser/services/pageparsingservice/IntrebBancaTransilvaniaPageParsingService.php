<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services\PageParsingService;

final class IntrebBancaTransilvaniaPageParsingService extends CommonPageParsingService
{
    protected const array CLASSES_TO_EXCLUDE = [
        '.sidemenu',
        '.breadcrumb',
        '.title-with-breadcrumb',
        '.answer-inner .contributors',
        '.answer-inner .question-tags',
        '.answer-inner .vote',
        '.social-plugins',
        '.bt-modal',
        '.filters',
        '.bt-main-menu-links',
        '[data-ajax-partial="@content"]',
        '.bt-sticky-search',
        '.questions-listing',
        '.pagination',
    ];
}
