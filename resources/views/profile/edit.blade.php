@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="min-height: 100vh;">

    <!-- HEADER HALAMAN -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold text-white mb-1">
                    <i class="fas fa-user-circle text-primary me-2"></i> Manajemen Profil
                </h3>
                <p class="text-light opacity-75 small mb-0">
                    Kelola informasi akun Anda: nama lengkap dan alamat email.
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

        <!-- KARTU IDENTITAS / AVATAR -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center h-100" style="background: linear-gradient(160deg, #1e293b 0%, #0f172a 100%);">
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">

                    <!-- Avatar Inisial Otomatis -->
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow"
                         style="width: 110px; height: 110px; background: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%); font-size: 2.4rem; font-weight: 700; color: #fff; border: 3px solid rgba(255,255,255,0.15);">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strrchr($user->name, ' '), 1, 1)) }}
                    </div>

                    <h5 class="fw-bold text-white mb-1">{{ $user->name }}</h5>
                    <p class="text-light opacity-75 small mb-3">{{ $user->email }}</p>

                    <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4);">
                        <i class="fas fa-shield-alt me-1"></i> Superadmin
                    </span>

                    <hr class="w-100 my-4" style="border-color: rgba(255,255,255,0.1);">

                    <div class="w-100 text-start">
                        <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <span class="text-light opacity-50 small"><i class="fas fa-calendar-alt me-2"></i>Bergabung Sejak</span>
                            <span class="text-white small fw-semibold">{{ $user->created_at?->translatedFormat('d M Y') ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <span class="text-light opacity-50 small"><i class="fas fa-key me-2"></i>Keamanan Akun</span>
                            <a href="{{ route('password.edit') }}" class="text-info small fw-semibold text-decoration-none">
                                Ubah Password <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        @if(auth()->user()->hasMenu('kelola-akun'))
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-light opacity-50 small"><i class="fas fa-user-secret me-2"></i>Akses Tim</span>
                            <a href="{{ route('team.manage') }}" class="text-info small fw-semibold text-decoration-none">
                                Kelola Akun <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- FORM EDIT PROFIL -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white h-100">
                <div class="card-header border-bottom py-3 px-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                    <h5 class="fw-bold text-white mb-0">
                        <i class="fas fa-id-card text-info me-2"></i> Informasi Akun
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-user text-muted me-1"></i> Nama Lengkap
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-envelope text-muted me-1"></i> Email
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection