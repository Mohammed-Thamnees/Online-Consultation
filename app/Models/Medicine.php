<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicine extends Model
{
    use HasFactory;

    public function medicinetype()
    {
        return $this->BelongsTo(MedicineType::class, 'medicine_type_id');
    }

}
