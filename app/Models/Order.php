<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ActivityLog;
use App\Traits\LogsActivity; 

class Order extends Model
{
    use LogsActivity; 

    protected $fillable = [
        'user_id', 'total_price', 'status', 
        'shipping_address', 'shipping_postal_code', 
        'shipping_city', 'shipping_country', 'sendcloud_id'
    ];

    // Force la conversion des dates en objets Carbon
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function activities()
    {
        // Attention : cette relation est un peu "lourde" car elle fait un LIKE sur une colonne texte
        return $this->hasMany(ActivityLog::class, 'description', 'like', "%Commande #{$this->id}%");
    }
}