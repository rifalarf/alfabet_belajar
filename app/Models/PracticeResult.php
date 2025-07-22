<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeResult extends Model
{
    use HasFactory;

    /**
     * Mendefinisikan bahwa setiap hasil latihan (PracticeResult)
     * dimiliki oleh satu Level.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Mendefinisikan bahwa setiap hasil latihan (PracticeResult)
     * dimiliki oleh satu User (opsional).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
