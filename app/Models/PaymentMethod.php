<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PaymentMethod extends Model
{
    //
    protected $table = "payment_methods";
    protected $fillable = [
        "name"
    ];

    public function stalls(): BelongsToMany{
        return $this->belongsToMany(Stall::class,"payment_method_stall");
    }
}
