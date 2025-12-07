<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Center - Layanan Kesehatan Masa Depan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons (FontAwesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS & Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // FIX: Definisikan colors sebelum digunakan di dalam config
        const colors = tailwind.colors;

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        // GANTI WARNA TEMA DISINI
                        // Gunakan palette tailwind (emerald, teal, green, cyan, blue, etc)
                        primary: colors.emerald,
                        secondary: colors.teal,
                        dark: {
                            900: '#0f172a', // Slate 900
                            800: '#1e293b', // Slate 800
                            card: '#1e293b',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @layer utilities {
            .glass {
                @apply bg-white/70 backdrop-blur-md border border-white/20 dark:bg-dark-800/70 dark:border-white/5;
            }
            .text-gradient {
                @apply bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-secondary-500 dark:from-primary-400 dark:to-secondary-300;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .dark ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #059669;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-600 bg-slate-50 dark:bg-dark-900 dark:text-slate-300 transition-colors duration-300">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30">
                        <i class="fa-solid fa-heart-pulse text-xl"></i>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-800 dark:text-white">Health <span class="text-primary-500">Center</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#layanan" class="font-medium hover:text-primary-500 transition-colors">Layanan</a>
                    <a href="#dokter" class="font-medium hover:text-primary-500 transition-colors">Tim Dokter</a>
                    <a href="#fasilitas" class="font-medium hover:text-primary-500 transition-colors">Fasilitas</a>
                    <a href="#lokasi" class="font-medium hover:text-primary-500 transition-colors">Lokasi</a>
                </div>

                <!-- Right Actions -->
                <div class="hidden md:flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <i class="fa-solid fa-moon dark:hidden text-slate-600"></i>
                        <i class="fa-solid fa-sun hidden dark:block text-yellow-400"></i>
                    </button>

                    <!-- Queue Button -->
                    <a href="https://healthcenter.sasmitadn.com/patient" target="_blank" class="px-6 py-2.5 bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 text-white font-semibold rounded-full shadow-lg shadow-primary-500/30 transition-all transform hover:scale-105 active:scale-95 flex items-center gap-2">
                        <i class="fa-solid fa-ticket"></i> Daftar Antrian
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-4">
                    <button id="theme-toggle-mobile" class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700">
                        <i class="fa-solid fa-moon dark:hidden"></i>
                        <i class="fa-solid fa-sun hidden dark:block text-yellow-400"></i>
                    </button>
                    <button id="mobile-menu-btn" class="text-slate-800 dark:text-white focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="hidden md:hidden glass border-t border-slate-200 dark:border-slate-700 absolute w-full">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="#layanan" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-50 dark:hover:bg-slate-800 hover:text-primary-600">Layanan</a>
                <a href="#dokter" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-50 dark:hover:bg-slate-800 hover:text-primary-600">Tim Dokter</a>
                <a href="#lokasi" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-50 dark:hover:bg-slate-800 hover:text-primary-600">Lokasi</a>
                <a href="https://healthcenter.sasmitadn.com/patient/login" target="_blank" class="block mt-4 text-center px-4 py-3 bg-primary-600 text-white rounded-lg font-bold">
                    Daftar Antrian Online
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <!-- Background Blobs -->
        <div class="absolute top-0 right-0 -z-10 w-full h-full overflow-hidden opacity-30 dark:opacity-20 pointer-events-none">
            <div class="absolute top-20 right-[-100px] w-96 h-96 bg-primary-400 rounded-full blur-3xl mix-blend-multiply filter animate-float"></div>
            <div class="absolute bottom-20 left-[-100px] w-96 h-96 bg-secondary-400 rounded-full blur-3xl mix-blend-multiply filter animate-float" style="animation-delay: 2s"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-sm font-semibold mb-6 border border-primary-200 dark:border-primary-800">
                        <span class="flex h-2 w-2 rounded-full bg-primary-500 mr-2 animate-pulse"></span>
                        Buka 24 Jam • IGD Ready
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6 leading-tight">
                        Layanan Kesehatan <br>
                        <span class="text-gradient">Terintegrasi & Modern</span>
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Menggabungkan teknologi medis terkini dengan pelayanan humanis. Sistem rekam medis terintegrasi blockchain untuk keamanan data Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="https://healthcenter.sasmitadn.com/patient/login" target="_blank" class="px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg shadow-primary-500/40 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-clipboard-check"></i>
                            Ambil Antrian Sekarang
                        </a>
                        <a href="#jadwal" class="px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-primary-500 text-slate-700 dark:text-slate-200 font-bold rounded-xl transition-all hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-calendar-days"></i>
                            Jadwal Dokter
                        </a>
                    </div>

                    <!-- Stats Mini -->
                    <div class="mt-12 grid grid-cols-3 gap-8 border-t border-slate-200 dark:border-slate-800 pt-8">
                        <div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white">15+</div>
                            <div class="text-sm text-slate-500">Spesialis</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white">24/7</div>
                            <div class="text-sm text-slate-500">Layanan IGD</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white">10k+</div>
                            <div class="text-sm text-slate-500">Pasien Sembuh</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Image / Illustration -->
                <div class="relative lg:h-[600px] flex items-center justify-center">
                    <div class="relative z-10 w-full max-w-md mx-auto bg-white dark:bg-slate-800 rounded-3xl shadow-2xl p-6 border border-slate-100 dark:border-slate-700 rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="absolute -top-10 -right-10 w-24 h-24 bg-secondary-400 rounded-full opacity-20 blur-xl"></div>
                        <div class="flex items-center gap-4 mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600">
                                <i class="fa-solid fa-user-doctor text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 dark:text-white">Dr. Sarah Wijaya, Sp.PD</h3>
                                <p class="text-xs text-green-500 font-medium"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Sedang Praktek</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-xl">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-500">Antrian Saat Ini</span>
                                    <span class="font-bold text-primary-600">B-015</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-600 rounded-full h-2">
                                    <div class="bg-primary-500 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-primary-50 dark:bg-primary-900/20 p-3 rounded-lg text-center">
                                    <i class="fa-solid fa-stethoscope text-primary-500 mb-2"></i>
                                    <p class="text-xs font-semibold dark:text-slate-200">Umum</p>
                                </div>
                                <div class="bg-secondary-50 dark:bg-secondary-900/20 p-3 rounded-lg text-center">
                                    <i class="fa-solid fa-tooth text-secondary-500 mb-2"></i>
                                    <p class="text-xs font-semibold dark:text-slate-200">Gigi</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button class="w-full py-3 bg-slate-900 dark:bg-primary-600 text-white rounded-xl font-medium text-sm">Booking Konsultasi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-20 bg-white dark:bg-dark-900 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-primary-600 font-semibold tracking-wide uppercase">Poliklinik & Fasilitas</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    Layanan Medis Komprehensif
                </p>
                <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-400 mx-auto">
                    Dilengkapi dengan peralatan medis berstandar internasional.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card 1 -->
                <div class="group relative bg-slate-50 dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 hover:shadow-2xl hover:shadow-primary-500/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-primary-100 dark:bg-primary-900/30 text-primary-600 rounded-xl flex items-center justify-center mb-6 text-2xl group-hover:bg-primary-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Poli Umum</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Pemeriksaan kesehatan dasar, konsultasi dokter umum, dan surat keterangan sehat.</p>
                </div>

                <!-- Card 2 -->
                <div class="group relative bg-slate-50 dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 hover:shadow-2xl hover:shadow-secondary-500/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-secondary-100 dark:bg-secondary-900/30 text-secondary-600 rounded-xl flex items-center justify-center mb-6 text-2xl group-hover:bg-secondary-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-tooth"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Poli Gigi</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Perawatan gigi estetik, pencabutan, scaling, dan bedah mulut minor.</p>
                </div>

                <!-- Card 3 -->
                <div class="group relative bg-slate-50 dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-xl flex items-center justify-center mb-6 text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-baby"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Poli Anak (KIA)</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Imunisasi lengkap, tumbuh kembang anak, dan konsultasi kesehatan ibu hamil.</p>
                </div>

                <!-- Card 4 -->
                <div class="group relative bg-slate-50 dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 hover:shadow-2xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-xl flex items-center justify-center mb-6 text-2xl group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-flask"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Laboratorium</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Cek darah lengkap, gula darah, kolesterol, dan tes antigen/PCR cepat.</p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <button class="text-primary-600 dark:text-primary-400 font-semibold hover:text-primary-700 flex items-center mx-auto gap-2 group">
                    Lihat Semua Layanan <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Info Banner (BPJS) -->
    <section class="py-10 bg-primary-600 dark:bg-primary-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-shield-heart text-4xl text-primary-200"></i>
                <div>
                    <h3 class="text-2xl font-bold">Menerima Pasien BPJS Kesehatan</h3>
                    <p class="text-primary-100">Faskes Tingkat 1. Pastikan kepesertaan Anda aktif.</p>
                </div>
            </div>
            <div class="flex gap-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/Logo_BPJS_Kesehatan.png" alt="Logo BPJS" class="h-10 bg-white rounded px-2 py-1">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adis_Insurance_Logo.svg/1200px-Adis_Insurance_Logo.svg.png" alt="Asuransi Lain" class="h-10 bg-white rounded px-2 py-1 grayscale opacity-70">
            </div>
        </div>
    </section>

    <!-- Flow Section -->
    <section class="py-20 bg-slate-50 dark:bg-slate-900 border-t dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Alur Pelayanan Mudah</h2>
                <p class="text-slate-500 mt-2">Tanpa antri lama, semua terdigitalisasi.</p>
            </div>

            <div class="relative">
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-slate-200 dark:bg-slate-700 -translate-y-1/2 z-0"></div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
                    <!-- Step 1 -->
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 text-center">
                        <div class="w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4 border-4 border-slate-50 dark:border-slate-900">1</div>
                        <h4 class="font-bold text-lg mb-2 dark:text-white">Daftar Online</h4>
                        <p class="text-sm text-slate-500">Ambil nomor antrian via website atau aplikasi Mobile JKN.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 text-center">
                        <div class="w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4 border-4 border-slate-50 dark:border-slate-900">2</div>
                        <h4 class="font-bold text-lg mb-2 dark:text-white">Registrasi Ulang</h4>
                        <p class="text-sm text-slate-500">Scan QR Code di anjungan mandiri saat tiba di klinik.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 text-center">
                        <div class="w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4 border-4 border-slate-50 dark:border-slate-900">3</div>
                        <h4 class="font-bold text-lg mb-2 dark:text-white">Pemeriksaan</h4>
                        <p class="text-sm text-slate-500">Pemeriksaan oleh dokter profesional sesuai keluhan.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 text-center">
                        <div class="w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4 border-4 border-slate-50 dark:border-slate-900">4</div>
                        <h4 class="font-bold text-lg mb-2 dark:text-white">Obat & Pulang</h4>
                        <p class="text-sm text-slate-500">Ambil obat di farmasi. Resep digital otomatis terkirim.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location & Contact Section -->
    <section id="lokasi" class="py-20 bg-white dark:bg-dark-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Info -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Temukan Kami</h2>
                        <p class="text-slate-500 dark:text-slate-400">Lokasi strategis di pusat kota, mudah diakses dengan transportasi umum maupun pribadi. Parkir luas tersedia.</p>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-slate-700 rounded-lg flex items-center justify-center text-primary-600 flex-shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white">Alamat</h4>
                                <p class="text-slate-500 text-sm mt-1">Jl. Sehat Sejahtera No. 88, Jakarta Selatan, DKI Jakarta 12345</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-slate-700 rounded-lg flex items-center justify-center text-primary-600 flex-shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white">Kontak Darurat (IGD)</h4>
                                <p class="text-slate-500 text-sm mt-1">021-555-0123 (24 Jam)</p>
                                <p class="text-slate-500 text-sm">WhatsApp: 0812-3456-7890</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-slate-700 rounded-lg flex items-center justify-center text-primary-600 flex-shrink-0">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white">Jam Operasional</h4>
                                <div class="mt-2 space-y-1 text-sm text-slate-500">
                                    <div class="flex justify-between w-48 border-b border-dashed border-slate-200 pb-1">
                                        <span>IGD</span> <span class="font-semibold text-primary-600">24 Jam</span>
                                    </div>
                                    <div class="flex justify-between w-48 border-b border-dashed border-slate-200 pb-1">
                                        <span>Poli Umum</span> <span>08:00 - 21:00</span>
                                    </div>
                                    <div class="flex justify-between w-48">
                                        <span>Poli Gigi</span> <span>09:00 - 17:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Embed -->
                <div class="h-[400px] bg-slate-200 dark:bg-slate-800 rounded-2xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-700 relative group">
                    <!-- Placeholder Map Image/Iframe -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126907.08660851401!2d106.73299725!3d-6.284240749999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1ec2422b423%3A0xbc014a27c33dc680!2sJakarta%20Selatan%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1684940000000!5m2!1sid!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="grayscale hover:grayscale-0 transition-all duration-500">
                    </iframe>

                    <a href="https://maps.google.com" target="_blank" class="absolute bottom-4 right-4 bg-white dark:bg-slate-800 px-4 py-2 rounded-lg shadow-lg text-sm font-semibold hover:bg-slate-50 text-slate-800 dark:text-white">
                        Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4 text-white">
                        <i class="fa-solid fa-heart-pulse text-2xl text-primary-500"></i>
                        <span class="font-bold text-xl">Health Center</span>
                    </div>
                    <p class="text-sm text-slate-400">
                        Menghadirkan layanan kesehatan modern yang terjangkau dan berkualitas untuk seluruh lapisan masyarakat.
                    </p>
                </div>

                <div>
                    <h5 class="text-white font-bold mb-4">Akses Cepat</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Beranda</a></li>
                        <li><a href="#layanan" class="hover:text-primary-400 transition-colors">Layanan</a></li>
                        <li><a href="#dokter" class="hover:text-primary-400 transition-colors">Cari Dokter</a></li>
                        <li><a href="#booking" class="hover:text-primary-400 transition-colors">Booking Online</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-white font-bold mb-4">Layanan</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Medical Checkup</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Vaksinasi</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Tes Lab</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Ambulans</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-white font-bold mb-4">Download App</h5>
                    <p class="text-xs text-slate-400 mb-3">Nikmati kemudahan akses riwayat medis digital.</p>
                    <div class="flex gap-2">
                        <button class="flex-1 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded p-2 flex items-center justify-center gap-2 transition-colors">
                            <i class="fa-brands fa-google-play text-lg"></i>
                            <div class="text-left leading-none">
                                <span class="text-[8px] block uppercase">Get it on</span>
                                <span class="text-xs font-bold text-white">Google Play</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-500">© 2025 Health Center. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="text-slate-400 hover:text-white transition-colors"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="text-slate-400 hover:text-white transition-colors"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="text-slate-400 hover:text-white transition-colors"><i class="fa-brands fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Interactions -->
    <script>
        // Dark Mode Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleMobile = document.getElementById('theme-toggle-mobile');
        const html = document.documentElement;

        function toggleTheme() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Check local storage on load
        // if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        //     html.classList.add('dark');
        // } else {
        //     html.classList.remove('dark');
        // }
        if (localStorage.theme === 'dark' || !('theme' in localStorage)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        themeToggleBtn.addEventListener('click', toggleTheme);
        themeToggleMobile.addEventListener('click', toggleTheme);

        // Mobile Menu Logic
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-md');
            } else {
                navbar.classList.remove('shadow-md');
            }
        });
    </script>
</body>
</html>
