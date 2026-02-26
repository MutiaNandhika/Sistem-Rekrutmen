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
                    <th width="280">Aksi</th>
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
                        {{-- FORM UPDATE STATUS --}}
                        <form method="POST"
                              action="{{ route('hrd.status.update', $a->id) }}">
                            @csrf
                            @method('PUT')

                            <select name="status"
                                    class="form-select mb-2"
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