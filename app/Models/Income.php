<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Income extends Model
{
    use HasFactory;

    protected $fillable = ['name','amount', 'currency', 'remark', 'user_id'];


    public function incomes():BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
