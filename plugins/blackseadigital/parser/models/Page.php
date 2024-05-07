<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * BlackSeaDigital\Parser\Models\Page
 *
 * @property int $id
 * @property string $url
 * @property bool $is_active
 * @property int $resource_id
 * @property string $external_id
 * @property string|null $title
 * @property string $content
 * @property \October\Rain\Argon\Argon|null $parsed_at
 * @property \October\Rain\Argon\Argon|null $sent_at
 * @property \October\Rain\Argon\Argon|null $created_at
 * @property \October\Rain\Argon\Argon|null $updated_at
 * @property-read \BlackSeaDigital\Parser\Models\Resource $resource
 * @method static \October\Rain\Database\Builder|Page addWhereExistsQuery($query, $boolean = 'and', $not = false)
 * @method static \October\Rain\Database\Collection<int, static> all($columns = ['*'])
 * @method static \October\Rain\Database\Collection<int, static> get($columns = ['*'])
 * @method static \October\Rain\Database\Builder|Page lists($column, $key = null)
 * @method static \October\Rain\Database\Builder|Page newModelQuery()
 * @method static \October\Rain\Database\Builder|Page newQuery()
 * @method static \October\Rain\Database\Builder|Page orSearchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Page orSearchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Page paginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Page paginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Page query()
 * @method static \October\Rain\Database\Relations\BelongsTo|Page resource()
 * @method static \October\Rain\Database\Builder|Page searchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Page searchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Page simplePaginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Page simplePaginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Page whereContent($value)
 * @method static \October\Rain\Database\Builder|Page whereCreatedAt($value)
 * @method static \October\Rain\Database\Builder|Page whereExternalId($value)
 * @method static \October\Rain\Database\Builder|Page whereId($value)
 * @method static \October\Rain\Database\Builder|Page whereIsActive($value)
 * @method static \October\Rain\Database\Builder|Page whereParsedAt($value)
 * @method static \October\Rain\Database\Builder|Page whereResourceId($value)
 * @method static \October\Rain\Database\Builder|Page whereSentAt($value)
 * @method static \October\Rain\Database\Builder|Page whereTitle($value)
 * @method static \October\Rain\Database\Builder|Page whereUpdatedAt($value)
 * @method static \October\Rain\Database\Builder|Page whereUrl($value)
 * @mixin \Eloquent
 */
class Page extends Model
{
    use Validation;

    /** @var string */
    public $table = 'blackseadigital_parser_pages';

    public array $attributeNames = [
        'url' => 'Url',
        'is_active' => 'Active',
        'resource_id' => 'Resource',
        'external_id' => 'External Id',
        'title' => 'Title',
        'content' => 'Content',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'parsed_at' => 'Parsed at',
        'sent_at' => 'Sent At',
    ];

    public array $rules = [
        'url' => 'required|string|max:2000',
        'is_active' => 'boolean',
        'resource_id' => 'required|integer',
        'external_id' => 'required|string|max:255',
        'title' => 'nullable|string|max:500',
        'content' => 'required|string',
        'parsed_at' => 'nullable|date',
        'sent_at' => 'nullable|date',
    ];

    /** @var string[] */
    public $fillable = [
        'url',
        'is_active',
        'resource_id',
        'external_id',
        'title',
        'content',
        'parsed_at',
        'sent_at',
    ];

    /** @var string[] */
    public $dates = [
        'parsed_at',
        'sent_at',
        'created_at',
        'updated_at',
    ];

    /** @var array[] */
    public $belongsTo = ['resource' => [Resource::class]];

    /** @var string[] */
    public $casts = [
        'is_active' => 'bool',
    ];
}
