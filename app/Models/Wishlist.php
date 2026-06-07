<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'name', 'icon', 'estimated_price', 'link', 'priority', 'is_bought'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priorityLabel(): string
    {
        return match($this->priority) {
            'high'   => '🔴 Tinggi',
            'medium' => '🟡 Sedang',
            'low'    => '🟢 Rendah',
            default  => '-',
        };
    }
}