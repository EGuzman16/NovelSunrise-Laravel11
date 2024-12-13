<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'novel_title',
        'price',
        'cover',
        'status',
    ];

    // Definir los valores permitidos para el campo 'status'
    const STATUS_PENDING = 'PENDIENTE';
    const STATUS_PAID = 'PAGO';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_PAID,
        ];
    }

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Validar que el status sea uno de los valores permitidos
    public function setStatusAttribute($value)
    {
        if (in_array($value, self::getStatusOptions())) {
            $this->attributes['status'] = $value;
        } else {
            throw new \InvalidArgumentException("Invalid status value");
        }
    }
}