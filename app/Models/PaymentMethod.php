<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'is_cash'
    ];

    protected $appends = ['image_url'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getImageStorageExistsAttribute()
    {
        return $this->image ? Storage::disk('public')->exists($this->image) : false;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? ( Storage::disk('public')->exists($this->image) ? Storage::disk('public')->url($this->image) : $this->image ) : null;
    }

}
