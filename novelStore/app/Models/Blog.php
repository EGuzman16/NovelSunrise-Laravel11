<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $primaryKey = 'blog_id';

    protected $fillable = ['title', 'content', 'release_date', 'theme_fk', 'pic', 'pic_description'];

        /*-----------------------------------------------------
    | Relaciones
    +------------------------------------------------------*/
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'theme_fk', 'theme_id');
    }

}


