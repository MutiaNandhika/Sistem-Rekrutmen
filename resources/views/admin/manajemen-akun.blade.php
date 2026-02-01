@extends('layouts.admin')
@section('title','Manajemen Akun')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Manajemen Akun</h4>
        <p class="text-muted small mb-0">
            Kelola akun Admin, HRD, dan Pelamar.
        </p>
    </div>

    <button class="btn btn-primary d-flex align-items-center gap-2"
        data-bs-toggle="modal"
        data-bs-target="#modalTambah">
    <i class="bi bi-plus-circle"></i>
    Tambah Akun
</button>

</div>

{{-- ================= FILTER & EXPORT ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex flex-wrap gap-3 align-items-center justify-content-between">

        <form method="GET" class="d-flex gap-2 align-items-center">
            <label class="small fw-semibold mb-0">Filter Role</label>
            <select name="role"
                    onchange="this.form.submit()"
                    class="form-select form-select-sm"
                    style="width:180px">
                <option value="">Semua</option>
                <option value="pelamar" {{ request('role')=='pelamar'?'selected':'' }}>Pelamar</option>
                <option value="hrd" {{ request('role')=='hrd'?'selected':'' }}>HRD</option>
                <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
            </select>

            @if(request('role'))
                <a href="{{ route('admin.akun.index') }}"
                   class="btn btn-light btn-sm border">
                    Reset
                </a>
            @endif
        </form>

        <div class="d-flex gap-2">
            <a href="{{ url('/admin/manajemen-akun/pdf?role='.request('role')) }}"
               target="_blank"
               class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF
            </a>

            <a href="{{ url('/admin/manajemen-akun/excel?role='.request('role')) }}"
               class="btn btn-success btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-excel"></i>
                Export Excel
            </a>
        </div>

    </div>
</div>

{{-- ================= TABLE ================= --}}
<div class="card shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="tableAkun">

                <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center" width="160">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $u)
                    <tr id="row-{{ $u->id }}">
                        <td class="fw-semibold">{{ $u->name }}</td>
                        <td class="text-muted">{{ $u->email }}</td>
                        <td>
                            @php
                                $badge = match($u->role) {
                                    'admin'   => 'bg-dark',
                                    'hrd'     => 'bg-primary',
                                    'pelamar' => 'bg-secondary',
                                    default   => 'bg-light text-dark',
                                };
                            @endphp
                            <span class="badge {{ $badge }}">
                                {{ strtoupper($u->role) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1"
                                    onclick='openEdit(@json($u))'>
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </button>

                            <button class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1"
                                    onclick="hapus({{ $u->id }})">
                                <i class="bi bi-trash"></i>
                                Hapus
                            </button>

                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

{{-- ================= MODAL TAMBAH ================= --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST"
              action="{{ route('admin.akun.store') }}"
              class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Akun</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input name="name" class="form-control mb-2" placeholder="Nama" required>
                <input name="email" class="form-control mb-2" placeholder="Email" required>
                <select name="role" class="form-select mb-2">
                    <option value="admin">Admin</option>
                    <option value="hrd">HRD</option>
                    <option value="pelamar">Pelamar</option>
                </select>
                <input name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formEdit" class="modal-content">
            @csrf @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Akun</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input id="editName" name="name" class="form-control mb-2">
                <input id="editEmail" name="email" class="form-control mb-2">
                <select id="editRole" name="role" class="form-select mb-2">
                    <option value="admin">Admin</option>
                    <option value="hrd">HRD</option>
                    <option value="pelamar">Pelamar</option>
                </select>
                <input name="password"
                       class="form-control"
                       placeholder="Password baru (opsional)">
            </div>

            <div class="modal-footer">
                <button class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
function openEdit(user){
    document.getElementById('editName').value  = user.name;
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editRole').value  = user.role;
    document.getElementById('formEdit').action =
        `/admin/manajemen-akun/${user.id}`;

    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}

function hapus(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Akun yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch(`/admin/manajemen-akun/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(() => {
            document.getElementById(`row-${id}`)?.remove();
            Swal.fire('Berhasil', 'Akun berhasil dihapus', 'success');
        })
        .catch(() => {
            Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
        });
    });
}

$(document).ready(function () {
    $('#tableAkun').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        ordering: true,
        responsive: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
            zeroRecords: "Data tidak ditemukan",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        },
        columnDefs: [
            { orderable: false, targets: 3 }
        ]
    });
});
</script>

@endsection
