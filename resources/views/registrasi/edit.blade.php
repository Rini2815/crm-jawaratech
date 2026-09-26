<div class="modal fade crm-wrapper" id="modalEditRegistrasi{{ $index }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 8px;">
            
            <div class="modal-header crm-modal-header border-bottom-0 py-3 px-4">
                <h5 class="modal-title" style="font-weight: 600; font-size: 1.15rem;">
                    <i class="fas fa-edit mr-2 me-2"></i> Edit Tiket & Progress Servis
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none; color: #ffffff; font-size: 1.5rem; opacity: 0.8; text-shadow: none; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('registrasi.update', $index) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4" style="background-color: #f8fafc;">
                    
                    <!-- Section 1: Informasi Tiket & Pelanggan -->
                    <div class="crm-section-title">Informasi Tiket & Pelanggan</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="edit_no_tiket_{{ $index }}" class="crm-form-label">No. Tiket / SPK</label>
                            <input type="text" class="form-control crm-form-control bg-light" id="edit_no_tiket_{{ $index }}" name="no_tiket" value="{{ $item['no_tiket'] }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_pelanggan_{{ $index }}" class="crm-form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="edit_pelanggan_{{ $index }}" name="pelanggan" value="{{ $item['pelanggan'] }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_no_wa_{{ $index }}" class="crm-form-label">No. WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="edit_no_wa_{{ $index }}" name="no_wa" value="{{ $item['no_wa'] }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_unit_{{ $index }}" class="crm-form-label">Unit Servis & Merek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="edit_unit_{{ $index }}" name="unit" value="{{ $item['unit'] }}" required>
                        </div>
                    </div>

                    <!-- Section 2: Detail Kerusakan & Waktu Servis -->
                    <div class="crm-section-title">Detail Kerusakan & Kelengkapan</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tgl_masuk_{{ $index }}" class="crm-form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" class="form-control crm-form-control" id="edit_tgl_masuk_{{ $index }}" name="tgl_masuk" value="{{ $item['tgl_masuk'] }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_perkiraan_{{ $index }}" class="crm-form-label">Perkiraan Selesai</label>
                            <input type="date" class="form-control crm-form-control" id="edit_perkiraan_{{ $index }}" name="perkiraan_selesai" value="{{ $item['perkiraan_selesai'] }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="edit_keluhan_{{ $index }}" class="crm-form-label">Keluhan Utama <span class="text-danger">*</span></label>
                            <textarea class="form-control crm-form-control" id="edit_keluhan_{{ $index }}" name="keluhan" rows="2" required>{{ $item['keluhan'] }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="crm-form-label">Kelengkapan Diserahterimakan</label>
                            <div class="d-flex flex-wrap gap-3 p-3 bg-white border rounded">
                                <div class="form-check mr-3 me-3">
                                    <input class="form-check-input" type="checkbox" name="kelengkapan[]" value="Unit Utama" id="edit_chk_unit_{{ $index }}" {{ in_array('Unit Utama', $item['kelengkapan']) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-normal" for="edit_chk_unit_{{ $index }}">Unit Utama</label>
                                </div>
                                <div class="form-check mr-3 me-3">
                                    <input class="form-check-input" type="checkbox" name="kelengkapan[]" value="Remote AC/TV" id="edit_chk_remote_{{ $index }}" {{ in_array('Remote AC/TV', $item['kelengkapan']) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-normal" for="edit_chk_remote_{{ $index }}">Remote AC/TV</label>
                                </div>
                                <div class="form-check mr-3 me-3">
                                    <input class="form-check-input" type="checkbox" name="kelengkapan[]" value="Kabel Power" id="edit_chk_kabel_{{ $index }}" {{ in_array('Kabel Power', $item['kelengkapan']) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-normal" for="edit_chk_kabel_{{ $index }}">Kabel Power</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kelengkapan[]" value="Adaptor" id="edit_chk_adaptor_{{ $index }}" {{ in_array('Adaptor', $item['kelengkapan']) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-normal" for="edit_chk_adaptor_{{ $index }}">Adaptor</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Penugasan Teknisi & Status Operasional -->
                    <div class="crm-section-title">Penugasan Teknisi & Status Servis</div>
                    <div class="row">
                        <!-- INPUT MANUAL NAMA TEKNISI DENGAN AUTOCOMPLETE DATALIST -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_teknisi_{{ $index }}" class="crm-form-label">Nama Teknisi Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="edit_teknisi_{{ $index }}" name="teknisi" value="{{ $item['teknisi'] }}" placeholder="Ketik nama teknisi..." list="datalist_teknisi" autocomplete="off" required>
                            <small class="text-muted" style="font-size: 11px;">*Bisa diketik bebas atau pilih dari saran</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_status_{{ $index }}" class="crm-form-label">Status Pengerjaan <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="edit_status_{{ $index }}" name="status" required>
                                <option value="Proses Antrean" {{ $item['status'] == 'Proses Antrean' ? 'selected' : '' }}>Proses Antrean</option>
                                <option value="Sedang Dicek" {{ $item['status'] == 'Sedang Dicek' ? 'selected' : '' }}>Sedang Dicek</option>
                                <option value="Proses Servis" {{ $item['status'] == 'Proses Servis' ? 'selected' : '' }}>Proses Servis</option>
                                <option value="Menunggu Sparepart" {{ $item['status'] == 'Menunggu Sparepart' ? 'selected' : '' }}>Menunggu Sparepart</option>
                                <option value="Selesai" {{ $item['status'] == 'Selesai' ? 'selected' : '' }}>Selesai (Siap Closing Servis)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-white" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn px-4" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; color: #475569; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px;">
                        Batalkan
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                        <i class="fas fa-check-circle mr-2 me-2"></i> Perbarui Data Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>