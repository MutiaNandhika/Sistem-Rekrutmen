@extends(
    Auth::user()->role === 'admin' ? 'layouts.admin' :
    (Auth::user()->role === 'hrd' ? 'layouts.hrd' : 'layouts.pelamar')
)

@section('title', 'Pengaturan Akun')

@section('content')

<div class="container py-4" style="max-width: 900px;">

    <h4 class="fw-bold mb-4">Pengaturan Akun</h4>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= INFORMASI AKUN ================= --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold">
            Informasi Akun
        </div>

        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <div class="text-muted small">Nama</div>
                    <div class="fw-semibold">
                        {{ Auth::user()->name }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Email</div>
                    <div class="fw-semibold">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Role</div>
                    <div class="fw-semibold text-capitalize">
                        {{ Auth::user()->role }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Akun Dibuat</div>
                    <div class="fw-semibold">
                        {{ Auth::user()->created_at->format('d M Y') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= GANTI KATA SANDI ================= --}}
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">
            Ganti Kata Sandi
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('account.password.update') }}">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Kata Sandi Baru</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Masukkan kata sandi baru"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="Ulangi kata sandi"
                               required>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-orange">
                        Ganti Kata Sandi
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
