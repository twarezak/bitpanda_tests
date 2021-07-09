<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'citizenship_country_id',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'citizenship_country_id', 'id');
    }
}
