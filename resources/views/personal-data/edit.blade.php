@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Edit Profile</h5>
                    <a href="{{ route('personal-data.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>

                <div class="card-body">

                    <form action="{{ route('personal-data.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- PHOTO PREVIEW -->
                        <div class="mb-3 text-center">
                            @if($personalData->photo)
                                <img id="photoPreview"
                                     src="{{ asset('storage/' . $personalData->photo) }}"
                                     style="width:140px;height:140px;border-radius:10px;object-fit:cover;">
                            @else
                                <img id="photoPreview"
                                     src="https://via.placeholder.com/140"
                                     style="width:140px;height:140px;border-radius:10px;object-fit:cover;">
                            @endif
                        </div>

                        <!-- PHOTO INPUT -->
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" class="form-control" name="photo" accept="image/*">
                        </div>

                        <!-- NAME -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" class="form-control"
                                   value="{{ old('name', $personalData->name) }}">
                        </div>

                        <!-- TITLE -->
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input name="title" class="form-control"
                                   value="{{ old('title', $personalData->title) }}">
                        </div>

                        <!-- EMAIL & PHONE -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $personalData->email) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input name="phone" class="form-control"
                                       value="{{ old('phone', $personalData->phone) }}">
                            </div>
                        </div>

                        <!-- ADDRESS -->
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input name="address" class="form-control"
                                   value="{{ old('address', $personalData->address) }}">
                        </div>

                        <!-- DATE OF BIRTH & NATIONALITY -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input name="birth_date" class="form-control"
                                       value="{{ old('birth_date', $personalData->birth_date) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nationality</label>
                                <input name="nationality" class="form-control"
                                       value="{{ old('nationality', $personalData->nationality) }}">
                            </div>
                        </div>

                        <!-- LINKEDIN & GITHUB -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">LinkedIn</label>
                                <input name="linkedin" class="form-control"
                                       value="{{ old('linkedin', $personalData->linkedin) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Github</label>
                                <input name="github" class="form-control"
                                       value="{{ old('github', $personalData->github) }}">
                            </div>
                        </div>

                        <!-- SUMMARY -->
                        <div class="mb-3">
                            <label class="form-label">Summary</label>
                            <textarea name="summary" class="form-control" rows="4">
                                {{ old('summary', $personalData->summary) }}
                            </textarea>
                        </div>


                        <!-- SKILLS (ARRAY) -->
                        <div class="mb-3">
                            <label class="form-label">Skills</label>

                            <div id="skills-wrap">
                                @php
                                    $skills = old('skills', $personalData->skills ?? []);
                                @endphp

                                @foreach($skills as $skill)
                                <div class="input-group mb-2 skill-item">
                                    <input class="form-control" name="skills[]" value="{{ $skill }}">
                                    <button type="button" class="btn btn-danger btn-remove-skill">-</button>
                                </div>
                                @endforeach

                                @if(empty($skills))
                                <div class="input-group mb-2 skill-item">
                                    <input class="form-control" name="skills[]" value="">
                                    <button type="button" class="btn btn-danger btn-remove-skill">-</button>
                                </div>
                                @endif
                            </div>

                            <button type="button" id="addSkillBtn" class="btn btn-primary btn-sm">+ Add Skill</button>
                        </div>


                        <!-- EXPERIENCE (JSON) -->
                        <div class="mb-3">
                            <label class="form-label">Experience (JSON)</label>
                            <textarea name="experience_raw" class="form-control" rows="6">{{ 
                                old('experience_raw', json_encode($personalData->experience, JSON_PRETTY_PRINT))
                            }}</textarea>
                        </div>

                        <!-- EDUCATION (JSON) -->
                        <div class="mb-3">
                            <label class="form-label">Education (JSON)</label>
                            <textarea name="education_raw" class="form-control" rows="6">{{ 
                                old('education_raw', json_encode($personalData->education, JSON_PRETTY_PRINT))
                            }}</textarea>
                        </div>

                        <button class="btn btn-success w-100">Save Changes</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


@push('scripts')
<script>
document.querySelector('input[name="photo"]').addEventListener('change', function(e){
    const file = e.target.files[0];
    if (!file) return;
    const r = new FileReader();
    r.onload = e => document.getElementById('photoPreview').src = e.target.result;
    r.readAsDataURL(file);
});

// ADD skill
document.getElementById('addSkillBtn').addEventListener('click', function(){
    const div = document.createElement('div');
    div.className = "input-group mb-2 skill-item";
    div.innerHTML = `
        <input class="form-control" name="skills[]" value="">
        <button type="button" class="btn btn-danger btn-remove-skill">-</button>
    `;
    document.getElementById('skills-wrap').appendChild(div);
});

// REMOVE skill
document.addEventListener('click', function(e){
    if(e.target.classList.contains('btn-remove-skill')){
        e.target.closest('.skill-item').remove();
    }
});
</script>
@endpush

@endsection
