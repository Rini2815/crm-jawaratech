<style>
    .crm-modal-header {
        background-color: #1e293b; 
        color: #ffffff;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .crm-form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .crm-form-control {
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #0f172a;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .crm-form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        outline: none;
    }
    .crm-section-title {
        font-weight: 700;
        color: #0f172a;
        font-size: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }
</style>

<div class="modal fade crm-wrapper" id="modalTambahPengguna" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 8px;">
            
            <div class="modal-header crm-modal-header border-bottom-0 py-3 px-4">
                <h5 class="modal-title" style="font-weight: 600; font-size: 1.15rem;">
                    <i class="fas fa-user-plus mr-2"></i> Form Registrasi Pengguna
                </h5>
                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none; color: #ffffff; font-size: 1.5rem; opacity: 0.8; text-shadow: none; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('simpan-pengguna') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body px-4 py-4" style="background-color: #f8fafc;">
                    
                    <div class="crm-section-title">Informasi Akun</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="crm-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="nama" name="name" placeholder="Masukkan nama resmi pengguna" autocomplete="off" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="crm-form-label">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control crm-form-control" id="email" name="email" placeholder="contoh: user@jawaratech.com" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="crm-section-title">Wewenang & Keamanan</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="crm-form-label">Tingkat Akses (Role) <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="role" name="role" required>
                                <option value="" disabled selected>Pilih Tingkat Akses...</option>
                                <option value="Super Admin">Super Admin - Akses Penuh Sistem</option>
                                <option value="Digital Marketing">Digital Marketing - Follow-up & Happy Call</option>
                                
                                <!-- MEMBACA ROLE DARI STORAGE JSON SECARA AMAN -->
                                @php
                                    $customRoles = [];
                                    if (\Illuminate\Support\Facades\Storage::exists('user_roles.json')) {
                                        $customRoles = json_decode(\Illuminate\Support\Facades\Storage::get('user_roles.json'), true) ?? [];
                                    }
                                @endphp

                                @foreach($customRoles as $cRole)
                                    @php
                                        $roleName = is_array($cRole) ? ($cRole['name'] ?? '') : $cRole;
                                    @endphp
                                    @if(!empty($roleName) && !in_array($roleName, ['Super Admin', 'Digital Marketing']))
                                        <option value="{{ $roleName }}">{{ $roleName }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="crm-form-label">Status Operasional <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="status" name="status" required>
                                <option value="Aktif" selected>Aktif Beroperasi</option>
                                <option value="Tidak Aktif">Ditangguhkan (Suspend)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="crm-form-label">Kata Sandi Akses <span class="text-danger">*</span></label>
                            <input type="password" class="form-control crm-form-control" id="password" name="password" placeholder="Buat kata sandi yang kuat" autocomplete="new-password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="crm-form-label">Verifikasi Kata Sandi <span class="text-danger">*</span></label>
                            <input type="password" class="form-control crm-form-control" id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang kata sandi" autocomplete="new-password" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-white" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn px-4" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; color: #475569; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px;">
                        Batalkan
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                        <i class="fas fa-check-circle mr-2"></i> Simpan Data Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>