@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4" style="color: #f8fafc;">
    <h1 class="mt-4 text-dark fw-bold">Data Servis</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Antrean & Closing Servis Jawaratech</li>
    </ol>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
            <div><i class="fas fa-table text-primary me-2"></i> Data Servis Konsumen</div>
            <a href="#" class="btn btn-primary btn-sm px-3 rounded-pill">+ Tambah Servis Baru</a>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" width="100%" cellspacing="0">
                    <thead class="table-light text-uppercase fs-7 text-secondary">
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Nama Konsumen</th>
                            <th class="py-3">No WA</th>
                            <th class="py-3">Jenis Unit</th>
                            <th class="py-3">Merk/Tipe</th>
                            <th class="py-3">Teknisi</th>
                            <th class="py-3">Status Perbaikan</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($serviceJobs as $index => $job)
                        <tr>
                            <td class="fw-semibold">{{ $index + 1 }}</td>
                            <td>{{ $job->nama_konsumen }}</td>
                            <td>{{ $job->no_whatsapp }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $job->jenis_unit }}</span></td>
                            <td>{{ $job->merk_tipe }}</td>
                            <td>{{ $job->nama_teknisi ?? '-' }}</td>
                            <td>
                                @if($job->jenis_perbaikan)
                                    <span class="badge bg-success text-white px-3 py-2 rounded-pill">{{ $job->jenis_perbaikan }}</span>
                                @else
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Belum Closing</span>
                                @endif
                            </td>
                            <td>
                                <a href="https://wa.me/{{ $job->no_whatsapp }}" target="_blank" class="btn btn-success btn-sm">
                                    <i class="fab fa-whatsapp"></i> Chat
                                </a>
                                <a href="#" class="btn btn-warning btn-sm text-dark fw-bold">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data servis.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection