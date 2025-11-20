@extends('layouts.app')

@section('content')

{{-- ================== CDNs: AOS, GSAP, Particles, Cropper, Lottie, SweetAlert ================== --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<style>
/* particles background */
#particles-js { position: fixed; inset:0; z-index:-1; background: linear-gradient(180deg,#f6f4ff 0%,#ffffff 60%); }

/* base */
body { font-family: 'Poppins', sans-serif; }

/* layout */
.editor-wrap { margin-top:40px; margin-bottom:60px; }
.left-panel { min-height:600px; }
.right-panel { position:sticky; top:20px; }

/* glass */
.glass-card {
  background: rgba(255,255,255,0.18);
  border-radius:18px; padding:28px;
  border:1px solid rgba(255,255,255,0.45);
  box-shadow:0 14px 40px rgba(10,10,20,0.06);
  backdrop-filter: blur(12px);
  transition:transform .3s ease, box-shadow .3s ease;
}
.glass-card:hover{ transform:translateY(-6px); box-shadow:0 20px 50px rgba(10,10,20,0.08); }

.section-title{ font-weight:700; color:#4b42e3; margin-bottom:12px; }
.profile-preview-img{
  width:140px;height:140px;object-fit:cover;border-radius:18px;
  border:4px solid rgba(255,255,255,0.55);
  box-shadow:0 12px 30px rgba(75,66,227,0.15);
  transition:transform .3s ease;
}
.profile-preview-img:hover{ transform:scale(1.03); }

.skill-chip{
  display:inline-block;background:rgba(75,66,227,0.12);color:#3f37c9;
  padding:.45rem .9rem;border-radius:999px;margin-right:.5rem;margin-bottom:.5rem;font-weight:600;cursor:pointer;
  transition:transform .15s ease;
}
.skill-chip:hover{ transform: translateY(-3px); box-shadow:0 6px 18px rgba(75,66,227,0.12); }

.preview-card{ border-radius:16px; overflow:hidden; }
.preview-hero{ background: linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%); padding:18px; color:#fff; }

.form-control{ border-radius:12px; border:1px solid rgba(0,0,0,0.08); box-shadow:none; background:white; }
.input-label{ font-weight:600; color:#212121; }

.btn-primary{ background:#5a52da; border-color:#5a52da; font-weight:600; border-radius:10px; }
.btn-success{ background:#28d47a; border-radius:10px; }
.btn-outline-lottie{ border-radius:12px; }

/* small timeline */
.timeline-line{ border-left:3px solid rgba(0,0,0,0.06); padding-left:20px; }
.timeline-dot{ width:12px;height:12px;background:#5a52da;border-radius:50%;display:inline-block;margin-right:10px; }

/* dark mode toggle */
.dark-toggle{ position: fixed; right:20px; bottom:20px; z-index:9999; border-radius:999px; box-shadow:0 8px 20px rgba(0,0,0,0.12); }

/* Lottie decoration (corner) */
.lottie-deco { position: absolute; right: -30px; top: -30px; width:160px; height:160px; opacity:0.18; pointer-events:none; }

/* responsive */
@media (max-width:991px){ .right-panel { position: static; margin-top:24px; } }
</style>

{{-- particles container --}}
<div id="particles-js"></div>

<div class="container editor-wrap">
  <div class="row g-4">
    {{-- LEFT: FORM --}}
    <div class="col-lg-7 left-panel">
      <div class="glass-card" data-aos="fade-right" data-aos-duration="800">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3 class="m-0">Edit Profile</h3>
          <div>
            <button id="clearDraftBtn" class="btn btn-sm btn-outline-secondary me-2" title="Clear local draft">Clear Draft</button>
            <a href="{{ route('personal-data.index') }}" class="btn btn-sm btn-secondary">Back</a>
          </div>
        </div>

        {{-- Lottie decoration --}}
        <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_8k6f3a3n.json"  background="transparent"  speed="1"  loop  autoplay  class="lottie-deco"></lottie-player>

        <form action="{{ route('personal-data.update') }}" method="POST" enctype="multipart/form-data" id="editForm">
          @csrf

          {{-- IMAGE CROPPER & INPUT --}}
          <div class="mb-3 text-center">
            <img id="photoPreview" src="{{ $personalData->photo ? asset('storage/' . $personalData->photo) : 'https://via.placeholder.com/140?text=No+Image' }}" class="profile-preview-img mb-3" alt="Preview">
            <div>
              <input type="file" accept="image/*" id="photoInput" name="photo" class="form-control form-control-sm" style="max-width:320px; margin:0 auto;">
            </div>
            <small class="text-muted d-block mt-2">Upload & crop photo sebelum disimpan</small>
          </div>

          {{-- BASIC --}}
          <h5 class="section-title">Basic</h5>
          <div class="mb-3">
            <label class="input-label">Name</label>
            <input name="name" class="form-control" id="inputName" value="{{ old('name', $personalData->name) }}">
          </div>
          <div class="mb-3">
            <label class="input-label">Title</label>
            <input name="title" class="form-control" id="inputTitle" value="{{ old('title', $personalData->title) }}">
          </div>

          {{-- CONTACT --}}
          <h5 class="section-title">Contact</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="input-label">Email</label>
              <input name="email" class="form-control" id="inputEmail" value="{{ old('email', $personalData->email) }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="input-label">Phone</label>
              <input name="phone" class="form-control" id="inputPhone" value="{{ old('phone', $personalData->phone) }}">
            </div>
          </div>
          <div class="mb-3">
            <label class="input-label">Address</label>
            <input name="address" class="form-control" id="inputAddress" value="{{ old('address', $personalData->address) }}">
          </div>

          {{-- PERSONAL & SOCIAL --}}
          <h5 class="section-title">Personal & Social</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="input-label">Date of Birth</label>
              <input name="birth_date" class="form-control" id="inputBirth" value="{{ old('birth_date', $personalData->birth_date) }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="input-label">Nationality</label>
              <input name="nationality" class="form-control" id="inputNationality" value="{{ old('nationality', $personalData->nationality) }}">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="input-label">LinkedIn</label>
              <input name="linkedin" class="form-control" id="inputLinkedin" value="{{ old('linkedin', $personalData->linkedin) }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="input-label">GitHub</label>
              <input name="github" class="form-control" id="inputGithub" value="{{ old('github', $personalData->github) }}">
            </div>
          </div>

          {{-- SUMMARY --}}
          <h5 class="section-title">Summary</h5>
          <div class="mb-3">
            <textarea name="summary" class="form-control" id="inputSummary" rows="4">{{ old('summary', $personalData->summary) }}</textarea>
          </div>

          {{-- SKILLS --}}
          <h5 class="section-title">Skills</h5>
          <div class="mb-2">
            <div class="d-flex gap-2 align-items-start">
              <input type="text" id="skillInput" class="form-control" placeholder="Type a skill & press Enter">
              <button type="button" id="addSkillBtnInline" class="btn btn-primary">Add</button>
              <button type="button" id="btnAddSkillLottie" class="btn btn-outline-lottie" title="Lottie add">
                <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_jbrw3hcz.json"  background="transparent"  speed="1"  style="width:36px;height:36px;"  loop  autoplay></lottie-player>
              </button>
            </div>
            <small class="text-muted">Klik chip untuk menghapus.</small>
          </div>
          <div id="skills-wrap" class="mb-3"></div>

          {{-- JSON FIELDS --}}
          <h5 class="section-title">Experience (JSON)</h5>
          <textarea name="experience_raw" class="form-control mb-3" rows="6" id="experienceRaw">{{ old('experience_raw', json_encode($personalData->experience, JSON_PRETTY_PRINT)) }}</textarea>

          <h5 class="section-title">Education (JSON)</h5>
          <textarea name="education_raw" class="form-control mb-3" rows="5" id="educationRaw">{{ old('education_raw', json_encode($personalData->education, JSON_PRETTY_PRINT)) }}</textarea>

          {{-- Save --}}
          <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-success btn-lg flex-fill" id="saveBtn">
              <i class="bi bi-save me-2"></i> Save Changes
            </button>
            <button type="button" id="previewBtn" class="btn btn-outline-secondary btn-lg">Preview</button>
          </div>

        </form>
      </div>
    </div>

    {{-- RIGHT: LIVE PREVIEW --}}
    <div class="col-lg-5 right-panel">
      <div class="preview-card glass-card" data-aos="fade-left" data-aos-duration="800">
        <div class="preview-hero d-flex gap-3 align-items-center position-relative">
          <img id="previewPhoto" src="{{ $personalData->photo ? asset('storage/' . $personalData->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($personalData->name) . '&background=random' }}" style="width:96px;height:96px;border-radius:12px;object-fit:cover;">
          <div>
            <h4 id="previewName" class="mb-0">{{ $personalData->name }}</h4>
            <div id="previewTitle" class="small" style="opacity:.9">{{ $personalData->title }}</div>
          </div>
          {{-- subtle lottie on preview corner --}}
          <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_8ohv9vuc.json"  background="transparent"  speed="0.9"  style="width:56px;height:56px;position:absolute;right:12px;top:8px;opacity:.9;"  loop  autoplay></lottie-player>
        </div>

        <div class="p-3">
          <h6 class="fw-bold">Summary</h6>
          <p id="previewSummary" class="text-muted small">{{ $personalData->summary }}</p>

          <hr>

          <h6 class="fw-bold">Skills</h6>
          <div id="previewSkills" class="mb-3"></div>

          <h6 class="fw-bold">Contact</h6>
          <div class="mb-2 small text-muted">
            <div><i class="bi bi-envelope me-2"></i><span id="previewEmail">{{ $personalData->email }}</span></div>
            <div><i class="bi bi-telephone me-2"></i><span id="previewPhone">{{ $personalData->phone }}</span></div>
            <div><i class="bi bi-geo-alt me-2"></i><span id="previewAddress">{{ $personalData->address }}</span></div>
          </div>

          <hr>

          <h6 class="fw-bold">Work Experience</h6>
          <div id="previewExperience" class="timeline-line small text-muted"></div>

          <hr>

          <h6 class="fw-bold">Education</h6>
          <div id="previewEducation" class="timeline-line small text-muted"></div>

        </div>
      </div>
    </div>

  </div>
</div>

{{-- Crop Modal --}}
<div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title">Crop Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div style="max-height:60vh; overflow:auto;">
          <img id="cropImage" style="width:100%; display:block; max-height:70vh; object-fit:contain;">
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" id="applyCropBtn" class="btn btn-success">Apply Crop</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

{{-- Dark Mode Toggle --}}
<button id="darkModeBtn" class="btn btn-dark dark-toggle p-2" title="Toggle dark mode">
  <i id="darkIcon" class="bi bi-moon-fill"></i>
</button>

{{-- Session alerts: use Lottie success on success --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function(){
  Swal.fire({
    title: 'Updated!',
    html: `<lottie-player src="https://assets2.lottiefiles.com/packages/lf20_jbrw3hcz.json"  background="transparent"  speed="1"  style="width:160px;height:160px;"  autoplay></lottie-player><div style="margin-top:10px;">{{ session('success') }}</div>`,
    showConfirmButton: true,
    confirmButtonColor: '#6c63ff'
  });
});
</script>
@endif

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function(){
  Swal.fire({ title:'Validation Error', html: `{!! implode('<br>', $errors->all()) !!}`, icon:'error' });
});
</script>
@endif

@push('scripts')
<script>
/* ===== INIT ===== */
AOS.init({ once:true, duration:700 });
particlesJS('particles-js', {
  particles: {
    number: { value: 55, density: { enable:true, value_area:800 } },
    color: { value: "#6c63ff" },
    shape: { type: "circle" },
    opacity: { value: 0.25 },
    size: { value: 3 },
    line_linked: { enable:true, distance:120, color:"#6c63ff", opacity:.12, width:1 },
    move: { enable:true, speed:1.6, out_mode:"out" }
  },
  interactivity: { detect_on:"canvas", events:{ onhover:{ enable:true, mode:"grab" }, onclick:{ enable:true, mode:"push" } }, modes:{ grab:{ distance:150, line_linked:{ opacity:.2 } }, push:{ particles_nb:4 } } },
  retina_detect:true
});
gsap.to("#photoPreview", { y:10, duration:3, repeat:-1, yoyo:true, ease:"power1.inOut" });

/* ===== Elements ===== */
const editForm = document.getElementById('editForm');
const photoInput = document.getElementById('photoInput');
const photoPreview = document.getElementById('photoPreview');
const cropModalEl = document.getElementById('cropModal');
const cropImage = document.getElementById('cropImage');
const applyCropBtn = document.getElementById('applyCropBtn');
let cropper = null;

/* ===== Image Cropper Flow ===== */
photoInput.addEventListener('change', (e) => {
  const file = e.target.files[0];
  if(!file) return;
  const reader = new FileReader();
  reader.onload = function(ev){
    cropImage.src = ev.target.result;
    const modal = new bootstrap.Modal(cropModalEl);
    modal.show();
    cropModalEl.addEventListener('shown.bs.modal', function(){
      if(cropper) cropper.destroy();
      cropper = new Cropper(cropImage, { aspectRatio:1, viewMode:1, background:false, autoCropArea:1 });
    }, { once:true });
  };
  reader.readAsDataURL(file);
});
applyCropBtn.addEventListener('click', () => {
  if(!cropper) return;
  const canvas = cropper.getCroppedCanvas({ width:600, height:600, imageSmoothingQuality:'high' });
  const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
  photoPreview.src = dataUrl;
  // convert dataURL to file and set to input
  fetch(dataUrl).then(res => res.blob()).then(blob => {
    const file = new File([blob], 'cropped.jpg', { type: blob.type });
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    photoInput.files = dataTransfer.files;
  });
  const modal = bootstrap.Modal.getInstance(cropModalEl);
  modal.hide();
  cropper.destroy(); cropper = null;
});

/* ===== Skills Chip System ===== */
const skillsWrap = document.getElementById('skills-wrap');
const skillInput = document.getElementById('skillInput');
const addSkillBtnInline = document.getElementById('addSkillBtnInline');
let skills = {!! json_encode($personalData->skills ?? []) !!};

function renderSkills(){
  skillsWrap.innerHTML = '';
  skills.forEach((s, idx) => {
    const chip = document.createElement('span');
    chip.className = 'skill-chip';
    chip.innerHTML = `${s} <span style="opacity:.7; margin-left:.4rem;">&times;</span>`;
    chip.onclick = () => { skills.splice(idx,1); renderSkills(); updatePreviewSkills(); };
    skillsWrap.appendChild(chip);
  });
  // remove old hidden inputs then add new
  document.querySelectorAll('input[name="skills[]"]').forEach(n=>n.remove());
  skills.forEach(s => {
    const h = document.createElement('input'); h.type='hidden'; h.name='skills[]'; h.value=s; editForm.appendChild(h);
  });
}
renderSkills();
addSkillBtnInline.addEventListener('click', addSkillFromInput);
skillInput.addEventListener('keydown', (e)=>{ if(e.key==='Enter'){ e.preventDefault(); addSkillFromInput(); }});
function addSkillFromInput(){ const v = skillInput.value.trim(); if(!v) return; skills.push(v); skillInput.value=''; renderSkills(); updatePreviewSkills(); lottieClickAdd(); }

/* small lottie click effect */
function lottieClickAdd(){
  const player = document.createElement('lottie-player');
  player.setAttribute('src','https://assets2.lottiefiles.com/packages/lf20_jbrw3hcz.json');
  player.setAttribute('background','transparent'); player.style.width='80px'; player.style.height='80px';
  player.style.position='fixed'; player.style.right='24px'; player.style.bottom='100px'; player.style.zIndex=9999;
  document.body.appendChild(player);
  setTimeout(()=> player.remove(), 1500);
}

/* ===== Preview update ===== */
const previewName = document.getElementById('previewName');
const previewTitle = document.getElementById('previewTitle');
const previewPhoto = document.getElementById('previewPhoto');
const previewSummary = document.getElementById('previewSummary');
const previewEmail = document.getElementById('previewEmail');
const previewPhone = document.getElementById('previewPhone');
const previewAddress = document.getElementById('previewAddress');
const previewSkills = document.getElementById('previewSkills');
const previewExperience = document.getElementById('previewExperience');
const previewEducation = document.getElementById('previewEducation');

function updatePreview(){
  previewName.textContent = document.getElementById('inputName').value || '{{ $personalData->name }}';
  previewTitle.textContent = document.getElementById('inputTitle').value || '{{ $personalData->title }}';
  previewSummary.textContent = document.getElementById('inputSummary').value || '{{ $personalData->summary }}';
  previewEmail.textContent = document.getElementById('inputEmail').value || '{{ $personalData->email }}';
  previewPhone.textContent = document.getElementById('inputPhone').value || '{{ $personalData->phone }}';
  previewAddress.textContent = document.getElementById('inputAddress').value || '{{ $personalData->address }}';
  previewPhoto.src = photoPreview.src;
  updatePreviewSkills();
  updatePreviewJSON();
}

function updatePreviewSkills(){
  previewSkills.innerHTML = '';
  skills.forEach(s => {
    const sp = document.createElement('span'); sp.className='skill-chip'; sp.innerText = s; previewSkills.appendChild(sp);
  });
  if(skills.length===0){
    // show empty-state Lottie
    previewSkills.innerHTML = `<div class="text-muted small d-flex align-items-center gap-2"><lottie-player src="https://assets5.lottiefiles.com/packages/lf20_jtbfg2nb.json" background="transparent" speed="0.9" style="width:80px;height:80px;"></lottie-player>No skills yet</div>`;
  }
}

function updatePreviewJSON(){
  try{
    const exp = JSON.parse(document.getElementById('experienceRaw').value || '[]');
    previewExperience.innerHTML = '';
    if(Array.isArray(exp) && exp.length){
      exp.forEach(it => {
        const d = document.createElement('div'); d.className='mb-3';
        d.innerHTML = `<div><span class="timeline-dot"></span><strong>${it.position ?? it.title ?? 'Position'}</strong> <small class="text-muted"> — ${it.period ?? ''}</small></div>
                       <div class="text-primary small mb-1">${it.company ?? ''}</div>
                       <div class="small text-muted">${it.description ?? ''}</div>`;
        previewExperience.appendChild(d);
      });
    } else previewExperience.innerHTML = '<div class="text-muted">No experience listed.</div>';
  }catch(e){ previewExperience.innerHTML = '<div class="text-danger">Invalid Experience JSON</div>'; }

  try{
    const edu = JSON.parse(document.getElementById('educationRaw').value || '[]');
    previewEducation.innerHTML = '';
    if(Array.isArray(edu) && edu.length){
      edu.forEach(it => {
        const d = document.createElement('div'); d.className='mb-3';
        d.innerHTML = `<div><span class="timeline-dot"></span><strong>${it.degree ?? ''}</strong> <small class="text-muted"> — ${it.period ?? ''}</small></div>
                       <div class="text-primary small mb-1">${it.institution ?? ''}</div>
                       <div class="small text-muted">${it.description ?? ''}</div>`;
        previewEducation.appendChild(d);
      });
    } else previewEducation.innerHTML = '<div class="text-muted">No education listed.</div>';
  }catch(e){ previewEducation.innerHTML = '<div class="text-danger">Invalid Education JSON</div>'; }
}

['inputName','inputTitle','inputSummary','inputEmail','inputPhone','inputAddress','inputBirth','inputNationality','inputLinkedin','inputGithub','experienceRaw','educationRaw'].forEach(id=>{
  const el = document.getElementById(id);
  if(el) el.addEventListener('input', updatePreview);
});

// photo preview sync
photoInput.addEventListener('change', function(){
  if(photoInput.files && photoInput.files[0]){
    const reader = new FileReader();
    reader.onload = function(e){ previewPhoto.src = e.target.result; updatePreview(); };
    reader.readAsDataURL(photoInput.files[0]);
  }
});
updatePreview();

/* ===== Autosave draft (localStorage) ===== */
const DRAFT_KEY = 'personal_edit_draft_v2';
function saveDraft(){
  const draft = {
    name: document.getElementById('inputName').value || '',
    title: document.getElementById('inputTitle').value || '',
    email: document.getElementById('inputEmail').value || '',
    phone: document.getElementById('inputPhone').value || '',
    address: document.getElementById('inputAddress').value || '',
    summary: document.getElementById('inputSummary').value || '',
    skills: skills,
    experience_raw: document.getElementById('experienceRaw').value || '',
    education_raw: document.getElementById('educationRaw').value || ''
  };
  localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
}
let saveTimer = null;
document.querySelectorAll('input, textarea').forEach(i=>{
  i.addEventListener('input', ()=>{
    if(saveTimer) clearTimeout(saveTimer);
    saveTimer = setTimeout(()=> saveDraft(), 700);
  });
});
document.addEventListener('DOMContentLoaded', ()=>{
  const raw = localStorage.getItem(DRAFT_KEY);
  if(raw){
    try{
      const d = JSON.parse(raw);
      if(d.name) document.getElementById('inputName').value = d.name;
      if(d.title) document.getElementById('inputTitle').value = d.title;
      if(d.email) document.getElementById('inputEmail').value = d.email;
      if(d.phone) document.getElementById('inputPhone').value = d.phone;
      if(d.address) document.getElementById('inputAddress').value = d.address;
      if(d.summary) document.getElementById('inputSummary').value = d.summary;
      if(Array.isArray(d.skills) && d.skills.length){ skills = d.skills; renderSkillsHidden(); renderSkills(); updatePreviewSkills(); }
      if(d.experience_raw) document.getElementById('experienceRaw').value = d.experience_raw;
      if(d.education_raw) document.getElementById('educationRaw').value = d.education_raw;
      updatePreview();
    }catch(e){}
  }
});
document.getElementById('clearDraftBtn').addEventListener('click', ()=>{
  localStorage.removeItem(DRAFT_KEY);
  Swal.fire({ title:'Cleared', text:'Draft removed', icon:'success', timer:1200, showConfirmButton:false });
});

/* ===== Save with SweetAlert + Lottie loading ===== */
editForm.addEventListener('submit', function(e){
  e.preventDefault();
  const nameVal = document.getElementById('inputName').value.trim();
  if(!nameVal){ Swal.fire({ title:'Oops', text:'Name cannot be empty', icon:'warning' }); return; }

  // show Lottie loading inside Swal
  Swal.fire({
    title: 'Saving...',
    html: `<lottie-player src="https://assets2.lottiefiles.com/packages/lf20_usmfx6bp.json"  background="transparent"  speed="1"  style="width:200px;height:200px;"  loop  autoplay></lottie-player>`,
    showConfirmButton:false,
    allowOutsideClick:false,
    didOpen: ()=> {}
  });

  // append hidden skills again (ensure latest)
  document.querySelectorAll('input[name="skills[]"]').forEach(n=>n.remove());
  skills.forEach(s => { const h = document.createElement('input'); h.type='hidden'; h.name='skills[]'; h.value=s; editForm.appendChild(h); });

  // small delay to show animation (UX), then submit
  setTimeout(()=> { editForm.submit(); }, 800);
});

/* helper to re-render hidden skills */
function renderSkillsHidden(){ document.querySelectorAll('input[name="skills[]"]').forEach(n=>n.remove()); skills.forEach(s => { const h = document.createElement('input'); h.type='hidden'; h.name='skills[]'; h.value=s; editForm.appendChild(h); }); }
renderSkillsHidden();

/* ===== Dark mode toggle ===== */
const darkBtn = document.getElementById('darkModeBtn');
const darkIcon = document.getElementById('darkIcon');
darkBtn.addEventListener('click', () => {
  document.body.classList.toggle('dark-mode');
  const isDark = document.body.classList.contains('dark-mode');
  darkIcon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
  localStorage.setItem('edit_dark_mode', isDark ? '1' : '0');
});
if(localStorage.getItem('edit_dark_mode')==='1'){ document.body.classList.add('dark-mode'); darkIcon.className='bi bi-sun-fill'; }
const darkStyle = document.createElement('style'); darkStyle.innerHTML = `
.dark-mode { background:#0f1724 !important; color:#e6eef8 !important; }
.dark-mode .glass-card{ background: rgba(12,12,20,0.55) !important; border:1px solid rgba(255,255,255,0.06) !important; }
.dark-mode .form-control{ background: rgba(255,255,255,0.03); color:#e6eef8; border:1px solid rgba(255,255,255,0.06); }
.dark-mode .section-title{ color:#bfbcff; }
.dark-mode .profile-preview-img{ box-shadow:0 12px 30px rgba(0,0,0,0.45); border-color: rgba(255,255,255,0.06); }`; document.head.appendChild(darkStyle);

/* ===== Preview modal (bigger) ===== */
document.getElementById('previewBtn').addEventListener('click', ()=>{
  const html = `
    <div style="text-align:center">
      <img src="${previewPhoto.src}" style="width:140px;height:140px;border-radius:12px;object-fit:cover;margin-bottom:10px;">
      <h3 style="margin:0">${escapeHtml(previewName.textContent)}</h3>
      <div style="opacity:0.8;margin-bottom:8px">${escapeHtml(previewTitle.textContent)}</div>
      <p style="color:#666;text-align:left;margin-top:10px">${escapeHtml(previewSummary.textContent)}</p>
    </div>`;
  Swal.fire({ title:'Live Preview', html, width:700, showCloseButton:true, confirmButtonText:'Close' });
});

/* ===== Utility escapeHtml ===== */
function escapeHtml(str){ if(!str) return ''; return str.replace(/[&<>"'`=\/]/g, function(s){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','/':'&#x2F;','`':'&#x60;','=':'&#x3D;'})[s]; }); }

/* ===== on unload save draft ===== */
window.addEventListener('beforeunload', saveDraft);
</script>
@endpush

@endsection
