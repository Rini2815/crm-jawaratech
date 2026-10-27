<div class="modal fade crm-wrapper" id="modalEditClosing{{ $s->id_servis }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 8px;">
            
            <div class="modal-header crm-modal-header border-bottom-0 py-3 px-4">
                <h5 class="modal-title" style="font-weight: 600; font-size: 1.15rem;">
                    <i class="fas fa-edit mr-2 me-2"></i> Edit Closing Servis & Pelunasan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none; color: #ffffff; font-size: 1.5rem; opacity: 0.8; text-shadow: none; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('closing.update', $s->id_servis) }}" method="POST" autocomplete="off" class="form-closing">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit-{{ $s->id_servis }}">
                <div class="modal-body px-4 py-4" style="background-color: #f8fafc;">
                    
                    <!-- Section 1: Referensi Tiket & Pelanggan -->
                    <div class="crm-section-title">Informasi Invoice & Pelanggan</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="crm-form-label">No. Invoice / Kwitansi</label>
                            <input type="text" class="form-control crm-form-control bg-light" value="{{ $s->no_invoice }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="crm-form-label">No. Tiket / SPK</label>
                            <input type="text" class="form-control crm-form-control bg-light" value="{{ $s->no_tiket }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="crm-form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control crm-form-control bg-light" value="{{ $s->unit->konsumen->nama ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_teknisi_{{ $s->id_servis }}" class="crm-form-label">Teknisi Penanggung Jawab</label>
                            <input type="text" class="form-control crm-form-control in-teknisi bg-light" id="edit_teknisi_{{ $s->id_servis }}" name="teknisi" value="{{ $s->teknisi->nama_teknisi ?? '' }}" maxlength="45" readonly style="cursor: not-allowed;">
                            <small class="text-muted" style="font-size: 11px;">*Mengikuti data registrasi tiket, tidak dapat diubah di sini</small>
                        </div>
                    </div>

                    <!-- Section 2: Rincian Pengerjaan & Biaya -->
                    <div class="crm-section-title">Rincian Perbaikan & Kalkulasi Biaya</div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label for="edit_rincian_{{ $s->id_servis }}" class="crm-form-label">Rincian Tindakan / Sparepart Diganti <span class="text-danger">*</span></label>
                            <textarea class="form-control crm-form-control" id="edit_rincian_{{ $s->id_servis }}" name="rincian_pengerjaan" rows="2" maxlength="2000" required>{{ $s->catatan }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_biaya_jasa_{{ $s->id_servis }}" class="crm-form-label">Biaya Jasa Servis (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control crm-form-control in-jasa" id="edit_biaya_jasa_{{ $s->id_servis }}" name="biaya_jasa" min="0" value="{{ $s->biaya_jasa }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_biaya_sparepart_{{ $s->id_servis }}" class="crm-form-label">Biaya Sparepart (Rp)</label>
                            <input type="number" class="form-control crm-form-control in-sparepart" id="edit_biaya_sparepart_{{ $s->id_servis }}" name="biaya_sparepart" min="0" value="{{ $s->biaya_sparepart }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_diskon_{{ $s->id_servis }}" class="crm-form-label">Potongan / Diskon (Rp)</label>
                            <input type="number" class="form-control crm-form-control in-diskon" id="edit_diskon_{{ $s->id_servis }}" name="diskon" min="0" value="{{ $s->diskon }}">
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="p-3 bg-white border rounded d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark" style="font-weight: 700;">TOTAL NETT PEMBAYARAN:</span>
                                <span class="h4 mb-0 text-success fw-bold lbl-total" style="font-weight: 700;">Rp {{ number_format($s->total_bayar, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Status Pembayaran & Garansi -->
                    <div class="crm-section-title">Status Pembayaran & Garansi</div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_metode_{{ $s->id_servis }}" class="crm-form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="edit_metode_{{ $s->id_servis }}" name="metode_pembayaran" required>
                                <option value="Tunai" {{ $s->metode_pembayaran == 'Tunai' ? 'selected' : '' }}>Tunai / Cash</option>
                                <option value="QRIS/Transfer" {{ $s->metode_pembayaran == 'QRIS/Transfer' ? 'selected' : '' }}>QRIS / Transfer Bank</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_garansi_{{ $s->id_servis }}" class="crm-form-label">Masa Garansi Servis <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="edit_garansi_{{ $s->id_servis }}" name="garansi" required>
                                <option value="0" {{ $s->masa_garansi_hari == 0 ? 'selected' : '' }}>Tanpa Garansi</option>
                                <option value="7" {{ $s->masa_garansi_hari == 7 ? 'selected' : '' }}>7 Hari</option>
                                <option value="14" {{ $s->masa_garansi_hari == 14 ? 'selected' : '' }}>14 Hari</option>
                                <option value="30" {{ $s->masa_garansi_hari == 30 ? 'selected' : '' }}>30 Hari (1 Bulan)</option>
                                <option value="60" {{ $s->masa_garansi_hari == 60 ? 'selected' : '' }}>60 Hari (2 Bulan)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_status_pembayaran_{{ $s->id_servis }}" class="crm-form-label">Status Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control in-status" id="edit_status_pembayaran_{{ $s->id_servis }}" name="status_pembayaran" required>
                                <option value="Lunas" {{ $s->status_pembayaran == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="DP" {{ $s->status_pembayaran == 'DP' ? 'selected' : '' }}>DP (Bayar Sebagian)</option>
                                <option value="Belum Lunas" {{ $s->status_pembayaran == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 grp-dp" style="display: none;">
                            <label for="edit_jumlah_dp_{{ $s->id_servis }}" class="crm-form-label">Jumlah DP (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control crm-form-control in-dp" id="edit_jumlah_dp_{{ $s->id_servis }}" name="jumlah_dp" min="1" value="{{ $s->jumlah_dp > 0 ? $s->jumlah_dp : '' }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-white" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn px-4" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; color: #475569; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px;">
                        Batalkan
                    </button>
                    <button type="submit" class="btn btn-success px-4 shadow-sm" style="font-weight: 600; border-radius: 6px; background-color: #16a34a; border-color: #16a34a;">
                        <i class="fas fa-check-circle mr-2 me-2"></i> Perbarui Closing & Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>