<div class="modal fade crm-wrapper" id="modalEditRegistrasi{{ $t->id_servis }}" tabindex="-1" role="dialog" aria-hidden="true">
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
            
            <form action="{{ route('registrasi-servis.update', $t->id_servis) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4" style="background-color: #f8fafc;">

                    @if($t->no_invoice)
                        <div class="alert alert-warning py-2 small">
                            <i class="fas fa-lock mr-1 me-1"></i> Tiket ini sudah di-closing (invoice {{ $t->no_invoice }}), data tidak dapat diubah dari halaman ini.
                        </div>
                    @endif
                    
                    <!-- Section 1: Informasi Tiket & Pelanggan -->
                    <div class="crm-section-title">Informasi Tiket & Pelanggan</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="crm-form-label">No. Tiket / SPK</label>
                            <input type="text" class="form-control crm-form-control" value="{{ $t->no_tiket }}" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="crm-form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control crm-form-control" value="{{ $t->unit->konsumen->nama ?? '-' }} ({{ $t->unit->konsumen->no_whatsapp ?? '-' }})" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="crm-form-label">Unit Servis & Merek</label>
                            <input type="text" class="form-control crm-form-control" value="{{ $t->label_unit }}" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                    </div>

                    <!-- Section 2: Detail Kerusakan & Waktu Servis -->
                    <div class="crm-section-title">Detail Kerusakan</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tgl_masuk_{{ $t->id_servis }}" class="crm-form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" class="form-control crm-form-control" id="edit_tgl_masuk_{{ $t->id_servis }}" name="tgl_masuk" value="{{ $t->tanggal_masuk->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_perkiraan_{{ $t->id_servis }}" class="crm-form-label">Perkiraan Selesai</label>
                            <input type="date" class="form-control crm-form-control" id="edit_perkiraan_{{ $t->id_servis }}" name="perkiraan_selesai" value="{{ optional($t->tanggal_estimasi_selesai)->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="edit_keluhan_{{ $t->id_servis }}" class="crm-form-label">Keluhan Utama <span class="text-danger">*</span></label>
                            <textarea class="form-control crm-form-control" id="edit_keluhan_{{ $t->id_servis }}" name="keluhan" rows="2" maxlength="1000" required>{{ $t->keluhan }}</textarea>
                        </div>
                    </div>

                    <!-- Section 3: Penugasan Teknisi & Status Operasional -->
                    <div class="crm-section-title">Penugasan Teknisi & Status Servis</div>
                    <div class="row">
                        <!-- DROPDOWN TEKNISI (diambil dari menu Data Teknisi, ada kolom pencarian) -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_teknisi_{{ $t->id_servis }}" class="crm-form-label">Nama Teknisi Penanggung Jawab <span class="text-danger">*</span></label>
                            @php $teknisiSekarang = $t->teknisi->nama_teknisi ?? ''; @endphp
                            <select class="form-control crm-form-control" id="edit_teknisi_{{ $t->id_servis }}" name="teknisi" data-cari="Cari nama teknisi..." required>
                                <option value="" disabled {{ $teknisiSekarang ? '' : 'selected' }}>-- Pilih Teknisi --</option>
                                @foreach($teknisi as $namaTeknisi)
                                    <option value="{{ $namaTeknisi }}" {{ $teknisiSekarang === $namaTeknisi ? 'selected' : '' }}>{{ $namaTeknisi }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted" style="font-size: 11px;">*Teknisi belum ada? Tambahkan dulu di menu Data Teknisi</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_status_{{ $t->id_servis }}" class="crm-form-label">Status Pengerjaan <span class="text-danger">*</span></label>
                            <select class="form-control crm-form-control" id="edit_status_{{ $t->id_servis }}" name="status" data-cari="Cari status pengerjaan..." required>
                                <option value="Sedang Dicek" {{ $t->status == 'Sedang Dicek' ? 'selected' : '' }}>Sedang Dicek</option>
                                <option value="Proses Servis" {{ $t->status == 'Proses Servis' ? 'selected' : '' }}>Proses Servis</option>
                                <option value="Selesai" {{ $t->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-white" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn px-4" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; color: #475569; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px;">
                        Batalkan
                    </button>
                    @unless($t->no_invoice)
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                        <i class="fas fa-check-circle mr-2 me-2"></i> Perbarui Data Tiket
                    </button>
                    @endunless
                </div>
            </form>
        </div>
    </div>
</div>