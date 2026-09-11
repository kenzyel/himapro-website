@if (session('success'))

    <div
        class="alert alert-success alert-dismissible"
        data-aos="fade-down"
    >
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
    </div>

@endif

@if (session('error'))

    <div
        class="alert alert-danger alert-dismissible"
        data-aos="fade-down"
    >
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ session('error') }}</div>
    </div>

@endif

@if ($errors->any())

    <div
        class="alert alert-danger"
        data-aos="fade-down"
    >
        <i class="bi bi-exclamation-triangle-fill"></i>

        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    </div>

@endif