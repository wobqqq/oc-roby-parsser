<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Console;

use BlackSeaDigital\Parser\Clients\ChatGptClient;
use Illuminate\Console\Command;

final class DeleteAllChatGPTDocumentsCommand extends Command
{
    private const int LIMIT = 100;

    /** @var string */
    protected $name = 'black-sea-digital.delete_all_chat_gpt_documents';

    /** @var string */
    protected $description = 'Delete all ChatGPT documents';

    public function handle(ChatGptClient $chatGptClient): void
    {
        $offset = 0;

        $documents = $chatGptClient->listAllTexts(self::LIMIT, $offset);

        while (!empty($documents)) {
            echo sprintf("Delete documents from ChatGPT limit: %s offser: %s\n", self::LIMIT, $offset);

            $documents = $chatGptClient->listAllTexts(self::LIMIT, $offset);

            if ($documents === null) {
                return;
            }

            foreach ($documents as $document) {
                $chatGptClient->deleteText($document->documentId);
            }

            $offset += count($documents);
        }
    }
}
