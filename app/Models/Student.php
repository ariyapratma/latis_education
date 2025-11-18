<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institution;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'institution_id',
        'nis',
        'name',
        'email',
        'photo',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
