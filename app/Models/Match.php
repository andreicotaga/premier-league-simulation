<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Match
 * @package App\Models
 */
class Match extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'week_id',
        'home_team',
        'away_team'
    ];

    /**
     * @return BelongsTo
     */
    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class, 'week_id', 'id');
    }
}
