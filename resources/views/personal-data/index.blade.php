@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $personalData->name }} - Portfolio</title>

    <!-- Fonts / Bootstrap / AOS / Lottie -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <style>
        :root{
            --frost-1: #eef2ff; /* pale blue */
            --frost-2: #faf5ff; /* pale purple */
            --accent: #6b5ce6;  /* soft indigo */
            --accent-2: #7c8cff; /* soft blue */
            --card-bg: rgba(255,255,255,0.65);
            --muted: #6b7280;
        }

        html,body{
            height:100%;
            background: radial-gradient(1200px 600px at 10% 10%, rgba(124,140,255,0.12), transparent 12%),
                        radial-gradient(900px 400px at 90% 80%, rgba(235,220,255,0.10), transparent 8%),
                        linear-gradient(180deg, var(--frost-1) 0%, var(--frost-2) 60%, #ffffff 100%);
            font-family: 'Poppins', sans-serif;
            color: #111827;
            -webkit-font-smoothing:antialiased;
        }

        .container-wrap { padding: 60px 20px; }

        .page-title {
            font-weight: 700;
            text-align: center;
            font-size: 2.25rem;
            color: #0f1724;
            margin-bottom: 36px;
        }

        /* glass card */
        .glass-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.75), rgba(255,255,255,0.6));
            border-radius: 18px;
            padding: 26px;
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 10px 30px rgba(13,17,30,0.06);
            backdrop-filter: blur(8px) saturate(120%);
            transition: transform .28s ease, box-shadow .28s ease;
        }
        .glass-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 45px rgba(13,17,30,0.08);
        }

        /* profile */
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 16px;
            border: 4px solid rgba(255,255,255,0.85);
            box-shadow: 0 10px 30px rgba(99,102,241,0.10);
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            border: none;
            box-shadow: 0 8px 20px rgba(108,99,255,0.12);
            border-radius: 12px;
            padding: .55rem 1.1rem;
            font-weight: 600;
        }
        .btn-primary:hover { transform: translateY(-2px); }

        .skill-badge {
            background: linear-gradient(180deg, rgba(124,140,255,0.14), rgba(124,140,255,0.08));
            color: var(--accent);
            padding: .45rem .9rem;
            border-radius: 999px;
            font-weight:600;
            box-shadow: 0 6px 16px rgba(124,140,255,0.06);
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .skill-badge:hover { transform: translateY(-3px); box-shadow: 0 10px 22px rgba(124,140,255,0.12); color:#fff; background: linear-gradient(90deg,var(--accent),var(--accent-2)); }

        .timeline {
            border-left: 3px solid rgba(13,17,30,0.04);
            padding-left: 28px;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
            padding-left: 6px;
        }
        .timeline-dot {
            position: absolute;
            left: -36px;
            top: 6px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: white;
            border: 4px solid var(--accent);
            box-shadow: 0 6px 18px rgba(107,92,230,0.12);
        }

        .muted { color: var(--muted); }

        /* floating Lottie decorations */
        .lottie-deco { position: absolute; opacity: .22; pointer-events:none; }

        @media (max-width: 991px) {
            .page-title { font-size: 1.9rem; }
            .profile-img{ width:120px; height:120px; }
        }
    </style>
</head>

<body>
    <!-- decorative Lottie top-left -->
    <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_pprxh53t.json"
        class="lottie-deco" style="width:220px; height:220px; left:-40px; top:-30px;" background="transparent" speed="1" loop autoplay></lottie-player>

    <!-- decorative Lottie top-right -->
    <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_1pxqjqps.json"
        class="lottie-deco" style="width:180px; height:180px; right:-30px; top:40px;" background="transparent" speed="0.9" loop autoplay></lottie-player>

    <div class="container container-wrap">
        <h1 class="page-title" data-aos="zoom-in">Portfolio — {{ $personalData->name }}</h1>

        <div class="row g-4">

            <!-- profile card -->
            <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
                <div class="glass-card text-center">
                    @if($personalData->photo && Storage::disk('public')->exists($personalData->photo))
                        <img src="{{ asset('storage/' . $personalData->photo) }}" alt="Photo" class="profile-img mb-3">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($personalData->name) }}&background=EDEBFF&color=5A52DA&size=256" alt="Photo" class="profile-img mb-3">
                    @endif

                    <h3 class="fw-bold">{{ $personalData->name }}</h3>
                    <p class="text-muted mb-2">{{ $personalData->title }}</p>

                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <a href="{{ route('personal-data.edit') }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square me-2"></i>Edit Profile
                        </a>
                    </div>

                    <hr>

                    <div class="text-start">
                        <h6 class="fw-bold mb-2">Contact</h6>
                        <div class="mb-2 muted"><i class="bi bi-envelope me-2"></i>{{ $personalData->email }}</div>
                        <div class="mb-2 muted"><i class="bi bi-telephone me-2"></i>{{ $personalData->phone }}</div>
                        <div class="mb-2 muted"><i class="bi bi-geo-alt me-2"></i>{{ $personalData->address }}</div>
                        <div class="mb-2 muted"><i class="bi bi-calendar-event me-2"></i>{{ $personalData->birth_date }}</div>
                    </div>

                    @if($personalData->linkedin || $personalData->github)
                        <hr>
                        <div class="text-start">
                            <h6 class="fw-bold mb-2">Social</h6>
                            @if($personalData->linkedin)
                                <div class="mb-2"><i class="bi bi-linkedin me-2 text-primary"></i><a href="{{ $personalData->linkedin }}" target="_blank" class="muted">LinkedIn</a></div>
                            @endif
                            @if($personalData->github)
                                <div class="mb-2"><i class="bi bi-github me-2"></i><a href="{{ $personalData->github }}" target="_blank" class="muted">GitHub</a></div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- main content -->
            <div class="col-lg-8 d-flex flex-column gap-4">

                <!-- about -->
                <div class="glass-card" data-aos="fade-up" data-aos-delay="140">
                    <h4 class="fw-bold mb-3"><i class="bi bi-person-lines-fill me-2"></i>About Me</h4>
                    <p class="muted mb-0">{{ $personalData->summary }}</p>
                </div>

                <!-- skills -->
                <div class="glass-card" data-aos="fade-up" data-aos-delay="180">
                    <h4 class="fw-bold mb-3"><i class="bi bi-stars me-2"></i>Skills</h4>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($personalData->skills ?? [] as $skill)
                            <span class="skill-badge">{{ $skill }}</span>
                        @empty
                            <div class="w-100 text-center">
                                <lottie-player src="https://assets2.lottiefiles.com/private_files/lf30_m6j5igxb.json" style="width:120px;height:120px;margin:auto;" background="transparent" speed="0.9" loop autoplay></lottie-player>
                                <p class="muted small mt-2">No skills yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- experience -->
                <div class="glass-card" data-aos="fade-up" data-aos-delay="220">
                    <h4 class="fw-bold mb-3"><i class="bi bi-briefcase-fill me-2"></i>Work Experience</h4>

                    @if(empty($personalData->experience))
                        <div class="text-center py-4">
                            <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_u8o7BL.json" style="width:180px;height:180px;margin:auto;" background="transparent" speed="0.9" loop autoplay></lottie-player>
                            <p class="muted small mt-2">No experience added yet</p>
                        </div>
                    @else
                        <div class="timeline">
                            @foreach($personalData->experience as $exp)
                                <div class="timeline-item" data-aos="fade-left" data-aos-delay="{{ 40 * $loop->index }}">
                                    <div class="timeline-dot"></div>
                                    <h5 class="fw-semibold mb-1">{{ $exp['position'] }}</h5>
                                    <div class="mb-1"><span class="badge bg-light text-dark border">{{ $exp['period'] }}</span></div>
                                    <div class="text-primary small mb-1">{{ $exp['company'] }}</div>
                                    <p class="muted small mb-0">{{ $exp['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- education -->
                <div class="glass-card" data-aos="fade-up" data-aos-delay="260">
                    <h4 class="fw-bold mb-3"><i class="bi bi-mortarboard-fill me-2"></i>Education</h4>

                    @if(empty($personalData->education))
                        <div class="text-center py-4">
                            <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_ot5greq5.json" style="width:160px;height:160px;margin:auto;" background="transparent" speed="0.9" loop autoplay></lottie-player>
                            <p class="muted small mt-2">No education added yet</p>
                        </div>
                    @else
                        <div class="timeline">
                            @foreach($personalData->education as $edu)
                                <div class="timeline-item" data-aos="fade-left" data-aos-delay="{{ 40 * $loop->index }}">
                                    <div class="timeline-dot"></div>
                                    <h5 class="fw-semibold mb-1">{{ $edu['degree'] }}</h5>
                                    <div class="mb-1"><span class="badge bg-light text-dark border">{{ $edu['period'] }}</span></div>
                                    <div class="text-primary small mb-1">{{ $edu['institution'] }}</div>
                                    <p class="muted small mb-0">{{ $edu['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="text-center py-4 muted small">
            &copy; {{ date('Y') }} {{ $personalData->name }} — Frost Gradient Portfolio
        </div>
    </div>

    <!-- AOS & Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            AOS.init({ duration: 800, once: true, easing: 'ease-out-quad' });
        });
    </script>
</body>
</html>

@endsection
