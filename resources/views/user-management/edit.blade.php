<div class="modal fade crm-wrapper" id="modalEditPengguna{{ $index }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 8px;">
            
            <div class="modal-header crm-modal-header border-bottom-0 py-3 px-4">
                <h5 class="modal-title" style="font-weight: 600; font-size: 1.15rem;">
                    <i class="fas fa-user-edit mr-2"></i> Edit Data Pengguna
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none; color: #ffffff; font-size: 1.5rem; opacity: 0.8; text-shadow: none; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('update-pengguna', $user->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT') 
                
                <div class="modal-body px-4 py-4" style="background-color: #f8fafc;">
                    
                    <div class="crm-section-title">Informasi Akun</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nama_{{ $index }}" class="crm-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="edit_nama_{{ $index }}" name="name" value="{{ $user->name }}" autocomplete="off" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_email_{{ $index }}" class="crm-form-label">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control crm-form-control" id="edit_email_{{ $index }}" name="email" value="{{ $user->email }}" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="crm-section-title">Wewenang & Keamanan</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_role_{{ $index }}" class="crm-form-label">Tingkat Akses (Role) <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="edit_role_{{ $index }}" name="role" required>
                                <option value="Super Admin" {{ $user->role == 'Super Admin' ? 'selected' : '' }}>Super Admin - Akses Penuh Sistem</option>
                                <option value="Digital Marketing" {{ $user->role == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing - Follow-up & Happy Call</option>
                                
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
                                        <option value="{{ $roleName }}" {{ $user->role == $roleName ? 'selected' : '' }}>{{ $roleName }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_status_{{ $index }}" class="crm-form-label">Status Operasional <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="edit_status_{{ $index }}" name="status" required>
                                <option value="Aktif" selected>Aktif Beroperasi</option>
                                <option value="Tidak Aktif">Ditangguhkan (Suspend)</option>
                            </select>
                        </div>
                        
                        <div class="col-12 mt-2 mb-2">
                            <small class="text-muted font-weight-bold"><i class="fas fa-info-circle mr-1"></i> Biarkan kosong jika tidak ingin mengubah kata sandi.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_password_{{ $index }}" class="crm-form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control crm-form-control" id="edit_password_{{ $index }}" name="password" placeholder="Ketik kata sandi baru (opsional)" autocomplete="new-password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_password_confirmation_{{ $index }}" class="crm-form-label">Verifikasi Kata Sandi Baru</label>
                            <input type="password" class="form-control crm-form-control" id="edit_password_confirmation_{{ $index }}" name="password_confirmation" placeholder="Ketik ulang kata sandi baru" autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-white" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn px-4" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; color: #475569; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px;">
                        Batalkan
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                        <i class="fas fa-check-circle mr-2"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>