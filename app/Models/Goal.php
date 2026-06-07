<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['user_id', 'name', 'icon', 'target_amount', 'saved_amount', 'deadline'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function percentage(): int
    {
        if ($this->target_amount <= 0) return 0;
        return min(round(($this->saved_amount / $this->target_amount) * 100), 100);
    }

    public function remaining(): float
    {
        return max($this->target_amount - $this->saved_amount, 0);
    }
}