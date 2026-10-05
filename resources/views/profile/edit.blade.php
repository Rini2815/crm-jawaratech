@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' & Custom CSS Jawaratech -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body, html {
    background-color: #f1f5f9 !important; 
}
.crm-wrapper {
    font-family: 'Inter', sans-serif;
    color: #0f172a;
}

/* Card Tegas */
.crm-card-solid {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 6px; 
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}
.border-top-primary {
    border-top: 4px solid #2563eb !important;
}
.border-top-navy {
    border-top: 4px solid #1e293b !important;
}

/* ==========================================
   INPUT FORM DENGAN RONA BIRU MUDA
   ========================================== */
.form-control-solid {
    border-radius: 0 4px 4px 0; 
    border: 1px solid #cbd5e1;
    padding: 0.7rem 0.8rem;
    font-size: 0.95rem;
    font-weight: 500;
    color: #0f172a;
    background-color: #f8fafc; /* Abu-abu kebiruan sangat muda */
    transition: all 0.2s ease;
}
.form-control-solid:focus {
    background-color: #ffffff; /* Berubah putih bersih HANYA saat diketik */
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    outline: none;
}
.input-group-text-solid {
    background-color: #e0e7ff; /* Kotak ikon warna biru muda/indigo */
    border: 1px solid #cbd5e1;
    border-right: none;
    border-radius: 4px 0 0 4px;
    color: #2563eb; /* Ikon warna biru tegas */
    min-width: 45px;
    justify-content: center;
}

.form-label-solid {
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #334155;
    margin-bottom: 0.5rem;
}

/* Tombol Aksi Menonjol */
.btn-action-primary {
    background-color: #2563eb;
    border-color: #2563eb;
    font-size: 0.95rem;
    padding: 0.6rem 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
    transition: all 0.3s ease;
}
.btn-action-primary:hover {
    background-color: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 6px 10px -1px rgba(37, 99, 235, 0.4);
}
</style>

<div class="container-fluid px-4 pt-4 pb-4 crm-wrapper">

    <!-- HEADER HALAMAN -->
    <div class="card border-0 mb-4 shadow-sm" style="background-color: #1e293b; border-radius: 8px;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 text-white" style="font-weight: 700; letter-spacing: -0.5px;">
                    <i class="fas fa-id-badge text-info me-2"></i> Manajemen Profil Akses
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-size: 0.85rem;">
                    Pusat kendali informasi identitas dan keamanan akun Anda di sistem CRM Jawaratech.
                </p>
            </div>
        </div>
    </div>

    <!-- NOTIFIKASI -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 d-flex align-items-center shadow-sm" style="border-radius: 6px; background-color: #dcfce7; color: #166534; border-left: 4px solid #16a34a !important;">
            <i class="fas fa-check-circle fa-lg me-3"></i>
            <div>
                <strong>Pembaruan Berhasil!</strong><br>
                <span style="font-size: 0.85rem;">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" style="border-radius: 6px; background-color: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626 !important;">
            <i class="fas fa-exclamation-triangle me-2"></i><strong>Terdapat Kesalahan!</strong> Periksa kembali form pengisian Anda.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">

        <!-- KARTU IDENTITAS (Sisi Kiri) -->
        <div class="col-lg-4">
            <div class="card crm-card-solid border-top-primary h-100">
                <div class="card-body p-4 text-center d-flex flex-column align-items-center">
                    
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm"
                         style="width: 100px; height: 100px; background-color: #eff6ff; border: 3px solid #bfdbfe; font-size: 2.2rem; font-weight: 700; color: #2563eb;">
                        @php
                            $names = explode(' ', $user->name);
                            $initials = strtoupper(substr($names[0], 0, 1));
                            if (count($names) > 1) {
                                $initials .= strtoupper(substr(end($names), 0, 1));
                            }
                        @endphp
                        {{ $initials }}
                    </div>

                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1.2rem;">{{ $user->name }}</h5>
                    <p class="text-secondary mb-3" style="font-size: 0.9rem;">{{ $user->email }}</p>

                    <div class="badge px-3 py-2 mb-4" style="background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; font-weight: 700; letter-spacing: 0.5px;">
                        <i class="fas fa-user-tag text-primary me-1"></i> {{ $user->role ?? 'Staf Sistem' }}
                    </div>

                    <div class="w-100 mt-auto pt-3 border-top text-start">
                        <p class="text-muted mb-2" style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">Keamanan Akun</p>
                        
                        <button type="button" class="btn w-100 d-flex justify-content-between align-items-center fw-bold shadow-sm" 
                                style="border-radius: 4px; font-size: 0.9rem; background-color: #ffffff; border: 1px solid #cbd5e1; color: #334155;" 
                                data-bs-toggle="modal" data-target="#modalUbahPassword" data-bs-target="#modalUbahPassword"
                                onmouseover="this.style.borderColor='#38bdf8'; this.style.color='#0284c7';" 
                                onmouseout="this.style.borderColor='#cbd5e1'; this.style.color='#334155';">
                            <span><i class="fas fa-key me-2 text-warning"></i> Ubah Kata Sandi</span>
                            <i class="fas fa-chevron-right small text-muted"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- FORM EDIT PROFIL (Sisi Kanan) -->
        <div class="col-lg-8">
            <div class="card crm-card-solid border-top-navy h-100 d-flex flex-column">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;">
                        <i class="fas fa-file-signature text-secondary me-2"></i> Perbarui Data Identitas
                    </h5>
                </div>
                
                <form method="POST" action="{{ route('profile.update') }}" class="d-flex flex-column h-100">
                    @csrf
                    @method('PUT')

                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Input Nama -->
                            <div class="col-md-12 mb-4">
                                <label class="form-label-solid">Nama Lengkap Staf <span class="text-danger">*</span></label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text input-group-text-solid"><i class="fas fa-user"></i></span>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                           class="form-control form-control-solid @error('name') is-invalid @enderror"
                                           placeholder="Masukkan nama lengkap" required>
                                </div>
                                @error('name')
                                    <div class="text-danger mt-1 small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Input Email -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label-solid">Alamat Email Terdaftar <span class="text-danger">*</span></label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text input-group-text-solid"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                           class="form-control form-control-solid @error('email') is-invalid @enderror"
                                           placeholder="contoh@jawaratech.com" required>
                                </div>
                                @error('email')
                                    <div class="text-danger mt-1 small fw-bold">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-2" style="font-size: 0.8rem; color: #64748b;">
                                    <i class="fas fa-info-circle text-primary me-1"></i> Email digunakan untuk kredensial login utama ke dalam CRM.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BLOK TOMBOL TERPISAH (Sangat Jelas & Tegas) -->
                    <div class="card-footer mt-auto px-4 py-3 d-flex justify-content-end gap-3" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <button type="reset" class="btn btn-outline-secondary px-4 py-2 fw-bold" style="border-radius: 4px; border-width: 2px;">
                            Batalkan
                        </button>
                        <button type="submit" class="btn btn-action-primary text-white fw-bold" style="border-radius: 4px;">
                            <i class="fas fa-save me-2"></i> Simpan Pembaruan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- ==========================================
     MODAL MENGAMBANG: UBAH PASSWORD
     ========================================== -->
<div class="modal fade crm-wrapper" id="modalUbahPassword" tabindex="-1" aria-labelledby="modalUbahPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.25);">
            
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: none; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <h5 class="modal-title fw-bold mb-0" id="modalUbahPasswordLabel" style="font-size: 1.1rem;">
                    <i class="fas fa-lock me-2 text-warning"></i> Pembaruan Kata Sandi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('password.update.self') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body p-4 bg-white">
                    <div class="alert border-0 d-flex align-items-start shadow-sm mb-4" style="background-color: #eff6ff; border-left: 4px solid #3b82f6 !important; color: #1e3a8a; border-radius: 4px;">
                        <i class="fas fa-info-circle mt-1 me-2 text-primary"></i>
                        <span style="font-size: 0.85rem; line-height: 1.4; font-weight: 500;">Kata sandi minimal 8 karakter. Padukan angka dan huruf kapital untuk keamanan maksimal.</span>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-solid">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                        <!-- Form control biru muda -->
                        <div class="input-group shadow-sm">
                            <span class="input-group-text input-group-text-solid"><i class="fas fa-unlock"></i></span>
                            <input type="password" name="current_password" class="form-control form-control-solid border-start-0" required placeholder="Masukkan sandi Anda saat ini">
                        </div>
                        @error('current_password')
                            <div class="text-danger mt-1 small fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label-solid">Kata Sandi Baru <span class="text-danger">*</span></label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text input-group-text-solid"><i class="fas fa-key"></i></span>
                            <input type="password" name="password" class="form-control form-control-solid border-start-0" required placeholder="Buat sandi baru">
                        </div>
                        @error('password')
                            <div class="text-danger mt-1 small fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="form-label-solid">Konfirmasi Sandi Baru <span class="text-danger">*</span></label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text input-group-text-solid"><i class="fas fa-check-double"></i></span>
                            <input type="password" name="password_confirmation" class="form-control form-control-solid border-start-0" required placeholder="Ulangi sandi baru">
                        </div>
                    </div>
                </div>

                <div class="modal-footer px-4 py-3 bg-light d-flex justify-content-end gap-2" style="border-top: 1px solid #e2e8f0; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-bold" data-dismiss="modal" data-bs-dismiss="modal" style="font-size: 0.9rem; border-radius: 4px; border-width: 2px;">Batal</button>
                    <button type="submit" class="btn btn-action-primary fw-bold text-white shadow-sm" style="border-radius: 4px;">
                        <i class="fas fa-check-circle me-1"></i> Simpan Sandi Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection