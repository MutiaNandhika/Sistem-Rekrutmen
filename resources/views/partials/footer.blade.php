<footer class="footer-section mt-5">
    <div class="container py-5">

        <div class="row g-4">

            <div class="col-md-4">
                <h6 class="fw-bold mb-3">MDA Partner</h6>
                <p class="small footer-text mb-0">
                    Mitra penyedia tenaga kerja dan solusi outsourcing profesional
                    untuk perusahaan Anda.
                </p>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Kontak</h6>
                <ul class="list-unstyled small footer-text mb-0">
                    <li>📍 Jakarta, Indonesia</li>
                    <li>📞 0812-xxxx-xxxx</li>
                    <li>✉️ info@mdapartner.id</li>
                </ul>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Navigasi</h6>
                <ul class="list-unstyled small mb-0">
                    <li><a href="{{ route('public.home') }}" class="footer-link">Beranda</a></li>
                    <li><a href="{{ route('jobs.index') }}" class="footer-link">Lowongan</a></li>
                    <li><a href="{{ route('about') }}" class="footer-link">Tentang Kami</a></li>
                </ul>
            </div>

        </div>

        <hr class="footer-divider my-4">

        <p class="text-center small footer-text mb-0">
            © {{ date('Y') }} MDA Partner. All rights reserved.
        </p>
    </div>
</footer>