<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Antrian - {{ $registration->reg_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full border-t-8 border-blue-600 relative overflow-hidden">

        <!-- Watermark / Background Decoration -->
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-100 rounded-full opacity-50 z-0"></div>
        <div class="absolute -left-6 -bottom-6 w-20 h-20 bg-blue-100 rounded-full opacity-50 z-0"></div>

        <div class="relative z-10 text-center">
            <h2 class="text-sm font-bold text-gray-500 tracking-widest uppercase">Klinik Sehat Sentosa</h2>
            <p class="text-xs text-gray-400 mb-4">Jl. Teknologi No. 12, Jakarta</p>

            <div class="my-4 border-b border-dashed border-gray-300"></div>

            <p class="text-sm text-gray-600 mb-1">Nomor Antrian</p>
            <h1 class="text-6xl font-black text-gray-800">{{ str_pad($registration->queue_number, 3, '0', STR_PAD_LEFT) }}</h1>

            <div class="mt-4 bg-blue-50 p-3 rounded-md">
                <p class="text-xs text-blue-500 font-semibold uppercase">Nomor Registrasi</p>
                <p class="text-lg font-mono font-bold text-blue-700">{{ $registration->reg_number }}</p>
            </div>

            <div class="mt-6 text-left space-y-2">
                <div class="flex justify-between">
                    <span class="text-xs text-gray-500">Pasien</span>
                    <span class="text-xs font-bold text-gray-800">{{ $registration->patient->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-xs text-gray-500">Dokter</span>
                    <span class="text-xs font-bold text-gray-800">{{ $registration->doctor->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-xs text-gray-500">Tanggal</span>
                    <span class="text-xs font-bold text-gray-800">{{ \Carbon\Carbon::parse($registration->visit_date)->format('d M Y') }}</span>
                </div>
                 <div class="flex justify-between">
                    <span class="text-xs text-gray-500">Estimasi Jam</span>
                    <!-- Logic dummy estimasi jam -->
                    <span class="text-xs font-bold text-gray-800">
                        {{ \Carbon\Carbon::parse('08:00')->addMinutes(($registration->queue_number - 1) * 15)->format('H:i') }}
                    </span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100">
                <p class="text-[10px] text-gray-400 italic">Harap datang 15 menit sebelum jadwal. Simpan struk ini.</p>
            </div>
        </div>
    </div>

    <!-- Print Button (Hidden on Print) -->
    <button onclick="window.print()" class="no-print fixed bottom-8 right-8 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition transform hover:scale-105">
        Cetak Tiket
    </button>

</body>
</html>
