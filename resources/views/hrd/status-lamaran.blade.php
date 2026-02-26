@extends('layouts.hrd')

@section('title', 'Data Lamaran')

@section('content')
<div class="container py-4">

    <h4 class="mb-4">Data Lamaran Pelamar (Edit Status Manual)</h4>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">

            <thead class="table-dark">
                <tr>
                    <th>Nama Pelamar</th>
                    <th>Lowongan</th>
                    <th>Status</th>
                    <th>Offer Response</th>
                    <th width="280">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($applications as $a)
                <tr>

                    {{-- Nama --}}
                    <td>{{ $a->user->name }}</td>

                    {{-- Lowongan --}}
                    <td>{{ $a->lowongan->nama_lowongan }}</td>

                    {{-- Status Badge --}}
                    <td>
                        <span class="badge bg-secondary">
                            {{ $a->status }}
                        </span>
                    </td>

                    {{-- Offer Response --}}
                    <td>
                        <form method="POST"
                              action="{{ route('hrd.status.update', $a->id) }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="type" value="offer_response">

                            <select name="offer_response"
                                    class="form-select"
                                    onchange="this.form.submit()"
                                    @if(!in_array($a->status, ['offer','selesai_diterima','selesai_ditolak']))
                                        disabled
                                    @endif>

                                <option value="">NULL</option>

                                <option value="diterima"
                                    @selected($a->offer_response == 'diterima')>
                                    diterima
                                </option>

                                <option value="ditolak"
                                    @selected($a->offer_response == 'ditolak')>
                                    ditolak
                                </option>

                            </select>
                        </form>
                    </td>

                    {{-- Aksi --}}
                    <td>

                        {{-- FORM UPDATE STATUS --}}
                        <form method="POST"
                              action="{{ route('hrd.status.update', $a->id) }}"
                              class="mb-2">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="type" value="status">

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
                                    'selesai_diterima',
                                    'selesai_ditolak',
                                    'ditolak_administrasi'
                                ] as $s)

                                    <option value="{{ $s }}"
                                        @selected($a->status == $s)>
                                        {{ $s }}
                                    </option>

                                @endforeach

                            </select>
                        </form>

                        {{-- FORM DELETE --}}
                        <form method="POST"
                              action="{{ route('hrd.status.destroy', $a->id) }}"
                              class="d-inline form-delete">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection


{{-- SWEETALERT DELETE CONFIRM --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-delete').forEach(function(form) {

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data lamaran tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });

    });

});
</script>
@endpush