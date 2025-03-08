<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara mass-assignment
    protected $fillable = [
        'title',
        'description',
        'completed',
        'documentation',
    ];

    // Mutator untuk kolom status
    public function setStatusAttribute($value)
    {
        $this->attributes['completed'] = $value ? true : false; // Default ke false jika tidak dicentang
    }
}
