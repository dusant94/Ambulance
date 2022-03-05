<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'jmbg',
        'note',
        'location_id'
    ];

    public function location(){
        return $this->hasOne(Location::class, 'location_id', 'id');
    }
}
