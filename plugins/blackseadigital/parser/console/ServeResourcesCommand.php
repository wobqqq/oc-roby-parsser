<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Console;

use Artisan;
use Illuminate\Console\Command;

final class ServeResourcesCommand extends Command
{
    /** @var string */
    protected $name = 'black-sea-digital.serve_resources';

    /** @var string */
    protected $description = 'Start the parser and sender content to ChatGPT';

    public function handle(): void
    {
        Artisan::call('black-sea-digital.parse_resources');
        Artisan::call('black-sea-digital.send_content_to_chat_gpt');
    }
}
