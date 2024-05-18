<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Console;

use BlackSeaDigital\Parser\Services\ChatGptSenderService;
use Illuminate\Console\Command;

final class DeleteAllChatGPTDocumentsCommand extends Command
{
    /** @var string */
    protected $name = 'black-sea-digital.delete_all_chat_gpt_documents';

    /** @var string */
    protected $description = 'Delete all ChatGPT documents';

    public function handle(ChatGptSenderService $chatGptSenderService): void
    {
        $chatGptSenderService->deleteAllDocumentsFromChatGpt();
    }
}
