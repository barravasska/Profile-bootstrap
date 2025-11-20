<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Data - {{ $personalData->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { background-color: #f8f9fa; }
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .profile-card {
            border: none; border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        .skill-badge {
            display: inline-block; background-color: #e9ecef;
            color: #495057; padding: .375rem .75rem;
            border-radius: 20px; margin: .25rem;
            font-size: .875rem;
        }
        .section-title {
            position: relative; padding-bottom: .5rem; margin-bottom: 1.5rem;
        }
        .section-title::after {
            content:''; position:absolute; bottom:0; left:0;
            width:50px; height:3px;
            background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
        }
        .timeline-item {
            position:relative; padding-left:2rem; margin-bottom:2rem;
        }
        .timeline-item::before {
            content:''; position:absolute; left:.5rem; top:.5rem;
            width:12px; height:12px; border-radius:50%;
            background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
        }
        .timeline-item::after {
            content:''; position:absolute; left:1rem; top:1.5rem;
            width:2px; height:calc(100% - 1rem); background:#dee2e6;
        }
        .timeline-item:last-child::after { display:none; }
    </style>
</head>

<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Profile Card -->
            <div class="card profile-card">

                <!-- Profile Header -->
                <div class="profile-header p-4">
                    <div class="row align-items-center">

                        <!-- FOTO DINAMIS -->
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            @if($personalData->photo && Storage::disk('public')->exists($personalData->photo))
                                <img src="{{ asset('storage/' . $personalData->photo) }}"
                                     alt="Profile Picture"
                                     class="rounded-circle border border-3 border-white shadow-sm"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/100"
                                     class="rounded-circle border border-3 border-white shadow-sm"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                        </div>

                        <!-- NAMA + TITLE -->
                        <div class="col-md-10 d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="mb-1">{{ $personalData->name }}</h1>
                                <h4 class="mb-2 opacity-75">{{ $personalData->title }}</h4>
                                <p class="mb-0">{{ $personalData->summary }}</p>
                            </div>

                            <!-- BUTTON EDIT -->
                            <div>
                                <a href="{{ route('personal-data.edit') }}" class="btn btn-light">
                                    Edit
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- PROFILE BODY -->
                <div class="card-body p-4">

                    <!-- CONTACT INFO -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h3 class="section-title">Contact Information</h3>
                            <div class="row">

                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><strong>Email:</strong> {{ $personalData->email }}</li>
                                        <li class="mb-2"><strong>Phone:</strong> {{ $personalData->phone }}</li>
                                        <li class="mb-2"><strong>Date of Birth:</strong> {{ $personalData->birth_date }}</li>
                                    </ul>
                                </div>

                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><strong>Address:</strong> {{ $personalData->address }}</li>
                                        <li class="mb-2"><strong>Nationality:</strong> {{ $personalData->nationality }}</li>
                                        <li class="mb-2"><strong>LinkedIn:</strong> {{ $personalData->linkedin }}</li>
                                        <li class="mb-2"><strong>GitHub:</strong> {{ $personalData->github }}</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- SKILLS -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h3 class="section-title">Skills & Expertise</h3>
                            <div>
                                @foreach($personalData->skills ?? [] as $skill)
                                    <span class="skill-badge">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- EXPERIENCE -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h3 class="section-title">Work Experience</h3>

                            @foreach($personalData->experience ?? [] as $exp)
                                <div class="timeline-item">
                                    <div>
                                        <h5 class="mb-0">{{ $exp['position'] }}</h5>
                                        <p class="text-muted mb-1">{{ $exp['company'] }}</p>
                                        <p class="text-primary mb-2">{{ $exp['period'] }}</p>
                                        <p class="mb-0">{{ $exp['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- EDUCATION -->
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="section-title">Education</h3>

                            @foreach($personalData->education ?? [] as $edu)
                                <div class="timeline-item">
                                    <div>
                                        <h5 class="mb-0">{{ $edu['degree'] }}</h5>
                                        <p class="text-muted mb-1">{{ $edu['institution'] }}</p>
                                        <p class="text-primary mb-2">{{ $edu['period'] }}</p>
                                        <p class="mb-0">{{ $edu['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
</body>
</html>
