<style>
    /* Styling khusus form modal closing */
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

<div class="modal fade crm-wrapper" id="modalTambahClosing" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 8px;">
            
            <div class="modal-header crm-modal-header border-bottom-0 py-3 px-4">
                <h5 class="modal-title" style="font-weight: 600; font-size: 1.15rem;">
                    <i class="fas fa-file-invoice-dollar mr-2 me-2"></i> Form Closing Servis & Invoice Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none; color: #ffffff; font-size: 1.5rem; opacity: 0.8; text-shadow: none; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('closing.store') }}" method="POST" autocomplete="off" class="form-closing">
                @csrf
                <input type="hidden" name="_modal" value="tambah">
                <div class="modal-body px-4 py-4" style="background-color: #f8fafc;">
                    
                    <!-- Section 1: Informasi Invoice & Pilih Tiket Servis -->
                    <div class="crm-section-title">Pilih Tiket Servis & Pelanggan</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="no_invoice" class="crm-form-label">No. Invoice Tergenerasi</label>
                            <input type="text" class="form-control crm-form-control bg-light" id="no_invoice" value="{{ $noInvoiceBerikut }}" readonly>
                            <small class="text-muted" style="font-size: 11px;">*Nomor final dibuat saat disimpan, mengikuti bulan tanggal closing</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="servis_id" class="crm-form-label">Pilih Tiket Servis <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control in-tiket" id="servis_id" name="servis_id" required>
                                <option value="" disabled {{ old('servis_id') ? '' : 'selected' }}>-- Pilih Tiket Servis --</option>
                                @foreach($tiketSiap as $t)
                                    <option value="{{ $t->id_servis }}" data-teknisi="{{ $t->teknisi->nama_teknisi ?? '' }}" {{ old('servis_id') == $t->id_servis ? 'selected' : '' }}>
                                        {{ $t->no_tiket }} | {{ $t->unit->konsumen->nama ?? '-' }} ({{ $t->label_unit }})
                                    </option>
                                @endforeach
                            </select>
                            @if($tiketSiap->isEmpty())
                                <small class="text-danger" style="font-size: 11px;">Belum ada tiket siap closing. Tiket harus berstatus Proses Servis atau Selesai.</small>
                            @else
                                <small class="text-muted" style="font-size: 11px;">*Tiket berstatus Proses Servis / Selesai yang belum punya invoice</small>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tgl_closing" class="crm-form-label">Tanggal Closing <span class="text-danger">*</span></label>
                            <input type="date" class="form-control crm-form-control" id="tgl_closing" name="tgl_closing" value="{{ old('tgl_closing', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="teknisi" class="crm-form-label">Teknisi Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" class="form-control crm-form-control in-teknisi" id="teknisi" name="teknisi" value="{{ old('teknisi') }}" maxlength="45" placeholder="Nama teknisi utama..." list="datalist_teknisi" autocomplete="off" required>
                        </div>
                    </div>

                    <!-- Section 2: Detail Pengerjaan & Rincian Biaya -->
                    <div class="crm-section-title">Rincian Perbaikan & Kalkulasi Biaya</div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label for="rincian_pengerjaan" class="crm-form-label">Rincian Tindakan / Sparepart Diganti <span class="text-danger">*</span></label>
                            <textarea class="form-control crm-form-control" id="rincian_pengerjaan" name="rincian_pengerjaan" rows="2" maxlength="2000" placeholder="Catat detail perbaikan, penggantian komponen, atau jasa pergantian..." required>{{ old('rincian_pengerjaan') }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="biaya_jasa" class="crm-form-label">Biaya Jasa Servis (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control crm-form-control in-jasa" id="biaya_jasa" name="biaya_jasa" placeholder="0" min="0" value="{{ old('biaya_jasa', 0) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="biaya_sparepart" class="crm-form-label">Biaya Sparepart (Rp)</label>
                            <input type="number" class="form-control crm-form-control in-sparepart" id="biaya_sparepart" name="biaya_sparepart" placeholder="0" min="0" value="{{ old('biaya_sparepart', 0) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="diskon" class="crm-form-label">Potongan / Diskon (Rp)</label>
                            <input type="number" class="form-control crm-form-control in-diskon" id="diskon" name="diskon" placeholder="0" min="0" value="{{ old('diskon', 0) }}">
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="p-3 bg-white border rounded d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark" style="font-weight: 700;">TOTAL BAYAR (NETT):</span>
                                <span class="h4 mb-0 text-success fw-bold lbl-total" style="font-weight: 700;">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Pembayaran & Masa Garansi -->
                    <div class="crm-section-title">Status Pembayaran & Garansi</div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="metode_pembayaran" class="crm-form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            @php $metodeLama = old('metode_pembayaran', 'Tunai'); @endphp
                            <select class="form-control crm-form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="Tunai" {{ $metodeLama == 'Tunai' ? 'selected' : '' }}>Tunai / Cash</option>
                                <option value="QRIS/Transfer" {{ $metodeLama == 'QRIS/Transfer' ? 'selected' : '' }}>QRIS / Transfer Bank</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="garansi" class="crm-form-label">Masa Garansi Servis <span class="text-danger">*</span></label>
                            @php $garansiLama = (string) old('garansi', '30'); @endphp
                            <select class="form-control crm-form-control" id="garansi" name="garansi" required>
                                <option value="0" {{ $garansiLama === '0' ? 'selected' : '' }}>Tanpa Garansi</option>
                                <option value="7" {{ $garansiLama === '7' ? 'selected' : '' }}>7 Hari</option>
                                <option value="14" {{ $garansiLama === '14' ? 'selected' : '' }}>14 Hari</option>
                                <option value="30" {{ $garansiLama === '30' ? 'selected' : '' }}>30 Hari (1 Bulan)</option>
                                <option value="60" {{ $garansiLama === '60' ? 'selected' : '' }}>60 Hari (2 Bulan)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status_pembayaran" class="crm-form-label">Status Pembayaran <span class="text-danger">*</span></label>
                            @php $bayarLama = old('status_pembayaran', 'Lunas'); @endphp
                            <select class="form-control crm-form-control in-status" id="status_pembayaran" name="status_pembayaran" required>
                                <option value="Lunas" {{ $bayarLama == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="DP" {{ $bayarLama == 'DP' ? 'selected' : '' }}>DP (Bayar Sebagian)</option>
                                <option value="Belum Lunas" {{ $bayarLama == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 grp-dp" style="display: none;">
                            <label for="jumlah_dp" class="crm-form-label">Jumlah DP (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control crm-form-control in-dp" id="jumlah_dp" name="jumlah_dp" min="1" placeholder="0" value="{{ old('jumlah_dp') }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-white" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn px-4" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; color: #475569; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px;">
                        Batalkan
                    </button>
                    <button type="submit" name="aksi" value="simpan" class="btn btn-outline-success px-4 shadow-sm" style="font-weight: 600; border-radius: 6px;">
                        <i class="fas fa-save mr-2 me-2"></i> Simpan
                    </button>
                    <button type="submit" name="aksi" value="cetak" class="btn btn-success px-4 shadow-sm" style="font-weight: 600; border-radius: 6px; background-color: #16a34a; border-color: #16a34a;">
                        <i class="fas fa-print mr-2 me-2"></i> Simpan & Cetak Struk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>