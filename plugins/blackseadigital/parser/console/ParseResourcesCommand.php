<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Console;

use BlackSeaDigital\Parser\Models\Resource;
use BlackSeaDigital\Parser\Queries\ResourceQuery;
use BlackSeaDigital\Parser\Services\ResourceParsingService;
use Illuminate\Console\Command;
use Log;
use October\Rain\Argon\Argon;

final class ParseResourcesCommand extends Command
{
    private const string STARTING_MESSAGE = 'Start of parsing (%s)';

    private const string ENDING_MESSAGE = 'End of parsing (%s)';

    /** @var string */
    protected $name = 'black-sea-digital.parse_resources';

    /** @var string */
    protected $description = 'Resource parsing';

    public function handle(ResourceQuery $resourceQuery): void
    {
        $this->parse($resourceQuery);
    }

    private function parse(ResourceQuery $resourceQuery): void
    {
        $dateAndTime = Argon::now()->toDateTimeString();

        $this->info(sprintf(self::STARTING_MESSAGE, $dateAndTime));
        Log::info(sprintf(self::STARTING_MESSAGE, $dateAndTime));

        $resources = $resourceQuery->getActiveResources();

        $resources->each(function (Resource $resource) {
            try {
                /** @var ResourceParsingService $ResourceParsingService */
                $ResourceParsingService = app(ResourceParsingService::class, ['resource' => $resource]);
                $ResourceParsingService->serveResource();
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
