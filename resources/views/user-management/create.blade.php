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

    /* ===== Dropdown dengan kolom pencarian ===== */
    .cs-wrap { position: relative; }
    .cs-native {
        position: absolute !important;
        left: 0; bottom: 0;
        width: 1px !important; height: 1px !important;
        padding: 0 !important; border: 0 !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
    .cs-trigger {
        position: relative;
        display: block;
        background-color: #ffffff;
        cursor: pointer;
        user-select: none;
    }
    .cs-label {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        padding-right: 22px;
    }
    .cs-label.cs-placeholder { color: #64748b; font-weight: 400; }
    .cs-caret {
        position: absolute;
        right: 12px; top: 50%;
        transform: translateY(-50%);
        font-size: 0.7rem;
        color: #64748b;
        pointer-events: none;
    }
    .cs-panel {
        display: none;
        position: absolute;
        left: 0; right: 0; top: calc(100% + 4px);
        z-index: 1060;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        padding: 8px;
    }
    .cs-wrap.cs-open .cs-panel { display: block; }
    .cs-search {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 0.4rem 0.65rem;
        font-size: 0.9rem;
        color: #0f172a;
        outline: none;
        margin-bottom: 6px;
    }
    .cs-search:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.15rem rgba(59, 130, 246, 0.2);
    }
    .cs-list {
        max-height: 220px;
        overflow-y: auto;
        margin: 0; padding: 0;
        list-style: none;
    }
    .cs-item {
        padding: 7px 10px;
        font-size: 0.92rem;
        font-weight: 500;
        color: #0f172a;
        border-radius: 4px;
        cursor: pointer;
    }
    .cs-item:hover, .cs-item.cs-active { background: #e0f2fe; }
    .cs-item.cs-selected { color: #1d4ed8; font-weight: 700; }
    .cs-empty {
        padding: 8px 10px;
        font-size: 0.85rem;
        color: #64748b;
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
                            <!-- data-cari = dropdown dengan kolom pencarian -->
                            <select class="form-control crm-form-control" id="role" name="role" data-cari="Cari nama role..." required>
                                <option value="" disabled selected>Pilih Tingkat Akses...</option>
                                <option value="Super Administrator">Super Administrator - Akses Penuh Sistem</option>
                                <option value="Digital Marketing">Digital Marketing - Follow-up & Happy Call</option>
                                
                                <!-- ROLE TAMBAHAN DARI TABEL ms_role (dikirim oleh controller) -->
                                @foreach($customRoles as $cRole)
                                    @php
                                        $roleName = is_array($cRole) ? ($cRole['name'] ?? '') : $cRole;
                                    @endphp
                                    @if(!empty($roleName) && !in_array($roleName, ['Super Administrator', 'Digital Marketing']))
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

<script>
// Dropdown dengan kolom pencarian: dipakai oleh semua <select data-cari="..."> (form tambah & edit).
// <select> aslinya tetap dipakai untuk kirim data, jadi validasi & controller tidak berubah.
(function () {
    function buat(sel) {
        if (sel.getAttribute('data-cs-siap')) return;
        sel.setAttribute('data-cs-siap', '1');

        var wrap = document.createElement('div');
        wrap.className = 'cs-wrap';
        sel.parentNode.insertBefore(wrap, sel);
        wrap.appendChild(sel);
        sel.classList.add('cs-native');
        sel.tabIndex = -1;

        var trigger = document.createElement('div');
        trigger.className = 'form-control crm-form-control cs-trigger';
        trigger.tabIndex = 0;
        var label = document.createElement('span');
        label.className = 'cs-label';
        var caret = document.createElement('i');
        caret.className = 'fas fa-chevron-down cs-caret';
        trigger.appendChild(label);
        trigger.appendChild(caret);

        var panel = document.createElement('div');
        panel.className = 'cs-panel';
        var cari = document.createElement('input');
        cari.type = 'text';
        cari.className = 'cs-search';
        cari.autocomplete = 'off';
        cari.placeholder = sel.getAttribute('data-cari') || 'Cari...';
        var list = document.createElement('ul');
        list.className = 'cs-list';
        panel.appendChild(cari);
        panel.appendChild(list);

        wrap.appendChild(trigger);
        wrap.appendChild(panel);

        var tampil = [];   // opsi yang sedang tampil
        var aktif = -1;    // indeks yang disorot

        function teks(o) { return (o.text || '').replace(/\s+/g, ' ').trim(); }

        function segarkanLabel() {
            var o = sel.options[sel.selectedIndex];
            label.textContent = o ? teks(o) : '';
            label.classList.toggle('cs-placeholder', !sel.value);
        }

        function gambar(kata) {
            kata = (kata || '').toLowerCase();
            list.innerHTML = '';
            tampil = [];
            Array.prototype.forEach.call(sel.options, function (o) {
                if (!o.value) return; // lewati opsi placeholder
                if (kata && teks(o).toLowerCase().indexOf(kata) === -1) return;
                tampil.push(o);
            });

            if (!tampil.length) {
                var kosong = document.createElement('li');
                kosong.className = 'cs-empty';
                kosong.textContent = 'Tidak ditemukan.';
                list.appendChild(kosong);
                aktif = -1;
                return;
            }

            tampil.forEach(function (o, i) {
                var li = document.createElement('li');
                li.className = 'cs-item' + (o.value === sel.value ? ' cs-selected' : '');
                li.textContent = teks(o);
                li.addEventListener('mousedown', function (e) { e.preventDefault(); pilih(o); });
                li.addEventListener('mouseenter', function () { sorot(i); });
                list.appendChild(li);
            });
            sorot(0);
        }

        function sorot(i) {
            var items = list.querySelectorAll('.cs-item');
            if (!items.length) return;
            if (i < 0) i = items.length - 1;
            if (i >= items.length) i = 0;
            Array.prototype.forEach.call(items, function (el) { el.classList.remove('cs-active'); });
            items[i].classList.add('cs-active');
            items[i].scrollIntoView({ block: 'nearest' });
            aktif = i;
        }

        function pilih(o) {
            sel.value = o.value;
            sel.dispatchEvent(new Event('change', { bubbles: true }));
            tutup();
        }

        function buka() {
            wrap.classList.add('cs-open');
            cari.value = '';
            gambar('');
            setTimeout(function () { cari.focus(); }, 0);
        }

        function tutup() {
            wrap.classList.remove('cs-open');
        }

        trigger.addEventListener('click', function () {
            wrap.classList.contains('cs-open') ? tutup() : buka();
        });
        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') {
                e.preventDefault();
                buka();
            }
        });

        cari.addEventListener('input', function () { gambar(cari.value); });
        cari.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') { e.preventDefault(); sorot(aktif + 1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); sorot(aktif - 1); }
            else if (e.key === 'Enter') {
                e.preventDefault(); // jangan ikut mengirim form
                if (aktif > -1 && tampil[aktif]) pilih(tampil[aktif]);
            }
            else if (e.key === 'Escape') {
                e.preventDefault();
                e.stopPropagation(); // jangan ikut menutup modal
                tutup();
                trigger.focus();
            }
        });

        // Klik di luar = tutup
        document.addEventListener('mousedown', function (e) {
            if (!wrap.contains(e.target)) tutup();
        });

        // Jika nilai select berubah dari luar, tampilan ikut menyesuaikan
        sel.addEventListener('change', segarkanLabel);

        // Modal ditutup = tutup juga daftar pilihannya
        var modal = sel.closest('.modal');
        if (modal && window.jQuery) window.jQuery(modal).on('hidden.bs.modal', tutup);

        segarkanLabel();
    }

    function mulai() {
        Array.prototype.forEach.call(document.querySelectorAll('select[data-cari]'), buat);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', mulai);
    } else {
        mulai();
    }
})();
</script>