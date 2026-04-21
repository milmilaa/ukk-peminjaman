<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ALMEDIS</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .login-bg {
            background: linear-gradient(rgba(0, 48, 135, 0.85), rgba(0, 48, 135, 0.92)),
                        url('https://source.unsplash.com/random/2000x1200/?hospital,medical,doctor') center/cover no-repeat;
        }
        .card {
            transition: all 0.3s ease;
        }
        .input-focus {
            transition: all 0.3s ease;
        }
        .input-focus:focus {
            border-color: #00A8A8;
            box-shadow: 0 0 0 3px rgba(0, 168, 168, 0.15);
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-[#003087] px-10 py-10 text-white text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-[#003087] font-bold text-4xl shadow-inner">
                        A
                    </div>
                    <span class="text-3xl font-bold tracking-tight">ALMEDIS</span>
                </div>
                <h2 class="text-2xl font-semibold">Masuk ke Sistem</h2>
                <p class="text-white/80 text-sm mt-2">Peminjaman Alat Kesehatan</p>
            </div>

            <!-- Form Content -->
            <div class="p-10">
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl mb-6 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-zinc-700 mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email"
                                   name="email"
                                   class="input-focus w-full pl-11 pr-4 py-4 border border-zinc-300 rounded-2xl focus:outline-none text-sm"
                                   placeholder="Masukkan email Anda"
                                   required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-zinc-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="input-focus w-full pl-11 pr-4 py-4 border border-zinc-300 rounded-2xl focus:outline-none text-sm"
                                   placeholder="Masukkan password"
                                   required>
                            <button type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-[#003087] hover:bg-[#002266] text-white py-4 rounded-2xl font-semibold text-lg transition duration-300">
                        Masuk
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-8 text-center">
                    <a href="{{ url('/') }}"
                       class="text-zinc-500 hover:text-zinc-700 text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <p class="text-center text-white/70 text-xs mt-8">
            © 2026 ALMEDIS • Sistem Peminjaman Alat Kesehatan
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
