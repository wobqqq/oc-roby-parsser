<?php

declare(strict_types=1);

namespace Blackseadigital\Parser\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Blackseadigital\Parser\Models\Site
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $is_active
 * @method static \October\Rain\Database\Builder|Site addWhereExistsQuery($query, $boolean = 'and', $not = false)
 * @method static \October\Rain\Database\Collection<int, static> all($columns = ['*'])
 * @method static \October\Rain\Database\Collection<int, static> get($columns = ['*'])
 * @method static \October\Rain\Database\Builder|Site lists($column, $key = null)
 * @method static \October\Rain\Database\Builder|Site newModelQuery()
 * @method static \October\Rain\Database\Builder|Site newQuery()
 * @method static \October\Rain\Database\Builder|Site orSearchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Site orSearchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Site paginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Site paginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Site query()
 * @method static \October\Rain\Database\Builder|Site searchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Site searchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Site simplePaginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Site simplePaginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Site whereId($value)
 * @method static \October\Rain\Database\Builder|Site whereIsActive($value)
 * @method static \October\Rain\Database\Builder|Site whereName($value)
 * @method static \October\Rain\Database\Builder|Site whereUrl($value)
 * @mixin \Eloquent
 */
class Site extends Model
{
    use Validation;

    public $table = 'blackseadigital_parser_sites';

    public array $attributeNames = [
        'name' => 'Name',
        'url' => 'Url',
        'is_active' => 'Active',
    ];

    public array $rules = [
        'name' => 'required|string|max:255',
        'url' => 'required|string|max:255',
        'is_active' => 'boolean',
    ];

    public $fillable = [
        'name',
        'url',
        'is_active',
    ];

    public $timestamps = false;
}
