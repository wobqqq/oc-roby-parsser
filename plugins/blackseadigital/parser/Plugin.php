<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser;

use BlackSeaDigital\Parser\Console\DeleteAllChatGPTDocumentsCommand;
use BlackSeaDigital\Parser\Console\ParseResourcesCommand;
use BlackSeaDigital\Parser\Console\SendContentToChatGPTCommand;
use BlackSeaDigital\Parser\Console\ServeResourcesCommand;
use BlackSeaDigital\Parser\Listeners\BackendMenuListener;
use Event;
use System\Classes\PluginBase;

final class Plugin extends PluginBase
{
    public function boot(): void
    {
        Event::subscribe(BackendMenuListener::class);
    }

    public function register(): void
    {
        $this->registerConsoleCommand('black-sea-digital.parse_resources', ParseResourcesCommand::class);
        $this->registerConsoleCommand(
            'black-sea-digital.send_content_to_chat_gpt',
            SendContentToChatGPTCommand::class
        );
        $this->registerConsoleCommand('black-sea-digital.serve_resources', ServeResourcesCommand::class);
        $this->registerConsoleCommand(
            'black-sea-digital.delete_all_chat_gpt_documents',
            DeleteAllChatGPTDocumentsCommand::class
        );
    }
}
