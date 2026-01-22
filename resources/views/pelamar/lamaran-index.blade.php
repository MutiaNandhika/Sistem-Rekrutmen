@extends('layouts.pelamar')

@section('title', 'Lamaran Saya')

@section('content')

<h4 class="mb-4">Lamaran Saya</h4>

@if($applications->isEmpty())
    <div class="alert alert-info">
        Kamu belum pernah melamar lowongan.
    </div>
@else
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Lowongan</th>
                            <th>Tanggal Lamar</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                            <tr>
                                {{-- NAMA LOWONGAN --}}
                                <td>
                                    <div class="fw-semibold">
                                        {{ $app->lowongan->nama_lowongan }}
                                    </div>
                                </td>

                                {{-- TANGGAL --}}
                                <td>
                                    {{ $app->created_at->format('d M Y') }}
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @php
                                        $colors = [
                                            'diproses' => 'secondary',
                                            'screening' => 'info',
                                            'seleksi' => 'primary',
                                            'interview' => 'warning',
                                            'offer' => 'dark',
                                            'diterima' => 'success',
                                            'ditolak' => 'danger',
                                        ];
                                    @endphp

                                    <span class="badge bg-{{ $colors[$app->status] ?? 'secondary' }}">
                                        {{ strtoupper($app->status) }}
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td class="text-end">
                                    <a href="{{ route('pelamar.lamaran.show', $app) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        Lihat Tracking
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@endsection
