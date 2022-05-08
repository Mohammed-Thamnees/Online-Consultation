<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public function doctordetails()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function doctorcategory()
    {
        return $this->hasMany(DoctorCategory::class, 'doctor_id');
    }

}
