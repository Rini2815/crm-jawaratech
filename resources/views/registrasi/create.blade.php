<style>
    /* Styling khusus form modal agar terlihat profesional & tegas */
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
    /* Tambahan agar teks checkbox selalu berwarna gelap */
    .crm-wrapper .form-check-label {
        color: #1e293b !important;
        cursor: pointer;
    }
</style>

<div class="modal fade crm-wrapper" id="modalTambahRegistrasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 8px;">
            
            <div class="modal-header crm-modal-header border-bottom-0 py-3 px-4">
                <h5 class="modal-title" style="font-weight: 600; font-size: 1.15rem;">
                    <i class="fas fa-clipboard-check mr-2 me-2"></i> Form Registrasi Unit Servis Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none; color: #ffffff; font-size: 1.5rem; opacity: 0.8; text-shadow: none; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('registrasi.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body px-4 py-4" style="background-color: #f8fafc;">
                    
                    <!-- Section 1: Informasi Tiket & Pelanggan -->
                    <div class="crm-section-title">Informasi Tiket & Pelanggan</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="no_tiket" class="crm-form-label">No. Tiket / SPK</label>
                            <input type="text" class="form-control crm-form-control bg-light" id="no_tiket" name="no_tiket" value="SRV-202609-003" readonly>
                            <small class="text-muted" style="font-size: 11px;">*Nomor SPK tergenerasi otomatis</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pelanggan" class="crm-form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="pelanggan" name="pelanggan" placeholder="Masukkan nama lengkap pemilik unit" autocomplete="off" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_wa" class="crm-form-label">No. WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="no_wa" name="no_wa" placeholder="contoh: 081234567890" autocomplete="off" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="crm-form-label">Unit Servis & Merek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="unit" name="unit" placeholder="contoh: AC Sharp Sayonara 1 PK" autocomplete="off" required>
                        </div>
                    </div>

                    <!-- Section 2: Detail Kerusakan & Waktu Servis -->
                    <div class="crm-section-title">Detail Kerusakan & Kelengkapan</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="tgl_masuk" class="crm-form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" class="form-control crm-form-control" id="tgl_masuk" name="tgl_masuk" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="perkiraan_selesai" class="crm-form-label">Perkiraan Selesai</label>
                            <input type="date" class="form-control crm-form-control" id="perkiraan_selesai" name="perkiraan_selesai">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="keluhan" class="crm-form-label">Keluhan / Kendala Utama <span class="text-danger">*</span></label>
                            <textarea class="form-control crm-form-control" id="keluhan" name="keluhan" rows="2" placeholder="Catat keluhan perbaikan dari pelanggan..." required></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="crm-form-label">Kelengkapan Diserahterimakan</label>
                            <div class="d-flex flex-wrap gap-3 p-3 bg-white border rounded">
                                <div class="form-check mr-3 me-3">
                                    <input class="form-check-input" type="checkbox" name="kelengkapan[]" value="Unit Utama" id="chk_unit" checked>
                                    <label class="form-check-label font-weight-normal text-dark" for="chk_unit">Unit Utama</label>
                                </div>
                                <div class="form-check mr-3 me-3">
                                    <input class="form-check-input" type="checkbox" name="kelengkapan[]" value="Remote AC/TV" id="chk_remote">
                                    <label class="form-check-label font-weight-normal text-dark" for="chk_remote">Remote AC/TV</label>
                                </div>
                                <div class="form-check mr-3 me-3">
                                    <input class="form-check-input" type="checkbox" name="kelengkapan[]" value="Kabel Power" id="chk_kabel">
                                    <label class="form-check-label font-weight-normal text-dark" for="chk_kabel">Kabel Power</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kelengkapan[]" value="Adaptor" id="chk_adaptor">
                                    <label class="form-check-label font-weight-normal text-dark" for="chk_adaptor">Adaptor</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Penugasan Teknisi & Status Awal -->
                    <div class="crm-section-title">Penugasan Teknisi & Status Servis</div>
                    <div class="row">
                        <!-- INPUT MANUAL NAMA TEKNISI DENGAN AUTOCOMPLETE DATALIST -->
                        <div class="col-md-6 mb-3">
                            <label for="teknisi" class="crm-form-label">Nama Teknisi Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="teknisi" name="teknisi" placeholder="Masukkan / ketik nama teknisi..." list="datalist_teknisi" autocomplete="off" required>
                            <small class="text-muted" style="font-size: 11px;">*Bisa diketik bebas atau pilih dari saran</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="crm-form-label">Status Awal <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="status" name="status" required>
                                <option value="Proses Antrean">Proses Antrean</option>
                                <option value="Sedang Dicek" selected>Sedang Dicek</option>
                                <option value="Proses Servis">Proses Servis</option>
                                <option value="Menunggu Sparepart">Menunggu Sparepart</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-white" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn px-4" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; color: #475569; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px;">
                        Batalkan
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                        <i class="fas fa-check-circle mr-2 me-2"></i> Simpan Data Registrasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>