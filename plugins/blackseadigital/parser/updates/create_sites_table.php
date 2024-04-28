<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Updates;

use Blackseadigital\Parser\Enums\SiteNames;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blackseadigital_parser_sites', function (Blueprint $table) {
            $table->smallInteger('id')->unsigned()->autoIncrement();
            $table->string('name')->index();
            $table->string('url');
            $table->boolean('is_active')->default(1)->index();
        });

        DB::table('blackseadigital_parser_sites')->insert([
            [
                'name' => SiteNames::INTREB_BANCATRANSILVANIA_RO->value,
                'url' => 'https://intreb.bancatransilvania.ro',
            ],
            [
                'name' => SiteNames::BLOG_BANCATRANSILVANIA_RO->value,
                'url' => 'https://blog.bancatransilvania.ro',
            ],
            [
                'name' => SiteNames::BANCATRANSILVANIA_RO->value,
                'url' => 'https://www.bancatransilvania.ro',
            ],
            [
                'name' => SiteNames::COMUNITATE_BANCATRANSILVANIA_RO->value,
                'url' => 'https://comunitate.bancatransilvania.ro',
            ],
            [
                'name' => SiteNames::BTPENSII_RO->value,
                'url' => 'https://btpensii.ro',
            ],
            [
                'name' => SiteNames::BTMIC_RO->value,
                'url' => 'https://www.btmic.ro',
            ],
            [
                'name' => SiteNames::BTCODECRAFTERS_RO->value,
                'url' => 'https://btcodecrafters.ro',
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('blackseadigital_parser_sites');
    }
};
