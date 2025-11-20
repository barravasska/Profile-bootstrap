@extends('layouts.app') <!-- sesuaikan layout -->

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Profile</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('personal-data.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 text-center">
                            @if($personalData && $personalData->photo)
                                <img id="photoPreview" src="{{ asset('storage/' . $personalData->photo) }}" style="width:140px;height:140px;object-fit:cover;border-radius:10px;">
                            @else
                                <img id="photoPreview" src="https://via.placeholder.com/140x140?text=No+Image" style="width:140px;height:140px;object-fit:cover;border-radius:10px;">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                            @error('photo')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" value="{{ old('name', $personalData->name ?? '') }}" class="form-control">
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input name="title" value="{{ old('title', $personalData->title ?? '') }}" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" value="{{ old('email', $personalData->email ?? '') }}" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input name="phone" value="{{ old('phone', $personalData->phone ?? '') }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Summary</label>
                            <textarea name="summary" class="form-control" rows="4">{{ old('summary', $personalData->summary ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Skills (add multiple)</label>
                            <div id="skills-wrap">
                                @php
                                    $skills = old('skills', $personalData->skills ?? []);
                                    if (!is_array($skills)) $skills = [];
                                @endphp
                                @if(count($skills))
                                    @foreach($skills as $s)
                                    <div class="input-group mb-2 skill-item">
                                        <input name="skills[]" class="form-control" value="{{ $s }}">
                                        <button type="button" class="btn btn-outline-danger btn-remove-skill">-</button>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 skill-item">
                                        <input name="skills[]" class="form-control" value="">
                                        <button type="button" class="btn btn-outline-danger btn-remove-skill">-</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="addSkillBtn" class="btn btn-sm btn-outline-primary">+ Add skill</button>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Experience (JSON)</label>
                            <textarea name="experience_raw" class="form-control" rows="6" placeholder='[{"position":"Dev","company":"X","period":"2020","description":"..."}, ...]'>{{ old('experience_raw', json_encode($personalData->experience ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                            <small class="text-muted">Isi sebagai JSON atau kosongkan.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Education (JSON)</label>
                            <textarea name="education_raw" class="form-control" rows="4">{{ old('education_raw', json_encode($personalData->education ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('personal-data.index') }}" class="btn btn-secondary">Batal</a>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- small JS untuk preview foto dan dynamic skill -->
@push('scripts')
<script>
document.getElementById('photo')?.addEventListener('change', function(e){
    const file = e.target.files[0];
    if(!file) return;
    const reader = new FileReader();
    reader.onload = function(evt){
        document.getElementById('photoPreview').src = evt.target.result;
    }
    reader.readAsDataURL(file);
});

// skills add/remove
document.getElementById('addSkillBtn')?.addEventListener('click', function(){
    const wrap = document.getElementById('skills-wrap');
    const div = document.createElement('div');
    div.className = 'input-group mb-2 skill-item';
    div.innerHTML = '<input name="skills[]" class="form-control" value=""><button type="button" class="btn btn-outline-danger btn-remove-skill">-</button>';
    wrap.appendChild(div);
});

document.addEventListener('click', function(e){
    if(e.target && e.target.classList.contains('btn-remove-skill')){
        e.target.closest('.skill-item').remove();
    }
});
</script>
@endpush

@endsection
