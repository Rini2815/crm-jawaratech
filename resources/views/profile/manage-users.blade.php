@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' & Custom CSS Jawaratech (Sesuai Gaya Data Unit Servis) -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body, html {
    background-color: #060910 !important;
}
.crm-wrapper {
    font-family: 'Inter', sans-serif;
    color: #0f172a;
}
/* Card Terang & Bersih */
.crm-card-light {
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border-radius: 12px;
    background: #ffffff !important;
}
.crm-table-header {
    background-color: #1e293b; /* Navy/Slate khas Jawaratech */
    color: #ffffff;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.crm-badge {
    font-weight: 600;
    letter-spacing: 0.3px;
    border-radius: 4px;
    padding: 0.35em 0.65em;
    font-size: 0.75rem;
}

.super-thick-table th, 
.super-thick-table td {
    border-width: 2px !important;
    border-color: #cbd5e1 !important;
}

.stat-card-light {
    background: #ffffff !important;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.stat-card-light:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- HEADER HALAMAN -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 text-white" style="font-weight: 700;">
                    <i class="fas fa-user-secret text-primary me-2"></i> Otoritas Akses Profil
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 500;">
                    Superadmin dapat memantau seluruh akun tim, termasuk masuk ke akun Digital Marketing tanpa kata sandi.
                </p>
            </div>
        </div>
    </div>

    <!-- BANNER PEMBERITAHUAN: FITUR MASIH UI ONLY -->
    <div class="alert rounded-4 d-flex align-items-start gap-3 mb-4 shadow-sm" style="background: rgba(234, 179, 8, 0.12); border: 1px solid rgba(234, 179, 8, 0.35);">
        <i class="fas fa-tools text-warning fa-lg mt-1"></i>
        <div>
            <strong class="text-dark">Tampilan Pratinjau </strong>
            <p class="mb-0 small text-muted">
                Tombol <em>"Login Sebagai"</em> sudah bisa diklik untuk simulasi tampilan, namun belum benar-benar
                memindahkan sesi login. Fitur ini masih menunggu pengembangan backend (kolom role &amp; sistem impersonasi akun).
            </p>
        </div>
    </div>

    <!-- 3 CARD STATISTIK RINGKASAN DI ATAS (Gaya Terang Clean) -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #2563eb !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Akun</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">{{ $teamAccounts->count() }} <span class="fs-6 fw-normal text-muted">Akun</span></div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(37, 99, 235, 0.1); color: #2563eb;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #dc2626 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Superadmin</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">{{ $teamAccounts->where('role', 'Superadmin')->count() }} <span class="fs-6 fw-normal text-muted">Staf</span></div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(220, 38, 38, 0.1); color: #dc2626;">
                        <i class="fas fa-user-shield fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #0891b2 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Digital Marketing</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">{{ $teamAccounts->where('role', 'Digital Marketing')->count() }} <span class="fs-6 fw-normal text-muted">Staf</span></div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(8, 145, 178, 0.1); color: #0891b2;">
                        <i class="fas fa-bullhorn fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL AKUN TIM -->
    <div class="card crm-card-light overflow-hidden mb-4 bg-white">
        <div class="card-body p-4 bg-white">
            
            <!-- Baris Atas Tabel: Judul & Subtitle Clean + Search Box -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1.2rem; letter-spacing: -0.3px;">Daftar Akun Tim</h5>
                    <p class="text-secondary mb-0" style="font-size: 0.875rem; font-weight: 400;">Kelola akses & masuk sebagai akun Digital Marketing</p>
                </div>

                <!-- Kolom Pencarian -->
                <div class="position-relative" style="min-width: 280px;">
                    <input type="text" id="searchAkun" class="form-control form-control-sm ps-5 pe-3 py-2 bg-white text-dark" placeholder="Cari nama, email, role..." style="border-radius: 20px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                    <i class="fas fa-search position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table" id="tabelAkun">
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white" style="width: 5%;">NO</th>
                            <th class="py-3 text-white text-start" style="width: 30%;">NAMA PENGGUNA</th>
                            <th class="py-3 text-white text-start" style="width: 30%;">ALAMAT EMAIL</th>
                            <th class="py-3 text-white text-center" style="width: 20%;">ROLE AKSES</th>
                            <th class="py-3 text-white text-center" style="width: 15%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0 fw-medium" style="font-weight: 500;">
                        @foreach ($teamAccounts as $index => $account)
                        <tr class="baris-akun">
                            <td class="px-3 py-3 text-secondary text-center">{{ $index + 1 }}</td>
                            <td class="py-3 px-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width: 34px; height: 34px; background: linear-gradient(135deg, #38bdf8, #2563eb); color: #fff; font-size: 0.8rem; font-weight: 700;">
                                        {{ strtoupper(substr($account->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-dark fw-bold" style="font-weight: 600;">
                                            {{ $account->name }}
                                            @if ($account->is_you)
                                                <span class="badge bg-light text-dark border ms-1" style="font-size: 0.65rem;">Anda</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-3 text-secondary" style="font-size: 0.9rem;">{{ $account->email }}</td>
                            <td class="py-3 text-center">
                                <span class="badge crm-badge {{ $account->role_color }} text-white px-2 py-1">
                                    <i class="fas fa-user-tag me-1"></i> {{ $account->role }}
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                @if ($account->is_you)
                                    <span class="text-muted small fst-italic">Akun Anda sendiri</span>
                                @else
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary rounded-circle btn-login-as shadow-sm"
                                            data-nama="{{ $account->name }}"
                                            data-role="{{ $account->role }}"
                                            title="Login Sebagai {{ $account->name }}"
                                            style="width: 34px; height: 34px; border-width: 1.5px;">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CATATAN KONSEP -->
    <div class="card crm-card-light border-0 shadow-sm rounded-4 bg-white p-4">
        <h6 class="fw-bold text-dark mb-2"><i class="fas fa-info-circle text-info me-2"></i>Konsep Hak Akses</h6>
        <ul class="small text-muted mb-0 ps-3">
            <li class="mb-1"><strong>Superadmin</strong> &mdash; akses penuh ke seluruh sistem, dapat masuk ke akun Digital Marketing kapan saja tanpa memasukkan username/password mereka.</li>
            <li><strong>Digital Marketing</strong> &mdash; dapat mengubah username &amp; password akun miliknya sendiri melalui halaman <a href="{{ route('password.edit') }}">Ubah Password</a>, namun tidak dapat mengakses akun lain.</li>
        </ul>
    </div>

</div>

<!-- Modal Konfirmasi & Hasil Login Sebagai -->
<div class="modal fade" id="modalLoginAs" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden" style="background-color: #0f172a; color: #fff;">

            <!-- TAHAP 1: KONFIRMASI -->
            <div id="loginAsStepConfirm" class="modal-body text-center p-4">
                <div class="mb-3">
                    <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.35);">
                        <i class="fas fa-user-shield fa-lg text-info"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Masuk sebagai <span id="confirmNama" class="text-info">...</span>?</h5>
                <p class="text-light opacity-75 small mb-4">
                    Anda akan beralih tampilan sebagai akun <span id="confirmRole">...</span> ini tanpa memasukkan password.
                    <br><em>(Simulasi tampilan &mdash; backend impersonasi belum aktif)</em>
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" id="btnConfirmLoginAs" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="fas fa-sign-in-alt me-1"></i> Ya, Masuk
                    </button>
                </div>
            </div>

            <!-- TAHAP 2: HASIL SUKSES -->
            <div id="loginAsStepSuccess" class="modal-body text-center p-4" style="display: none;">
                <div class="mb-3">
                    <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.35);">
                        <i class="fas fa-check text-success fa-lg"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Berhasil masuk sebagai <span id="successNama" class="text-success">...</span></h5>
                <p class="text-light opacity-75 small mb-4">
                    Simulasi tampilan berhasil. Pada versi backend nanti, sesi Anda akan benar-benar
                    berpindah menjadi akun <span id="successRole">...</span> ini.
                </p>
                <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('modalLoginAs');
    const modal = new bootstrap.Modal(modalEl);
    const stepConfirm = document.getElementById('loginAsStepConfirm');
    const stepSuccess = document.getElementById('loginAsStepSuccess');
    const btnConfirm = document.getElementById('btnConfirmLoginAs');

    let currentNama = '';
    let currentRole = '';

    document.querySelectorAll('.btn-login-as').forEach(function (btn) {
        btn.addEventListener('click', function () {
            currentNama = btn.getAttribute('data-nama');
            currentRole = btn.getAttribute('data-role');

            document.getElementById('confirmNama').textContent = currentNama;
            document.getElementById('confirmRole').textContent = currentRole;

            stepConfirm.style.display = 'block';
            stepSuccess.style.display = 'none';
            modal.show();
        });
    });

    btnConfirm.addEventListener('click', function () {
        document.getElementById('successNama').textContent = currentNama;
        document.getElementById('successRole').textContent = currentRole;

        stepConfirm.style.display = 'none';
        stepSuccess.style.display = 'block';
    });

    modalEl.addEventListener('hidden.bs.modal', function () {
        stepConfirm.style.display = 'block';
        stepSuccess.style.display = 'none';
    });

    // Fitur pencarian tabel
    const searchInput = document.getElementById('searchAkun');
    searchInput.addEventListener('input', function () {
        const keyword = searchInput.value.toLowerCase();
        document.querySelectorAll('#tabelAkun .baris-akun').forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });
});
</script>
@endsection