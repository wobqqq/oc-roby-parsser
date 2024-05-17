<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Updates;

use BlackSeaDigital\Parser\Enums\ResourceNames;
use Illuminate\Support\Facades\DB;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('blackseadigital_parser_resources', function (Blueprint $table) {
            $table->smallInteger('id')->unsigned()->autoIncrement();
            $table->string('name')->index();
            $table->string('url');
            $table->boolean('is_active')->default(1)->index();
            $table->json('config')->nullable();
        });

        DB::table('blackseadigital_parser_resources')->insert([
            [
                'name' => ResourceNames::INTREB_BANCATRANSILVANIA_RO->value,
                'url' => 'https://intreb.bancatransilvania.ro',
                'is_active' => false,
                'config' => json_encode([
                    'sitemap_url' => 'https://intreb.bancatransilvania.ro/sitemap.xml',
                    'scan_exceptions' => [],
                ]),
            ],
            [
                'name' => ResourceNames::BLOG_BANCATRANSILVANIA_RO->value,
                'url' => 'https://blog.bancatransilvania.ro',
                'is_active' => false,
                'config' => json_encode([
                    'sitemap_url' => 'https://blog.bancatransilvania.ro/sitemap.xml',
                    'scan_exceptions' => [],
                ]),
            ],
            [
                'name' => ResourceNames::BANCATRANSILVANIA_RO->value,
                'url' => 'https://www.bancatransilvania.ro',
                'is_active' => false,
                'config' => json_encode([
                    'sitemap_url' => 'https://www.bancatransilvania.ro/sitemap.xml',
                    'scan_exceptions' => [
                        ['url' => 'https://www.bancatransilvania.ro/carduri/carduri-de-debit/cardul-de-masa-bt/comercianti-parteneri'],
                        ['url' => 'https://www.bancatransilvania.ro/relatii-investitori/rezultate-financiare'],
                        ['url' => 'https://www.bancatransilvania.ro/relatii-investitori/rapoarte-curente'],
                        ['url' => 'https://www.bancatransilvania.ro/research'],
                        ['url' => 'https://www.bancatransilvania.ro/retea-unitati/locatie'],
                        ['url' => 'https://www.bancatransilvania.ro/relatii-investitori/aga'],
                        ['url' => 'https://www.bancatransilvania.ro/en/investor-relations/governance'],
                        ['url' => 'https://www.bancatransilvania.ro/research/macroeconomie/bt-update'],
                        ['url' => 'https://www.bancatransilvania.ro/research/macroeconomie/bt-valute-si-dobanzi'],
                        ['url' => 'https://www.bancatransilvania.ro/research/macroeconomie/bt-regional'],
                        ['url' => 'https://www.bancatransilvania.ro/rapoarte-de-analiza/research/fonduri-de-investitii'],
                        ['url' => 'https://www.bancatransilvania.ro/en/investor-relations/conference-call'],
                        ['url' => 'https://www.bancatransilvania.ro/relatii-investitori/guvernanta-corporativa'],
                        ['url' => 'https://www.bancatransilvania.ro/relatii-investitori/prezentari-financiare'],
                        ['url' => 'https://www.bancatransilvania.ro/en/investor-relations/gms'],
                        ['url' => 'https://www.bancatransilvania.ro/en/investor-relations/financial'],
                        ['url' => 'https://www.bancatransilvania.ro/en/investor-relations/filings'],
                        ['url' => 'https://www.bancatransilvania.ro/relatii-investitori/teleconferinta'],
                        ['url' => 'https://www.bancatransilvania.ro/relatii-investitori/teleconferinta/video'],
                        ['url' => 'https://www.bancatransilvania.ro/en/investor-relations/conference-call/video'],
                        ['url' => 'https://www.bancatransilvania.ro/research/macroeconomie/bt-dail'],
                        ['url' => 'https://www.bancatransilvania.ro/research/macroeconomie/bt-titluri-de-stat'],
                        ['url' => 'https://www.bancatransilvania.ro/research/macroeconomie/bt-monthly'],
                        ['url' => 'https://www.bancatransilvania.ro/research/macroeconomie/bt-macro-focus'],
                        ['url' => 'https://www.bancatransilvania.ro/research/macroeconomie/bt-macro-focus'],
                        ['url' => 'https://www.bancatransilvania.ro/research/macroeconomie/bt-daily'],
                    ],
                ]),
            ],
            [
                'name' => ResourceNames::COMUNITATE_BANCATRANSILVANIA_RO->value,
                'url' => 'https://comunitate.bancatransilvania.ro',
                'is_active' => false,
                'config' => json_encode([
                    'sitemap_url' => null,
                    'scan_exceptions' => [],
                ]),
            ],
            [
                'name' => ResourceNames::BTPENSII_RO->value,
                'url' => 'https://btpensii.ro',
                'is_active' => false,
                'config' => json_encode([
                    'sitemap_url' => null,
                    'scan_exceptions' => [],
                ]),
            ],
            [
                'name' => ResourceNames::BTMIC_RO->value,
                'url' => 'https://www.btmic.ro',
                'is_active' => false,
                'config' => json_encode([
                    'sitemap_url' => null,
                    'scan_exceptions' => [],
                ]),
            ],
            [
                'name' => ResourceNames::BTCODECRAFTERS_RO->value,
                'url' => 'https://btcodecrafters.ro',
                'is_active' => false,
                'config' => json_encode([
                    'sitemap_url' => null,
                    'scan_exceptions' => [],
                ]),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('blackseadigital_parser_resources');
    }
};
