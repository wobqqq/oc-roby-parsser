<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * BlackSeaDigital\Parser\Models\Resource
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $is_active
 * @property array|null $config
 * @method static \October\Rain\Database\Builder|Resource addWhereExistsQuery($query, $boolean = 'and', $not = false)
 * @method static \October\Rain\Database\Collection<int, static> all($columns = ['*'])
 * @method static \October\Rain\Database\Collection<int, static> get($columns = ['*'])
 * @method static \October\Rain\Database\Builder|Resource lists($column, $key = null)
 * @method static \October\Rain\Database\Builder|Resource newModelQuery()
 * @method static \October\Rain\Database\Builder|Resource newQuery()
 * @method static \October\Rain\Database\Builder|Resource orSearchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Resource orSearchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Resource paginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Resource paginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Resource query()
 * @method static \October\Rain\Database\Builder|Resource searchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Resource searchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Resource simplePaginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Resource simplePaginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Resource whereConfig($value)
 * @method static \October\Rain\Database\Builder|Resource whereId($value)
 * @method static \October\Rain\Database\Builder|Resource whereIsActive($value)
 * @method static \October\Rain\Database\Builder|Resource whereName($value)
 * @method static \October\Rain\Database\Builder|Resource whereUrl($value)
 * @mixin \Eloquent
 */
class Resource extends Model
{
    use Validation;

    /** @var string */
    public $table = 'blackseadigital_parser_resources';

    public array $attributeNames = [
        'name' => 'Name',
        'url' => 'Url',
        'is_active' => 'Active',
        'config' => 'Config',
    ];

    public array $rules = [
        'name' => 'required|string|max:255',
        'url' => 'required|string|max:255',
        'is_active' => 'boolean',
        'config' => 'nullable|array',
    ];

    /** @var string[] */
    public $fillable = [
        'name',
        'url',
        'is_active',
        'config',
    ];

    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $jsonable = ['config'];
}
