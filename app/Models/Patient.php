<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'jmbg',
        'note',
        'location_id'
    ];
    protected static function boot() {
        parent::boot();

        static::deleted(function($patient) {
            $patient->examinations()->delete();
         });
    }
    public function location(){
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class, 'patient_id', 'id');
    }
}
