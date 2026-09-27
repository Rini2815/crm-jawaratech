@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="min-height: 100vh;">

    <!-- HEADER HALAMAN -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold text-white mb-1">
                    <i class="fas fa-key text-primary me-2"></i> Ubah Password
                </h3>
                <p class="text-light opacity-75 small mb-0">
                    Perbarui kata sandi akun Anda secara berkala demi keamanan.
                </p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success rounded-4 shadow-sm">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row g-4">

        <!-- KARTU TIPS KEAMANAN -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100" style="background: linear-gradient(160deg, #1e293b 0%, #0f172a 100%);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width: 56px; height: 56px; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.4);">
                            <i class="fas fa-shield-alt text-info fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-0">Tips Password Kuat</h6>
                            <span class="text-light opacity-50" style="font-size: 0.78rem;">Ikuti panduan ini</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-2 mb-3">
                        <i class="fas fa-check-circle text-success mt-1"></i>
                        <span class="text-light opacity-75 small">Gunakan minimal 8 karakter, semakin panjang semakin baik.</span>
                    </div>
                    <div class="d-flex align-items-start gap-2 mb-3">
                        <i class="fas fa-check-circle text-success mt-1"></i>
                        <span class="text-light opacity-75 small">Kombinasikan huruf besar, huruf kecil, dan angka.</span>
                    </div>
                    <div class="d-flex align-items-start gap-2 mb-3">
                        <i class="fas fa-check-circle text-success mt-1"></i>
                        <span class="text-light opacity-75 small">Tambahkan simbol seperti <code>!</code> <code>@</code> <code>#</code> untuk keamanan ekstra.</span>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <i class="fas fa-times-circle text-danger mt-1"></i>
                        <span class="text-light opacity-75 small">Hindari tanggal lahir, nama, atau kata yang mudah ditebak.</span>
                    </div>

                    <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

                    <div class="d-flex align-items-center gap-2 text-info small fw-semibold">
                        <i class="fas fa-lock"></i>
                        <span>Password Anda dienkripsi &amp; tidak pernah ditampilkan ke siapa pun.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORM UBAH PASSWORD -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white h-100">
                <div class="card-header border-bottom py-3 px-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                    <h5 class="fw-bold text-white mb-0">
                        <i class="fas fa-lock text-info me-2"></i> Ganti Kata Sandi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update.self') }}" id="formUbahPassword">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-unlock-alt text-muted me-1"></i> Password Saat Ini
                            </label>
                            <div class="input-group">
                                <input type="password" name="current_password" id="currentPassword"
                                       class="form-control form-control-lg @error('current_password') is-invalid @enderror">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="currentPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-key text-muted me-1"></i> Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" id="newPassword"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="newPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Indikator Kekuatan Password -->
                        <div class="mb-3">
                            <div class="progress" style="height: 6px; border-radius: 10px; background-color: #e9ecef;">
                                <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%; border-radius: 10px; transition: all 0.3s ease;"></div>
                            </div>
                            <small id="passwordStrengthText" class="text-muted">Minimal 8 karakter.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-check-double text-muted me-1"></i> Konfirmasi Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="confirmPassword" class="form-control form-control-lg">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small id="passwordMatchText" class="text-muted"></small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                                <i class="fas fa-save me-1"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Toggle show/hide password
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const target = document.getElementById(btn.getAttribute('data-target'));
            const icon = btn.querySelector('i');
            if (target.type === 'password') {
                target.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                target.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Indikator kekuatan password
    const newPassword = document.getElementById('newPassword');
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('passwordStrengthText');

    newPassword.addEventListener('input', function () {
        const val = newPassword.value;
        let score = 0;

        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[a-z]/.test(val) && /[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { width: '0%',   color: '#e9ecef', text: 'Minimal 8 karakter.', textColor: 'text-muted' },
            { width: '25%',  color: '#dc3545', text: 'Lemah &mdash; tambahkan huruf besar & angka.', textColor: 'text-danger' },
            { width: '50%',  color: '#fd7e14', text: 'Cukup &mdash; tambahkan simbol untuk lebih kuat.', textColor: 'text-warning' },
            { width: '75%',  color: '#0dcaf0', text: 'Baik.', textColor: 'text-info' },
            { width: '100%', color: '#198754', text: 'Sangat kuat!', textColor: 'text-success' },
        ];

        const level = val.length === 0 ? levels[0] : levels[score] || levels[1];

        strengthBar.style.width = level.width;
        strengthBar.style.backgroundColor = level.color;
        strengthText.innerHTML = level.text;
        strengthText.className = level.textColor;
    });

    // Cek kecocokan konfirmasi password
    const confirmPassword = document.getElementById('confirmPassword');
    const matchText = document.getElementById('passwordMatchText');

    function checkMatch() {
        if (confirmPassword.value.length === 0) {
            matchText.textContent = '';
            return;
        }
        if (confirmPassword.value === newPassword.value) {
            matchText.textContent = 'Password cocok.';
            matchText.className = 'text-success';
        } else {
            matchText.textContent = 'Password belum sama.';
            matchText.className = 'text-danger';
        }
    }

    newPassword.addEventListener('input', checkMatch);
    confirmPassword.addEventListener('input', checkMatch);
});
</script>
@endsection