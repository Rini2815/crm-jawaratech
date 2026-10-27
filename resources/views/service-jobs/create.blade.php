@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    
    .crm-wrapper {
        font-family: 'Inter', sans-serif;
        color: #334155;
    }
    .crm-card {
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
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
        border-radius: 6px;
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

<div class="container-fluid py-4 crm-wrapper">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark" style="font-weight: 700; color: #0f172a !important;">Tambah Unit Servis</h1>
            <p class="text-secondary mb-0" style="font-weight: 500;">Daftarkan unit servis baru milik pelanggan ke dalam sistem</p>
        </div>
        <a href="{{ route('service-jobs.index') }}" class="btn btn-outline-secondary px-3 py-2" style="font-weight: 600; border-radius: 6px;">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <strong>Gagal Menyimpan!</strong> Periksa kembali form input Anda:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card crm-card bg-white">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 text-dark" style="font-weight: 700;">
                        <i class="fas fa-plus-circle text-primary mr-2"></i>Form Input Master Unit
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('service-jobs.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Pemilik Unit (Konsumen)</label>
                            <select name="konsumen_id" class="form-control" data-cari="Cari nama / no. WhatsApp pelanggan..." required style="border-radius: 6px;">
                                <option value="" disabled {{ old('konsumen_id') ? '' : 'selected' }}>-- Pilih Pemilik Unit --</option>
                                @foreach($konsumen as $k)
                                    <option value="{{ $k->id_konsumen }}" {{ old('konsumen_id') == $k->id_konsumen ? 'selected' : '' }}>{{ $k->nama }} - {{ $k->no_whatsapp }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                                <select name="jenis_unit" class="form-control" data-cari="Cari jenis unit..." required style="border-radius: 6px;">
                                    <option value="" disabled {{ old('jenis_unit') ? '' : 'selected' }}>Pilih Jenis...</option>
                                    <option value="AC" {{ old('jenis_unit') == 'AC' ? 'selected' : '' }}>AC</option>
                                    <option value="Mesin Cuci" {{ old('jenis_unit') == 'Mesin Cuci' ? 'selected' : '' }}>Mesin Cuci</option>
                                    <option value="Dispenser" {{ old('jenis_unit') == 'Dispenser' ? 'selected' : '' }}>Dispenser</option>
                                    <option value="Water Heater" {{ old('jenis_unit') == 'Water Heater' ? 'selected' : '' }}>Water Heater</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                                <input type="text" name="merek" class="form-control" value="{{ old('merek') }}" placeholder="Contoh: Daikin, LG, Sharp" required maxlength="20" style="border-radius: 6px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                            <input type="text" name="tipe" class="form-control" value="{{ old('tipe') }}" placeholder="Contoh: Inverter 1 PK (FTKC25)" required maxlength="45" style="border-radius: 6px;">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Pembelian</label>
                                <input type="date" name="tgl_masuk" class="form-control" value="{{ old('tgl_masuk') }}" required style="border-radius: 6px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                                <select name="status_garansi" class="form-control" required style="border-radius: 6px;">
                                    <option value="Aktif" {{ old('status_garansi') == 'Aktif' ? 'selected' : '' }}>Aktif (Ada Kartu)</option>
                                    <option value="Tidak Bergaransi" {{ old('status_garansi') == 'Tidak Bergaransi' ? 'selected' : '' }}>Tidak Bergaransi</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Interval Perawatan (Bulan)</label>
                            <input type="number" name="interval_bulan" class="form-control" value="{{ old('interval_bulan', 6) }}" min="1" max="60" required style="border-radius: 6px;">
                            <small class="text-muted">Jarak antar jadwal perawatan rutin unit ini.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2" style="gap: 10px;">
                            <a href="{{ route('service-jobs.index') }}" class="btn btn-light" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</a>
                            <button type="submit" class="btn btn-primary px-4" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                                <i class="fas fa-save mr-1"></i> Simpan Unit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Dropdown dengan kolom pencarian: dipakai oleh semua <select data-cari="...">.
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
        trigger.className = 'form-control cs-trigger';
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
@endsection