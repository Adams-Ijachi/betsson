<?php

namespace App\Models;

use Database\Factories\TodoFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $priority_id
 * @property int|null $category_id
 * @property int $user_id
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Todo> $children
 * @property-read int|null $children_count
 * @property-read Todo|null $parent
 * @property-read \App\Models\Priority $priority
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\TodoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereUserId($value)
 * @property bool $is_completed
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereIsCompleted($value)
 * @mixin \Eloquent
 */
class Todo extends Model
{
    /** @use HasFactory<TodoFactory> */
    use HasFactory;

    protected $fillable = [

        "name",
        "is_completed",

        "user_id",
        "parent_id",
        "priority_id",
        "category_id",
    ];

    protected $with = ['priority','category','children'];

    protected $casts = [
        'is_completed' => 'boolean'
    ];

    /**
     * Get the priority associated with the todo.
     */
    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    /**
     * Get the category associated with the todo.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user who owns the todo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent todo if it exists.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Todo::class, 'parent_id');
    }

    /**
     * Get the child todos for this todo.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Todo::class, 'parent_id')->where('is_completed',false);
    }


}
