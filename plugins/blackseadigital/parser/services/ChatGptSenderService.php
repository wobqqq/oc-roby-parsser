<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Services;

use BlackSeaDigital\Parser\Clients\ChatGptClient;
use BlackSeaDigital\Parser\Dtos\ChatGptDocumentDto;
use BlackSeaDigital\Parser\Enums\PageStatus;
use BlackSeaDigital\Parser\Exceptions\ParserException;
use BlackSeaDigital\Parser\Models\Page;
use BlackSeaDigital\Parser\Models\Resource;
use BlackSeaDigital\Parser\Queries\PageQuery;
use Exception;
use Illuminate\Support\Collection;
use Log;

final readonly class ChatGptSenderService
{
    public function __construct(
        private ChatGptClient $chatGptClient,
        private PageService $pageService,
        private PageQuery $pageQuery,
    ) {
    }

    public function serve(Resource $resource): void
    {
        $totalPages = $this->pageQuery->countPagesToSendToChatGpt($resource->id);
        $countPages = 0;

        $this->pageQuery->chunkToSendPagesToChatGpt(
            $resource->id,
            function (Collection $pages) use ($resource, $totalPages, &$countPages) {
                /** @var Collection<int, Page> $page */
                foreach ($pages as $page) {
                    try {
                        $this->servePage($page);
                    } catch (Exception $e) {
                        Log::error(print_r([
                            'page_id' => $page->id,
                            'message' => $e->getMessage(),
                            'line' => $e->getLine(),
                            'file' => $e->getFile(),
                            'trace' => $e->getTraceAsString(),
                        ], true));
                    }
                }

                $countPages += $pages->count();
                $this->printResourceChunkResultToConsole($resource, $totalPages, $countPages);
            }
        );

        $this->printResourceResultToLog($resource, $totalPages, $countPages);
    }

    /**
     * @throws ParserException
     */
    private function servePage(Page $page): void
    {
        if ($page->status_id === PageStatus::CREATE && empty($page->document_id)) {
            $this->createDocument($page);
        } elseif ($page->status_id === PageStatus::UPDATE && !empty($page->document_id)) {
            $this->updateDocument($page);
        } elseif ($page->status_id === PageStatus::DELETE && !empty($page->document_id)) {
            $this->deleteDocument($page);
        } elseif ($page->is_active === false && $page->status_id !== PageStatus::DELETED_MANUALLY) {
            $this->deleteDocumentManually($page);
        }
    }

    /**
     * @throws ParserException
     * @throws Exception
     */
    private function createDocument(Page $page): void
    {
        $chatGptDocumentDto = $this->chatGptClient->addText($page->content, $page->title);

        if (!$chatGptDocumentDto instanceof ChatGptDocumentDto || empty($chatGptDocumentDto->documentId)) {
            throw new ParserException('Bad request to create a document');
        }

        try {
            $this->pageService->updatePageChatGptData(
                $page,
                PageStatus::PROCESSED,
                $chatGptDocumentDto->documentId
            );
        } catch (Exception|Exception $e) {
            if (!empty($chatGptDocumentDto->documentId)) {
                $this->chatGptClient->deleteText($chatGptDocumentDto->documentId);
            }

            throw $e;
        }
    }

    /**
     * @throws ParserException
     */
    private function updateDocument(Page $page): void
    {
        $chatGptDocumentDto = $this->chatGptClient->getText($page->document_id);

        if (!$chatGptDocumentDto instanceof ChatGptDocumentDto) {
            throw new ParserException('Bad request to get a document');
        }

        if (!empty($chatGptDocumentDto->documentId)) {
            $chatGptDocumentDto = $this->chatGptClient->deleteText($page->document_id);

            if (!$chatGptDocumentDto instanceof ChatGptDocumentDto) {
                throw new ParserException('Bad request to delete a document');
            }
        }

        $chatGptDocumentDto = $this->chatGptClient->addText($page->content, $page->title);

        if (!$chatGptDocumentDto instanceof ChatGptDocumentDto || empty($chatGptDocumentDto->documentId)) {
            throw new ParserException('Bad request to create a document');
        }

        $this->pageService->updatePageChatGptData(
            $page,
            PageStatus::PROCESSED,
            $chatGptDocumentDto->documentId
        );
    }

    /**
     * @throws ParserException
     */
    private function deleteDocument(Page $page): void
    {
        $chatGptDocumentDto = $this->chatGptClient->getText($page->document_id);

        if (!$chatGptDocumentDto instanceof ChatGptDocumentDto) {
            throw new ParserException('Bad request to get a document');
        }

        if (empty($chatGptDocumentDto->documentId)) {
            $this->pageService->delete($page);

            return;
        }

        $chatGptDocumentDto = $this->chatGptClient->deleteText($page->document_id);

        if (!$chatGptDocumentDto instanceof ChatGptDocumentDto) {
            throw new ParserException('Bad request to delete a document');
        }

        $this->pageService->delete($page);
    }

    /**
     * @throws ParserException
     */
    private function deleteDocumentManually(Page $page): void
    {
        $chatGptDocumentDto = $this->chatGptClient->getText($page->document_id);

        if (!$chatGptDocumentDto instanceof ChatGptDocumentDto) {
            throw new ParserException('Bad request to get a document');
        }

        if (empty($chatGptDocumentDto->documentId)) {
            $this->pageService->updatePageStatus($page, PageStatus::DELETED_MANUALLY);

            return;
        }

        $chatGptDocumentDto = $this->chatGptClient->deleteText($page->document_id);

        if (!$chatGptDocumentDto instanceof ChatGptDocumentDto) {
            throw new ParserException('Bad request to delete a document');
        }

        $this->pageService->updatePageStatus($page, PageStatus::DELETED_MANUALLY);
    }

    private function printResourceChunkResultToConsole(Resource $resource, int $totalPages, int $countPages): void
    {
        echo sprintf(
            "%s pages out of %s of the %s resource were sent to the ChatGPT\n",
            $countPages,
            $totalPages,
            $resource->name,
        );
        echo "---------------------------------\n";
    }

    private function printResourceResultToLog(Resource $resource, int $totalPages, int $countPages): void
    {
        Log::info(
            sprintf(
                '%s pages out of %s of the %s resource were sent to the ChatGPT',
                $countPages,
                $totalPages,
                $resource->name,
            )
        );
    }
}
