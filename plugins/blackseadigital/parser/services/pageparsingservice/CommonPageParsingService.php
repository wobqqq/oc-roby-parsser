<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services\PageParsingService;

use Arr;
use BlackSeaDigital\Parser\Exceptions\ParserException;
use BlackSeaDigital\Parser\Models\Page;
use BlackSeaDigital\Parser\Models\Resource;
use BlackSeaDigital\Parser\Services\PageService;
use BlackSeaDigital\Parser\Services\UrlService;
use BlackSeaDigital\Parser\Transformers\ParserTransformer;
use Config;
use Symfony\Component\DomCrawler\Crawler;

class CommonPageParsingService implements IPageParsingService
{
    private const array TAGS_TO_EXCLUDE = [
        'head',
        'header',
        'footer',
        'nav',
        'aside',
        'script',
        'img',
        'iframe',
        'noscript',
        'link',
        'h1',
        'button',
        'dialog',
    ];

    protected const array CLASSES_TO_EXCLUDE = [];

    public function __construct(
        private readonly UrlService $urlService,
        private readonly PageService $pageService,
    ) {
    }

    public function serve(string $urlKey, Crawler $crawler, Resource $resource): void
    {
        [$title, $content] = $this->getContent($crawler);

        try {
            $this->checkUrl($urlKey);
            $this->checkUrlParameters($urlKey);
            $this->checkContent($content);
            $this->checkForm($crawler);
            $this->check($urlKey);
        } catch (\Exception|\Throwable $e) {
            return;
        }

        $this->update($urlKey, $resource, $title, $content);
    }

    protected function check(string $urlKey): void
    {
    }

    private function getContent(Crawler $crawler): array
    {
        $excludes = array_merge(self::TAGS_TO_EXCLUDE, static::CLASSES_TO_EXCLUDE);
        $excludes = array_unique($excludes);
        $excludes = implode(', ', $excludes);

        $title = $crawler->filter('h1')->count() > 0
            ? $crawler->filter('h1')->text()
            : null;
        $title = empty($title) && $crawler->filter('title')->count() > 0
            ? $crawler->filter('title')->text()
            : $title;

        $crawler->each(function ($node) use ($excludes) {
            $node->filter($excludes)->each(function ($innerNode) {
                $innerNode->getNode(0)->parentNode->removeChild($innerNode->getNode(0));
            });
        });

        $crawler->filter('a')->each(function ($node) {
            $linkText = $node->text();
            $linkUrl = $node->attr('href');
            $replacement = $node
                ->getNode(0)
                ->ownerDocument
                ->createTextNode(sprintf('%s (%s)', $linkText, $linkUrl));
            $node->getNode(0)->parentNode->replaceChild($replacement, $node->getNode(0));
        });

        if ($crawler->filter('body main')->count() > 0) {
            $html = $crawler->filter('body main')->html();
        } else {
            $html = $crawler->filter('body')->count() > 0
                ? $crawler->filter('body')->html()
                : '';
        }

        $content = strip_tags($html);
        $content = preg_replace('/\n+/', ' ', $content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);

        return [$title, $content];
    }

    /**
     * @throws ParserException
     */
    private function checkUrl(string $urlKey): void
    {
        $extensions = ['html', 'php'];
        $urlInfo = pathinfo($urlKey);

        $extension = Arr::get($urlInfo, 'extension');

        if (!empty($extension) && in_array($extension, $extensions)) {
            throw new ParserException(sprintf('Url contains %s', implode(', ', $extensions)));
        }
    }

    /**
     * @throws ParserException
     */
    private function checkUrlParameters(string $urlKey): void
    {
        $clearUrlKey = $this->urlService->getClearUrl($urlKey);

        if ($urlKey !== $clearUrlKey) {
            throw new ParserException('Url contains GET parameters');
        }
    }

    /**
     * @throws ParserException
     */
    private function checkContent(?string $content): void
    {
        $minPageContentSize = (int)Config::get('parser.parser_min_page_content_size', 100);

        if (empty($content) || strlen($content) < $minPageContentSize) {
            throw new ParserException('Insufficient content');
        }
    }

    /**
     * @throws ParserException
     */
    private function checkForm(Crawler $crawler): void
    {
        if ($crawler->filter('form')->count() > 0) {
            throw new ParserException('The page contains a form');
        }
    }

    private function update(string $url, Resource $resource, string $title, string $content): void
    {
        $externalId = $this->urlService->getExternalId($resource->id, $url);

        $parserPageDto = ParserTransformer::parserPageFromParser(
            $url,
            $externalId,
            $resource,
            $title,
            $content
        );

        $page = Page::whereExternalId($externalId)->first();

        $pageModelDto = ParserTransformer::pageFromParserPageDto($parserPageDto, $page);

        if (empty($page)) {
            $this->pageService->create($pageModelDto);
        } else {
            $this->pageService->update($pageModelDto, $page);
        }
    }
}
