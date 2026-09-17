@extends('layouts.app')

@section('content')
<h1 class="mt-4">Data Servis</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Daftar Antrean & Closing Servis Jawaratech</li>
</ol>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="fas fa-table me-1"></i> Data Servis Konsumen</div>
        <a href="#" class="btn btn-primary btn-sm">+ Tambah Servis Baru</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Konsumen</th>
                    <th>No WA</th>
                    <th>Jenis Unit</th>
                    <th>Merk/Tipe</th>
                    <th>Teknisi</th>
                    <th>Status Perbaikan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($serviceJobs as $index => $job)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $job->nama_konsumen }}</td>
                    <td>{{ $job->no_whatsapp }}</td>
                    <td><span class="badge bg-info text-dark">{{ $job->jenis_unit }}</span></td>
                    <td>{{ $job->merk_tipe }}</td>
                    <td>{{ $job->nama_teknisi ?? '-' }}</td>
                    <td>{{ $job->jenis_perbaikan ?? 'Belum Closing' }}</td>
                    <td>
                        <a href="https://wa.me/{{ $job->no_whatsapp }}" target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp"></i> Chat WA
                        </a>
                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data servis.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection