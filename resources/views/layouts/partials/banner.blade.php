<!-- resources/views/components/banner.blade.php -->
<div class="bg-image overflow-hidden mb-2"
    style="background-image: linear-gradient(135deg, rgba(10, 25, 47, 0.8), rgba(67, 56, 202, 0.8)), url('{{ asset('img/tala.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 150px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);">
    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center">
        <h1 class="text-white fw-bold text-uppercase mb-2 animate__animated animate__fadeInUp"
            style="font-family: 'Inter', sans-serif; font-size: 2.5rem; letter-spacing: 1px; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
            E-CATALOGUE
        </h1>
        <h4 class="text-white font-size-h4 text-uppercase mb-1 animate__animated animate__fadeInUp animate__delay-1s"
            style="font-family: 'Poppins', sans-serif; font-weight: 300; font-size: 1.25rem; letter-spacing: 0.5px; opacity: 0.9;">
            @yield('text')
        </h4>
    </div>
</div>
