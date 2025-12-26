@extends('layouts.admin')

@section('title', 'Manajemen Akun')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Manajemen Akun</h4>

        <div class="d-flex gap-2">
            <button class="btn btn-danger"
                    onclick="openAkunPdfPreview()">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>

            <a href="/dummy/akun.xlsx"
            download
            class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>

    </div>

    <div class="row">

        {{-- FILTER --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-funnel"></i> Filter Role
                    </h6>

                    <div class="form-check mb-2">
                        <input class="form-check-input role-filter" type="radio" name="role" value="" checked>
                        <label class="form-check-label">Semua</label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input role-filter" type="radio" name="role" value="pelamar">
                        <label class="form-check-label">Pelamar</label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input role-filter" type="radio" name="role" value="hrd">
                        <label class="form-check-label">HRD</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input role-filter" type="radio" name="role" value="admin">
                        <label class="form-check-label">Admin</label>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="table-responsive p-3">
                    <table id="akunTable" class="display table table-bordered align-middle w-100">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Last Login</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- DATA DIISI JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODAL TAMBAH AKUN --}}
<div class="modal fade" id="modalTambahAkun" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h5 class="fw-bold">Tambah Akun</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select class="form-select">
                        <option>Pelamar</option>
                        <option>HRD</option>
                        <option>Admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="text" class="form-control" placeholder="Generate otomatis">
                </div>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL PREVIEW PDF ================= --}}
<div class="modal fade" id="modalAkunPdfPreview" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Preview Data Akun (PDF)
                </h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <iframe id="akunPdfFrame"
                        src=""
                        width="100%"
                        height="600px"
                        style="border:none;">
                </iframe>
            </div>

            <div class="modal-footer">
                <a id="downloadAkunPdfBtn"
                   href="#"
                   download
                   class="btn btn-danger">
                    <i class="bi bi-download"></i> Download PDF
                </a>

                <button class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
/* ================= DATA DUMMY ================= */
const akunData = [
    {id:1, nama:'Joodiva', email:'joojo@email.com', login:'14/12/2025', role:'pelamar'},
    {id:2, nama:'Naruto', email:'naru@email.com', login:'01/12/2025', role:'hrd'},
    {id:3, nama:'Arka', email:'arka@email.com', login:'10/12/2025', role:'admin'},
];

/* ================= INIT DATATABLE ================= */
const table = $('#akunTable').DataTable({
    destroy: true,
    data: akunData,
    columns: [
        { data: 'nama' },
        { data: 'email' },
        { data: 'login' },
        { data: 'role' },
        {
            data: null,
            orderable: false,
            render: function (data) {

                let detailUrl = '';

                if (data.role === 'Pelamar') {
                    detailUrl = `/pelamar/profile/${data.id}`;
                } else if (data.role === 'HRD') {
                    detailUrl = `/hrd/akun/${data.id}`;
                } else {
                    detailUrl = `/admin/akun/${data.id}`;
                }

                return `
                    <a href="${detailUrl}" class="btn btn-sm btn-info me-1">
                        <i class="bi bi-eye"></i>
                    </a>
                    <button class="btn btn-sm btn-warning me-1">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
            }

        }
    ],
    pageLength: 5,
    lengthChange: false,
    language: {
        search: "Cari:",
        paginate: {
            next: "›",
            previous: "‹"
        }
    }
});

/* ================= FILTER ROLE ================= */
$('.role-filter').on('change', function () {
    table.column(3).search(this.value).draw();
});

/* ================= EXPORT (DUMMY) ================= */
$('#exportPdf').on('click', function () {
    alert('Export PDF sesuai filter aktif');
});

$('#exportExcel').on('click', function () {
    alert('Export Excel sesuai filter aktif');
});

function openAkunPdfPreview() {

    // 🔹 DUMMY FILE PDF (NANTI GANTI HASIL BACKEND)
    const pdfUrl = "/dummy/laporan-saw.pdf";

    // isi iframe
    document.getElementById('akunPdfFrame').src = pdfUrl;

    // set tombol download
    document.getElementById('downloadAkunPdfBtn').href = pdfUrl;

    // buka modal
    const modal = new bootstrap.Modal(
        document.getElementById('modalAkunPdfPreview')
    );
    modal.show();
}
</script>
@endpush
