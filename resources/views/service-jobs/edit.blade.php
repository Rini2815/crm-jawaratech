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
</style>

<div class="container-fluid py-4 crm-wrapper">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark" style="font-weight: 700; color: #0f172a !important;">Edit Data Unit Servis</h1>
            <p class="text-secondary mb-0" style="font-weight: 500;">Perbarui informasi teknis, tanggal pembelian, atau garansi unit</p>
        </div>
        <a href="{{ route('service-jobs.index') }}" class="btn btn-outline-secondary px-3 py-2" style="font-weight: 600; border-radius: 6px;">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card crm-card bg-white">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 text-dark" style="font-weight: 700;">
                        <i class="fas fa-edit text-primary mr-2"></i>Perbarui Data Unit
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('service-jobs.update', $unit->id ?? 1) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Pemilik Unit (Konsumen)</label>
                            <input type="text" class="form-control" value="Budi Santoso - 081234567890" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                                <select name="jenis_unit" class="form-control" style="border-radius: 6px;">
                                    <option value="AC" selected>AC</option>
                                    <option value="Mesin Cuci">Mesin Cuci</option>
                                    <option value="Dispenser">Dispenser</option>
                                    <option value="Water Heater">Water Heater</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                                <input type="text" name="merek" class="form-control" value="Daikin" required style="border-radius: 6px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                            <input type="text" name="tipe" class="form-control" value="Inverter 1 PK (FTKC25)" required style="border-radius: 6px;">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Pembelian</label>
                                <input type="date" name="tgl_pembelian" class="form-control" value="2024-05-12" style="border-radius: 6px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                                <select name="status_garansi" class="form-control" style="border-radius: 6px;">
                                    <option value="Aktif (Ada Kartu)" selected>Aktif (Ada Kartu)</option>
                                    <option value="Tidak Bergaransi">Tidak Bergaransi</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2" style="gap: 10px;">
                            <a href="{{ route('service-jobs.index') }}" class="btn btn-light" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</a>
                            <button type="submit" class="btn btn-primary px-4" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                                <i class="fas fa-save mr-1"></i> Perbarui Unit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection