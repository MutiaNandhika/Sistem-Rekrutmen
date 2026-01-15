@extends('layouts.admin')
@section('title','Manajemen Akun')

@section('content')
<div class="container py-4">

<div class="d-flex justify-content-between mb-3">
    <h4>Manajemen Akun</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Akun
    </button>
</div>

<form method="GET" class="mb-3">
    <select name="role" onchange="this.form.submit()" class="form-select w-25">
        <option value="">Semua</option>
        <option value="pelamar" {{ request('role')=='pelamar'?'selected':'' }}>Pelamar</option>
        <option value="hrd" {{ request('role')=='hrd'?'selected':'' }}>HRD</option>
        <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
    </select>
</form>

@if(request()->query())
<div class="alert alert-info small">
    Menampilkan hasil filter
    <a href="{{ route('admin.akun.index') }}" class="ms-2">Reset</a>
</div>
@endif

<div class="mb-3">
    <a href="{{ url('/admin/manajemen-akun/pdf?role='.request('role')) }}" target="_blank" class="btn btn-danger">Export PDF</a>
    <a href="{{ url('/admin/manajemen-akun/excel?role='.request('role')) }}" class="btn btn-success">Export Excel</a>
</div>

<table class="table table-bordered" id="tableAkun">
<thead>
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>Role</th>
    <th width="150">Aksi</th>
</tr>
</thead>
<tbody>
@foreach($users as $u)
<tr id="row-{{ $u->id }}">
    <td>{{ $u->name }}</td>
    <td>{{ $u->email }}</td>
    <td>{{ $u->role }}</td>
    <td>
        <button class="btn btn-warning btn-sm"
            onclick='openEdit(@json($u))'>Edit</button>
        <button class="btn btn-danger btn-sm"
            onclick="hapus({{ $u->id }})">Hapus</button>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah">
	<div class="modal-dialog">
		<form method="POST" action="{{ route('admin.akun.store') }}" class="modal-content">
			 @csrf
			<div class="modal-header">
				<h5>Tambah Akun</h5>
			</div>
			<div class="modal-body">
				<input name="name" class="form-control mb-2" placeholder="Nama">
				<input name="email" class="form-control mb-2" placeholder="Email">
				<select name="role" class="form-select mb-2">
					<option value="admin">Admin</option>
					<option value="hrd">HRD</option>
					<option value="pelamar">Pelamar</option>
				</select>
				<input name="password" class="form-control" placeholder="Password"></div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
				<button class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</div>
</div>
 {{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit">
	<div class="modal-dialog">
		<form method="POST" id="formEdit" class="modal-content">
			 @csrf @method('PUT')
			<div class="modal-header">
				<h5>Edit Akun</h5>
			</div>
			<div class="modal-body">
				<input id="editName" name="name" class="form-control mb-2">
				<input id="editEmail" name="email" class="form-control mb-2">
				<select id="editRole" name="role" class="form-select mb-2">
					<option value="admin">Admin</option>
					<option value="hrd">HRD</option>
					<option value="pelamar">Pelamar</option>
				</select>
				<input name="password" class="form-control" placeholder="Password baru (opsional)"></div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
				<button class="btn btn-warning">Update</button>
			</div>
		</form>
	</div>
</div>

<script>
function openEdit(user){
    document.getElementById('editName').value = user.name;
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editRole').value = user.role;
    document.getElementById('formEdit').action =
        `/admin/manajemen-akun/${user.id}`;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}

function hapus(id){
    if(!confirm('Hapus akun ini?')) return;
    fetch(`/admin/manajemen-akun/${id}`,{
        method:'DELETE',
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
    }).then(()=>document.getElementById(`row-${id}`).remove());
}

$(document).ready(function () {
    $('#tableAkun').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        ordering: true,
        searching: true,
        responsive: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            },
            zeroRecords: "Data tidak ditemukan"
        },
        columnDefs: [
            { orderable: false, targets: 3 } // kolom Aksi
        ]
    });
});
</script>
@endsection
