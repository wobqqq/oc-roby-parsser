<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Console;

use BlackSeaDigital\Parser\Models\Resource;
use BlackSeaDigital\Parser\Queries\ResourceQuery;
use BlackSeaDigital\Parser\Services\ChatGptSenderService;
use Illuminate\Console\Command;
use Log;
use October\Rain\Argon\Argon;

final class SendContentToChatGPTCommand extends Command
{
    private const string STARTING_MESSAGE = 'Start of sending to ChatGPT (%s)';

    private const string ENDING_MESSAGE = 'End of sending to ChatGPT (%s)';

    /** @var string */
    protected $name = 'black-sea-digital.send_content_to_chat_gpt';

    /** @var string */
    protected $description = 'Send content to ChatGPT';

    public function handle(ResourceQuery $resourceQuery, ChatGptSenderService $chatGptSenderService): void
    {
        $dateAndTime = Argon::now()->toDateTimeString();

        $this->info(sprintf(self::STARTING_MESSAGE, $dateAndTime));
        Log::info(sprintf(self::STARTING_MESSAGE, $dateAndTime));

        $resources = $resourceQuery->getActiveResources();

        $resources->each(function (Resource $resource) use ($chatGptSenderService) {
            try {
                $chatGptSenderService->sendResourcePagesToChatGpt($resource);
            } catch (\Exception|\Throwable $e) {
                $exceptionData = print_r([
                    'title' => sprintf('%s resource error', $resource->name),
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'trace' => $e->getTraceAsString(),
                ], true);

                $this->error($exceptionData);
                Log::error($exceptionData);
            }
        });

        $this->info(sprintf(self::ENDING_MESSAGE, $dateAndTime));
        Log::info(sprintf(self::ENDING_MESSAGE, $dateAndTime));
    }
}
