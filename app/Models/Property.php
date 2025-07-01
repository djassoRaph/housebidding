<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Bid;

class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'starting_price',
        'min_increment',
        'end_at',
        'closed',
    ];

    protected $casts = [
        'end_at' => 'datetime',
        'closed' => 'boolean',
    ];

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
}
