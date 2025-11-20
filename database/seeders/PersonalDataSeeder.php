<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonalData;

class PersonalDataSeeder extends Seeder
{
    public function run()
    {
        PersonalData::create([
            'name' => 'John Doe',
            'title' => 'Senior Software Engineer',
            'email' => 'john.doe@example.com',
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Main Street, New York, NY 10001',
            'birth_date' => 'January 15, 1990',
            'nationality' => 'American',
            'linkedin' => 'linkedin.com/in/johndoe',
            'github' => 'github.com/johndoe',
            'summary' => 'Passionate software engineer...',
            'skills' => ['Laravel','PHP','JavaScript'],
            'experience' => [
                ['position'=>'Senior Web Developer','company'=>'Tech Solutions','period'=>'2022 - Present','description'=>'...']
            ],
            'education' => [
                ['degree'=>'BSc Computer Science','institution'=>'University','period'=>'2014-2018','description'=>'...']
            ],
        ]);
    }
}
