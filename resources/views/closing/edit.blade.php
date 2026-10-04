<div class="modal fade crm-wrapper" id="modalEditClosing{{ $index }}" tabindex="-1" role="dialog" aria-hidden="true">
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
            
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4" style="background-color: #f8fafc;">
                    
                    <!-- Section 1: Referensi Tiket & Pelanggan -->
                    <div class="crm-section-title">Informasi Invoice & Pelanggan</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="edit_no_invoice_{{ $index }}" class="crm-form-label">No. Invoice / Kwitansi</label>
                            <input type="text" class="form-control crm-form-control bg-light" id="edit_no_invoice_{{ $index }}" name="no_invoice" value="{{ $item['no_invoice'] }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_no_tiket_{{ $index }}" class="crm-form-label">No. Tiket / SPK</label>
                            <input type="text" class="form-control crm-form-control bg-light" id="edit_no_tiket_{{ $index }}" name="no_tiket" value="{{ $item['no_tiket'] }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_pelanggan_{{ $index }}" class="crm-form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control crm-form-control bg-light" id="edit_pelanggan_{{ $index }}" name="pelanggan" value="{{ $item['pelanggan'] }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_teknisi_{{ $index }}" class="crm-form-label">Teknisi Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control" id="edit_teknisi_{{ $index }}" name="teknisi" value="{{ $item['teknisi'] }}" list="datalist_teknisi" autocomplete="off" required>
                        </div>
                    </div>

                    <!-- Section 2: Rincian Pengerjaan & Biaya -->
                    <div class="crm-section-title">Rincian Perbaikan & Kalkulasi Biaya</div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label for="edit_rincian_{{ $index }}" class="crm-form-label">Rincian Tindakan / Sparepart Diganti <span class="text-danger">*</span></label>
                            <textarea class="form-control crm-form-control" id="edit_rincian_{{ $index }}" name="rincian_pengerjaan" rows="2" required>{{ $item['rincian_pengerjaan'] }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_biaya_jasa_{{ $index }}" class="crm-form-label">Biaya Jasa Servis (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control crm-form-control edit-hitung" id="edit_biaya_jasa_{{ $index }}" name="biaya_jasa" value="{{ $item['biaya_jasa'] }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_biaya_sparepart_{{ $index }}" class="crm-form-label">Biaya Sparepart (Rp)</label>
                            <input type="number" class="form-control crm-form-control edit-hitung" id="edit_biaya_sparepart_{{ $index }}" name="biaya_sparepart" value="{{ $item['biaya_sparepart'] }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_diskon_{{ $index }}" class="crm-form-label">Potongan / Diskon (Rp)</label>
                            <input type="number" class="form-control crm-form-control edit-hitung" id="edit_diskon_{{ $index }}" name="diskon" value="{{ $item['diskon'] }}">
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="p-3 bg-white border rounded d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark" style="font-weight: 700;">TOTAL NETT PEMBAYARAN:</span>
                                <span class="h4 mb-0 text-success fw-bold" style="font-weight: 700;">Rp {{ number_format($item['total_bayar'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Status Pembayaran & Garansi -->
                    <div class="crm-section-title">Status Pembayaran & Garansi</div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_metode_{{ $index }}" class="crm-form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="edit_metode_{{ $index }}" name="metode_pembayaran" required>
                                <option value="Tunai / Cash" {{ $item['metode_pembayaran'] == 'Tunai / Cash' ? 'selected' : '' }}>Tunai / Cash</option>
                                <option value="QRIS / Transfer" {{ $item['metode_pembayaran'] == 'QRIS / Transfer' ? 'selected' : '' }}>QRIS / Transfer Bank</option>
                                <option value="Debit / Kredit" {{ $item['metode_pembayaran'] == 'Debit / Kredit' ? 'selected' : '' }}>Kartu Debit / Kredit</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_garansi_{{ $index }}" class="crm-form-label">Masa Garansi Servis <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="edit_garansi_{{ $index }}" name="garansi" required>
                                <option value="Tanpa Garansi" {{ $item['garansi'] == 'Tanpa Garansi' ? 'selected' : '' }}>Tanpa Garansi</option>
                                <option value="7 Hari" {{ $item['garansi'] == '7 Hari' ? 'selected' : '' }}>7 Hari</option>
                                <option value="14 Hari" {{ $item['garansi'] == '14 Hari' ? 'selected' : '' }}>14 Hari</option>
                                <option value="30 Hari" {{ $item['garansi'] == '30 Hari' ? 'selected' : '' }}>30 Hari (1 Bulan)</option>
                                <option value="60 Hari" {{ $item['garansi'] == '60 Hari' ? 'selected' : '' }}>60 Hari (2 Bulan)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_status_pembayaran_{{ $index }}" class="crm-form-label">Status Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="edit_status_pembayaran_{{ $index }}" name="status_pembayaran" required>
                                <option value="Lunas" {{ $item['status_pembayaran'] == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="DP / Belum Lunas" {{ $item['status_pembayaran'] == 'DP / Belum Lunas' ? 'selected' : '' }}>DP / Belum Lunas</option>
                                <option value="Dibatalkan" {{ $item['status_pembayaran'] == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
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