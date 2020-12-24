<?php
namespace App\Models;

trait ModelHelpers
{
    public function scopeActive($q)
    {
        return $q->where('active', true);
    }
}
