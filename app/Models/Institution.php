<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = ['name,'];

    public function students()
    {
        return $this->hasMany(Student::class, 'institution_id');
    }
}
