<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services\PageParsingService;

use BlackSeaDigital\Parser\Enums\ResourceNames;
use BlackSeaDigital\Parser\Exceptions\ParserException;
use BlackSeaDigital\Parser\Models\Resource;

final class PageParsingService
{
    private const array SERVICES = [
        ResourceNames::BANCATRANSILVANIA_RO->value => BancaTransilvaniaPageParsingService::class,
        ResourceNames::BLOG_BANCATRANSILVANIA_RO->value => BlogBancaTransilvaniaPageParsingService::class,
        ResourceNames::INTREB_BANCATRANSILVANIA_RO->value => IntrebBancaTransilvaniaPageParsingService::class,
        ResourceNames::COMUNITATE_BANCATRANSILVANIA_RO->value => ComunitateBancaTransilvaniaPageParsingService::class,
        ResourceNames::BTPENSII_RO->value => BtpensiiPageParsingService::class,
        ResourceNames::BTMIC_RO->value => BtmicPageParsingService::class,
        ResourceNames::BTCODECRAFTERS_RO->value => BtcodecraftersPageParsingService::class,
    ];

    /**
     * @throws \Exception
     */
    public function service(Resource $resource): IPageParsingService
    {
        $serviceClass = self::SERVICES[$resource->name];

        if (empty($serviceClass) || !class_exists($serviceClass)) {
            throw new ParserException(sprintf('Service %s not found', $resource->name));
        }

        /** @var IPageParsingService $service */
        $service = app($serviceClass);

        return $service;
    }
}
