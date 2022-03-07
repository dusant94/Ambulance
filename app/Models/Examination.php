<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'diagnosis',
        'time_of_examination',
        'performed',
    ];

    public function setTimeOfExaminationAttribute($value)
    {
        $this->attributes['time_of_examination'] = Carbon::parse($value);
    }
    public function getTimeOfExaminationAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
     }
    public function patient(){
        return $this->hasOne(Patient::class, 'id', 'patient_id')->with('location')->withTrashed();;
    }

    public function doctor(){
        return $this->hasOne(User::class, 'id', 'doctor_id')->with('type')->withTrashed();;
    }
}
