<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services;

use Arr;
use BlackSeaDigital\Parser\Exceptions\ParserException;

final class UrlService
{
    /**
     * @throws ParserException
     */
    public function getPageUrlData(string $rootPageUrl, string $pageUrl): ?array
    {
        $isNotUrl = !$this->isUrl($pageUrl);

        if ($isNotUrl) {
            return null;
        }

        $rootPageUrl = $this->getUrlFormat($rootPageUrl);
        $pageUrl = $this->getUrlFormat($pageUrl, $rootPageUrl);

        $isFile = $this->isFile($pageUrl);
        $isExternalUrl = $this->isExternalUrl($rootPageUrl, $pageUrl);

        if ($isExternalUrl || $isFile) {
            return null;
        }


        if ($rootPageUrl === $pageUrl) {
            $key = $this->getUrlKey($rootPageUrl);

            return [$key, $rootPageUrl];
        }

        $key = $this->getUrlKey($pageUrl);

        return [$key, $pageUrl];
    }

    public function getExternalId(int $resourceId, string $key): string
    {
        $externalId = sprintf('%s-%s', $resourceId, $key);
        $externalId = md5($externalId);

        return $externalId;
    }

    public function getClearUrl(string $url): string
    {
        $urlParts = parse_url($url);

        Arr::forget($urlParts, 'fragment');
        Arr::forget($urlParts, 'query');

        $url = http_build_url($urlParts);

        return $url;
    }

    public function getUrlFormat(string $pageUrl, ?string $rootPageUrl = null): string
    {
        $pageUrl = strtolower($pageUrl);
        $pageUrl = trim($pageUrl);
        $pageUrlParts = parse_url($pageUrl);

        $pageUrlPath = Arr::get($pageUrlParts, 'path', '');
        $pageUrlPath = trim($pageUrlPath, '/');
        $pageUrlHost = Arr::get($pageUrlParts, 'host');

        if (empty($pageUrlPath)) {
            $pageUrlPath = '/';
        } else {
            $pageUrlPath = sprintf('/%s/', $pageUrlPath);
        }

        Arr::set($pageUrlParts, 'path', $pageUrlPath);
        Arr::forget($pageUrlParts, 'fragment');

        if (empty($pageUrlHost) && !empty($rootPageUrl)) {
            $rootPageUrl = strtolower($rootPageUrl);
            $rootPageUrl = trim($rootPageUrl);
            $rootPageUrlParts = parse_url($rootPageUrl);
            $rootPageUrlScheme = (string)Arr::get($rootPageUrlParts, 'scheme');
            $rootPageUrlHost = (string)Arr::get($rootPageUrlParts, 'host');

            Arr::set($pageUrlParts, 'scheme', $rootPageUrlScheme);
            Arr::set($pageUrlParts, 'host', $rootPageUrlHost);
        }

        $pageUrl = http_build_url($pageUrlParts);

        return $pageUrl;
    }

    private function getUrlKey($url): string
    {
        $urlParts = parse_url($url);

        Arr::forget($urlParts, 'fragment');
        Arr::forget($urlParts, 'scheme');
        Arr::forget($urlParts, 'host');

        $key = http_build_url($urlParts);

        return $key;
    }

    private function isUrl(string $url): bool
    {
        $url = trim($url);

        if (substr_count($url, ':') > 1) {
            return false;
        }

        $isUrl = str_starts_with($url, 'http://')
            || str_starts_with($url, 'https://')
            || str_starts_with($url, '/');

        return $isUrl;
    }

    private function isFile(string $url): bool
    {
        $urlParts = parse_url($url);

        $urlPath = Arr::get($urlParts, 'path', '');
        $urlPath = trim($urlPath, '/');

        Arr::forget($urlParts, 'fragment');
        Arr::forget($urlParts, 'query');

        $url = http_build_url($urlPath);

        $urlInfo = pathinfo($url);

        $extension = Arr::get($urlInfo, 'extension');

        if (empty($extension) || in_array($extension, ['html', 'php'])) {
            return false;
        }

        return true;
    }

    /**
     * @throws ParserException
     */
    private function isExternalUrl(string $rootPageUrl, string $pageUrl): bool
    {
        $rootPageUrlParts = parse_url($rootPageUrl);
        $rootPageUrlHost = Arr::get($rootPageUrlParts, 'host');
        $rootPageUrlHost = trim($rootPageUrlHost);

        $pageUrlParts = parse_url($pageUrl);
        $pageUrlHost = Arr::get($pageUrlParts, 'host');
        $pageUrlHost = trim($pageUrlHost);

        if (empty($rootPageUrlHost) || empty($pageUrlHost)) {
            throw new ParserException('Host is empty');
        }

        return $rootPageUrlHost !== $pageUrlHost;
    }
}
