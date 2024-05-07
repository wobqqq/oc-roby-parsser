<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser;

use BlackSeaDigital\Parser\Console\ParseResourcesCommand;
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
    }
}
