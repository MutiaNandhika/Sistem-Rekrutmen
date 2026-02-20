@extends('layouts.hrd')

@section('title', 'Data Lamaran')

@section('content')
<div class="container py-4">

    <h4 class="mb-4">Data Lamaran Pelamar (Edit Status Manual)</h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle">

            <thead class="table-dark">
                <tr>
                    <th>Nama Pelamar</th>
                    <th>Lowongan</th>
                    <th>Status</th>
                    <th width="220">Ubah Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($applications as $a)
                <tr>
                    <td>{{ $a->user->name }}</td>
                    <td>{{ $a->lowongan->nama_lowongan }}</td>

                    <td>
                        <span class="badge bg-secondary">
                            {{ $a->status }}
                        </span>
                    </td>

                    <td>
                        <form method="POST"
                              action="{{ route('hrd.status.update', $a->id) }}">
                            @csrf
                            @method('PUT')

                            <select name="status"
                                    class="form-select"
                                    onchange="this.form.submit()">

                                @foreach([
                                    'diproses',
                                    'screening',
                                    'seleksi',
                                    'tidak_lolos_saw',
                                    'interview',
                                    'offer',
                                    'offer_ditolak',
                                    'diterima',
                                    'ditolak',
                                    'ditolak_administrasi'
                                ] as $s)

                                    <option value="{{ $s }}"
                                        @selected($a->status == $s)>
                                        {{ $s }}
                                    </option>

                                @endforeach

                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection