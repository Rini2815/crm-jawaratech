<!-- MODAL EDIT KONSUMEN -->
<div class="modal fade crm-wrapper" id="modalEditKonsumen{{ $index }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $index }}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
            <!-- HEADER MODAL -->
            <div class="modal-header py-3 d-flex align-items-center" style="background-color: #1e293b; border-bottom: 1px solid #1e293b;">
                <h5 class="modal-title text-white mb-0" id="modalEditLabel{{ $index }}" style="font-weight: 700; font-size: 1.1rem;">
                    <i class="fas fa-edit me-2"></i>Edit Data Konsumen
                </h5>
                <button type="button" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update-konsumen', $index) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 mt-2">
                    <h6 class="text-primary mb-3" style="font-weight: 600; font-size: 0.9rem;">IDENTITAS PELANGGAN</h6>
                    <div class="mb-3">
                        <label style="font-size: 0.85rem; font-weight: 600;">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ $k['nama'] }}" required style="border-radius: 6px;">
                    </div>
                    <div class="mb-3">
                        <label style="font-size: 0.85rem; font-weight: 600;">Nomor WhatsApp</label>
                        <input type="number" name="no_wa" class="form-control" value="{{ $k['wa'] }}" required style="border-radius: 6px;">
                    </div>
                    <div class="mb-3">
                        <label style="font-size: 0.85rem; font-weight: 600;">Alamat Domisili</label>
                        <textarea name="alamat" class="form-control" rows="3" required style="border-radius: 6px;">{{ $k['alamat'] }}</textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                        <i class="fas fa-save mr-1 me-1"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>