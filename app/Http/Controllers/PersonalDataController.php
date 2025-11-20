<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalData;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PersonalDataController extends Controller
{
    // tampilkan profil (ambil row pertama)
    public function index()
    {
        $personalData = PersonalData::first();
        return view('personal-data.index', compact('personalData'));
    }

    // show edit form
    public function edit()
    {
        $personalData = PersonalData::first();
        return view('personal-data.edit', compact('personalData'));
    }

    // update
    public function update(Request $request)
    {
        $pd = PersonalData::first();
        if (!$pd) {
            // create if not exists
            $pd = new PersonalData();
        }

        $rules = [
            'name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // max 2MB
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            // experience and education can be JSON strings from form
        ];

        $validated = $request->validate($rules);

        // handle photo upload
        if ($request->hasFile('photo')) {
            // delete old
            if ($pd->photo && Storage::disk('public')->exists($pd->photo)) {
                Storage::disk('public')->delete($pd->photo);
            }
            $f = $request->file('photo');
            $filename = 'photos/' . Str::random(12) . '_' . time() . '.' . $f->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('photos', $f, basename($filename));
            $pd->photo = $filename;
        }

        // plain fields
        $pd->name = $validated['name'] ?? $pd->name;
        $pd->title = $validated['title'] ?? $pd->title;
        $pd->email = $validated['email'] ?? $pd->email;
        $pd->phone = $validated['phone'] ?? $pd->phone;
        $pd->address = $validated['address'] ?? $pd->address;
        $pd->birth_date = $validated['birth_date'] ?? $pd->birth_date;
        $pd->nationality = $validated['nationality'] ?? $pd->nationality;
        $pd->linkedin = $validated['linkedin'] ?? $pd->linkedin;
        $pd->github = $validated['github'] ?? $pd->github;
        $pd->summary = $validated['summary'] ?? $pd->summary;

        // skills: if skills come as array from form, store as array
        if ($request->has('skills')) {
            $pd->skills = array_values(array_filter($request->input('skills', [])));
        }

        // experience / education: expect JSON string, or skip
        if ($request->has('experience_raw')) {
            // allow user to send JSON in a textarea named experience_raw
            $expRaw = $request->input('experience_raw');
            $decoded = json_decode($expRaw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $pd->experience = $decoded;
            }
        }

        if ($request->has('education_raw')) {
            $eduRaw = $request->input('education_raw');
            $decoded = json_decode($eduRaw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $pd->education = $decoded;
            }
        }

        $pd->save();

        return redirect()->route('personal-data.index')->with('success', 'Profile updated.');
    }
}
