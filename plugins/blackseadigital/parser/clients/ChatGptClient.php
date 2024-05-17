<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Clients;

use BlackSeaDigital\Parser\Dtos\ChatGptDocumentDto;
use BlackSeaDigital\Parser\Transformers\ChatGptTransformer;
use Config;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Log;

final class ChatGptClient
{
    private Client $client;

    public function __construct()
    {
        $chatGptUrl = (string)Config::get('parser.chat_gpt_url');

        $this->client = new Client([
            'base_uri' => $chatGptUrl,
            'headers' => [
                'accept' => 'application/json',
            ],
            'verify' => false,
            'timeout' => (int)Config::get('parser.parser_timeout'),
        ]);
    }

    /**
     * @return null|ChatGptDocumentDto[]
     */
    public function listAllTexts(int $limit = 100, int $offset = 0): ?array
    {
        $query = [
            'limit' => $limit,
            'offset' => $offset,
        ];

        $response = $this->sendRequest('GET', '/documents/documents/list_all_texts', $query);

        if ($response === null) {
            return null;
        }

        $chatGptDocumentDtos = array_map(function (array $response) {
            return ChatGptTransformer::documentFromChatGpt($response);
        }, $response);

        return $chatGptDocumentDtos;
    }

    public function addText(string $text, string $question): ?ChatGptDocumentDto
    {
        $query = [
            'text' => $text,
            'question' => $question,
        ];

        $response = $this->sendRequest('POST', '/documents/documents/add_text', $query);

        $chatGptDocumentDto = $response === null ? $response : ChatGptTransformer::documentFromChatGpt($response);

        return $chatGptDocumentDto;
    }

    public function getText(string $documentId): ?ChatGptDocumentDto
    {
        $query = ['document_id' => $documentId];

        $response = $this->sendRequest('POST', '/documents/documents/get_text', $query);

        $chatGptDocumentDto = $response === null ? $response : ChatGptTransformer::documentFromChatGpt($response);

        return $chatGptDocumentDto;
    }

    public function deleteText(string $documentId): ?ChatGptDocumentDto
    {
        $query = ['document_id' => $documentId];

        $response = $this->sendRequest('POST', '/documents/documents/delete_text', $query);

        $chatGptDocumentDto = $response === null ? $response : ChatGptTransformer::documentFromChatGpt($response);

        return $chatGptDocumentDto;
    }

    private function sendRequest(string $method, string $uri, array $query): ?array
    {
        try {
            $response = $this->client->request($method, $uri, ['query' => $query]);
            $response = json_decode($response->getBody()->getContents(), true);

            return $response ?? [];
        } catch (GuzzleException|RequestException|Exception $e) {
            Log::error(print_r([
                'title' => 'ChatGPT request error',
                'base_url' => (string)Config::get('parser.chat_gpt_url'),
                'method' => $method,
                'uri' => $uri,
                'query' => $query,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ], true));

            return null;
        }
    }
}
