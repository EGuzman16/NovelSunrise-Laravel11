<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property int $novel_id
 * @property string $title
 * @property \Illuminate\Support\Carbon $release_date
 * @property int $price
 * @property string $synopsis
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Novel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Novel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Novel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Novel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Novel whereNovelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Novel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Novel whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Novel whereSynopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Novel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Novel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Novel extends Model
{
    use HasFactory;
    protected $table = 'novels';
    protected $primaryKey = 'novel_id';

    protected $fillable = ['title', 'price', 'release_date', 'synopsis', 'category_fk', 'cover', 'cover_description'];

    /*-----------------------------------------------------
    | Accessors & Mutators
    +------------------------------------------------------
    */
    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($price) => $price / 100,
            set: fn ($price) => $price * 100,
        );
    }

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
        ];
    }

    /*-----------------------------------------------------
    | Relaciones
    +------------------------------------------------------*/
    public function category(): BelongsTo
    {  
        return $this->belongsTo(Category::class, 'category_fk', 'category_id');
    }
    
    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'novels_have_tags', 'novel_fk', 'tag_fk', 'novel_id', 'tag_id');
    }

}


