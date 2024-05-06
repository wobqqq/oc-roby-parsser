<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blackseadigital_parser_pages', function (Blueprint $table) {
            $table->smallInteger('id')->unsigned()->autoIncrement();
            $table->string('url', 2000);
            $table->boolean('is_active')->default(1)->index();
            $table->smallInteger('resource_id')->unsigned()->index();
            $table->string('external_id')->index();
            $table->string('title', 500);
            $table->text('content');
            $table->dateTime('parsed_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();

            $table->foreign('resource_id')
                ->references('id')
                ->on('blackseadigital_parser_resources');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blackseadigital_parser_pages');
    }
};
