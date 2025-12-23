@extends('layouts.dashboard')

@section('title', 'Lamaran Saya')

@section('content')

<h4 class="mb-4">Lamaran Saya</h4>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Lowongan</th>
                    <th>Perusahaan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Office Girl</td>
                    <td>PT MDA</td>
                    <td>
                        <span class="badge bg-warning">Diproses</span>
                    </td>
                    <td>12 Jan 2025</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
