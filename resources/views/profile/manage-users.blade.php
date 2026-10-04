@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="min-height: 100vh;">

    <!-- HEADER HALAMAN -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold text-white mb-1">
                    <i class="fas fa-user-secret text-primary me-2"></i> Otoritas Akses Profil
                </h3>
                <p class="text-light opacity-75 small mb-0">
                    Superadmin dapat memantau seluruh akun tim, termasuk masuk ke akun Digital Marketing tanpa kata sandi.
                </p>
            </div>
        </div>
    </div>

    <!-- BANNER PEMBERITAHUAN: FITUR MASIH UI ONLY -->
    <div class="alert rounded-4 d-flex align-items-start gap-3 mb-4" style="background: rgba(234, 179, 8, 0.12); border: 1px solid rgba(234, 179, 8, 0.35);">
        <i class="fas fa-tools text-warning fa-lg mt-1"></i>
        <div>
            <strong class="text-dark">Tampilan Pratinjau </strong>
            <p class="mb-0 small text-muted">
                Tombol <em>"Login Sebagai"</em> sudah bisa diklik untuk simulasi tampilan, namun belum benar-benar
                memindahkan sesi login. Fitur ini masih menunggu pengembangan backend (kolom role &amp; sistem impersonasi akun).
            </p>
        </div>
    </div>

    <!-- RINGKASAN STATISTIK -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2" style="border-left: 5px solid #2563eb !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Total Akun</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $teamAccounts->count() }} <span class="fs-6 fw-normal text-muted">Akun</span></h4>
                    </div>
                    <div class="bg-primary bg-opacity-25 text-primary p-3 rounded-circle">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2" style="border-left: 5px solid #dc2626 !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Superadmin</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $teamAccounts->where('role', 'Superadmin')->count() }} <span class="fs-6 fw-normal text-muted">Staf</span></h4>
                    </div>
                    <div class="bg-danger bg-opacity-25 text-danger p-3 rounded-circle">
                        <i class="fas fa-user-shield fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2" style="border-left: 5px solid #0891b2 !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Digital Marketing</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $teamAccounts->where('role', 'Digital Marketing')->count() }} <span class="fs-6 fw-normal text-muted">Staf</span></h4>
                    </div>
                    <div class="bg-info bg-opacity-25 text-info p-3 rounded-circle">
                        <i class="fas fa-bullhorn fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL AKUN TIM -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white mb-4">
        <div class="card-header border-bottom py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div>
                <h5 class="fw-bold text-white mb-0">
                    <i class="fas fa-address-book text-info me-2"></i> Daftar Akun Tim
                </h5>
                <span class="text-light opacity-50 small">Kelola akses & masuk sebagai akun Digital Marketing</span>
            </div>
            <div class="position-relative">
                <input type="text" id="searchAkun" class="form-control form-control-sm ps-4" placeholder="Cari nama, email, role..." style="min-width: 240px; border-radius: 20px;">
                <i class="fas fa-search position-absolute text-muted" style="top: 50%; left: 10px; transform: translateY(-50%); font-size: 0.75rem;"></i>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tabelAkun">
                    <thead class="text-white small text-uppercase" style="background-color: #1e293b;">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Nama Pengguna</th>
                            <th class="py-3">Alamat Email</th>
                            <th class="py-3">Role Akses</th>
                            <th class="text-center pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0 small fw-medium">
                        @foreach ($teamAccounts as $index => $account)
                        <tr class="baris-akun">
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td class="fw-bold text-dark">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width: 34px; height: 34px; background: linear-gradient(135deg, #38bdf8, #2563eb); color: #fff; font-size: 0.8rem; font-weight: 700;">
                                        {{ strtoupper(substr($account->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        {{ $account->name }}
                                        @if ($account->is_you)
                                            <span class="badge bg-light text-dark border ms-1" style="font-size: 0.65rem;">Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-secondary">{{ $account->email }}</td>
                            <td>
                                <span class="badge {{ $account->role_color }} text-white px-2 py-1 fw-semibold">
                                    <i class="fas fa-user-tag me-1"></i> {{ $account->role }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                @if ($account->is_you)
                                    <span class="text-muted small fst-italic">Akun Anda sendiri</span>
                                @else
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary rounded-circle btn-login-as"
                                            data-nama="{{ $account->name }}"
                                            data-role="{{ $account->role }}"
                                            title="Login Sebagai {{ $account->name }}"
                                            style="width: 34px; height: 34px;">
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
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
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