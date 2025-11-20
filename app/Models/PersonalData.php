<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    protected $table = 'personal_data';

    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
        'education' => 'array',
    ];

    protected $fillable = [
        'name','title','email','phone','address','birth_date','nationality',
        'linkedin','github','summary','skills','experience','education','photo'
    ];
}
