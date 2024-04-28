<?php

declare(strict_types=1);

namespace Blackseadigital\Parser\Models;

use Model;
use October\Rain\Database\Traits\Validation;

class Page extends Model
{
    use Validation;

    public $table = 'blackseadigital_parser_pages';

    public array $attributeNames = [
        'url' => 'Url',
    ];

    public array $rules = [
        'url' => 'required|string|max:2000',
    ];

    public $fillable = [
        'url',
    ];
}
