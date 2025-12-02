<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi WhatsApp - Mokasindo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-verification {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .verification-code {
            letter-spacing: 2px;
            font-size: 2.5rem;
            color: #2c3e50;
        }

        .btn-wa {
            background-color: #25D366;
            color: white;
            font-weight: bold;
            border: none;
        }

        .btn-wa:hover {
            background-color: #1ebc57;
            color: white;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            background: #e9ecef;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card card-verification p-4 text-center">

                    <div class="mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Mokasindo" style="height: 50px;"
                            onerror="this.style.display='none'">
                        <h4 class="mt-2 fw-bold">Verifikasi Nomor WhatsApp</h4>
                    </div>

                    <p class="text-muted">
                        Halo <strong>{{ $user->name }}</strong>! <br>
                        Untuk mengaktifkan akun, silakan kirim kode verifikasi berikut ke WhatsApp Admin kami.
                    </p>

                    <div class="alert alert-warning py-3 my-4">
                        <small class="text-uppercase text-muted fw-bold">Kode Verifikasi Anda:</small>
                        <div class="verification-code fw-bold mt-2">{{ $user->verification_code }}</div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="https://wa.me/{{ $botNumber }}?text={{ $user->verification_code }}" target="_blank"
                            class="btn btn-wa btn-lg shadow-sm">
                            <i class="bi bi-whatsapp"></i> Kirim ke WhatsApp Sekarang 🚀
                        </a>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <p class="small text-muted mb-2">Sistem akan memverifikasi otomatis dalam:</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                            <span id="status-text" class="fw-bold text-primary">Menunggu Pesan Masuk...</span>
                        </div>
                    </div>

                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">Jangan tutup halaman ini sampai verifikasi berhasil.</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var userId = "{{ $user->id }}";
            var checkInterval;

            function checkStatus() {
                $.ajax({
                    url: "/cek-status-verifikasi/" + userId,
                    type: "GET",
                    success: function(response) {
                        if (response.status == 'success') {
                            // HENTIKAN INTERVAL
                            clearInterval(checkInterval);

                            // GANTI TAMPILAN JADI SUKSES
                            $('#status-text').text('Berhasil! Mengalihkan...').removeClass(
                                'text-primary').addClass('text-success');
                            $('.card-verification').html(
                                '<div class="py-5"><h1 style="font-size: 4rem;">✅</h1><h4 class="mt-3">Akun Aktif!</h4><p>Mengalihkan ke dashboard...</p></div>'
                                );

                            // REDIRECT OTOMATIS KE DASHBOARD
                            setTimeout(function() {
                                window.location.href = "/"; // Atau route dashboard kamu
                            }, 1500);
                        }
                    }
                });
            }

            // Jalankan pengecekan setiap 3 detik
            checkInterval = setInterval(checkStatus, 3000);
        });
    </script>

</body>

</html>
