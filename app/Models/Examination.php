<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'diagnosis',
        'performed',
        'time_of_examination'
    ];

    public function patient(){
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }

    public function doctor(){
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }
}
