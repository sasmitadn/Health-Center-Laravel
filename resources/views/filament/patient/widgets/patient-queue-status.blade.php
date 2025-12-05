{{-- <x-filament-widgets::widget>
    <x-filament::section>
        Widget content
    </x-filament::section>
</x-filament-widgets::widget> --}}

<x-filament-widgets::widget>
    <x-filament::section class="p-0 overflow-hidden">
        @if ($registration)
            {{-- Container Utama: Grid di Desktop, Stack di Mobile --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-0 lg:divide-x dark:divide-gray-700">

                {{-- 1. NOMOR ANTRIAN (Paling Kiri/Besar) --}}
                <div
                    class="lg:col-span-3 p-6 flex flex-col items-center justify-center bg-primary-50/50 dark:bg-primary-900/10 text-center">
                    <div class="flex items-center gap-2 text-primary-600 dark:text-primary-400 mb-2">
                        <x-heroicon-o-ticket class="w-5 h-5" />
                        <span class="text-sm font-bold uppercase tracking-wider">No. Antrian</span>
                    </div>
                    <div class="text-6xl font-black text-gray-900 dark:text-white tracking-tighter">
                        {{ $registration->queue_number }}
                    </div>
                    {{-- Status Badge --}}
                    <div class="mt-3">
                        @php
                            $statusColor = match ($registration->status) {
                                'examining' => 'success',
                                'completed' => 'info',
                                'cancelled' => 'danger',
                                default => 'gray',
                            };
                        @endphp
                        <x-filament::badge :color="$statusColor" size="lg" class="font-bold">
                            {{ ucfirst($registration->status) }}
                        </x-filament::badge>
                    </div>
                </div>

                {{-- 2. INFORMASI DETAIL (Grid 2 Kolom di sisa ruang) --}}
                <div class="lg:col-span-9 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        {{-- Item: JADWAL --}}
                        <div class="flex flex-col gap-1">
                            <div
                                class="flex items-center gap-2 text-gray-500 text-xs font-medium uppercase tracking-wide mb-1">
                                <x-heroicon-m-calendar class="w-4 h-4" />
                                <span>Tanggal</span>
                            </div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                                {{ \Carbon\Carbon::parse($registration->visit_date)->translatedFormat('d M Y') }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($registration->visit_date)->translatedFormat('l') }}
                            </div>
                        </div>

                        {{-- Item: DOKTER --}}
                        <div class="flex flex-col gap-1">
                            <div
                                class="flex items-center gap-2 text-gray-500 text-xs font-medium uppercase tracking-wide mb-1">
                                <x-heroicon-m-user-circle class="w-4 h-4" />
                                <span>Dokter</span>
                            </div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white leading-tight truncate">
                                dr. {{ $registration->doctor->name }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                {{ $registration->doctor->specialization ?? 'Dokter Umum' }}
                            </div>
                        </div>

                        {{-- Item: LOKASI --}}
                        {{-- <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2 text-gray-500 text-xs font-medium uppercase tracking-wide mb-1">
                                <x-heroicon-m-map-pin class="w-4 h-4" />
                                <span>Lokasi</span>
                            </div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                                {{ $registration->location->name }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                {{ $registration->location->address ?? 'Lantai 1, Gedung Utama' }}
                            </div>
                        </div> --}}

                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-between mb-1">
                                <div
                                    class="flex items-center gap-2 text-gray-500 text-xs font-medium uppercase tracking-wide">
                                    <x-heroicon-m-map-pin class="w-4 h-4" />
                                    <span>Lokasi</span>
                                </div>
                            </div>

                            <div class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                                {{ $registration->location->name }}
                            </div>

                            <div class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                {{ $registration->location->address ?? 'Lantai 1, Gedung Utama' }}
                            </div>

                            {{-- Tombol Maps: Muncul hanya jika Lat/Long tersedia --}}
                            @if (!empty($registration->location->latitude) && !empty($registration->location->longitude))
                                <a href="https://maps.google.com/?q={{ $registration->location->latitude }},{{ $registration->location->longitude }}"
                                    target="_blank"
                                    class="flex items-center gap-1 text-xs font-bold text-primary-600 dark:text-primary-400 hover:text-primary-500 hover:underline transition">
                                    <span>Buka Maps</span>
                                    {{-- <x-heroicon-m-arrow-top-right-on-square class="w-3 h-3" /> --}}
                                </a>
                            @endif
                        </div>

                        {{-- Item: JAM PRAKTEK --}}
                        <div class="flex flex-col gap-1">
                            <div
                                class="flex items-center gap-2 text-gray-500 text-xs font-medium uppercase tracking-wide mb-1">
                                <x-heroicon-m-clock class="w-4 h-4" />
                                <span>Jam Praktek</span>
                            </div>
                            @if ($schedule)
                                <div class="text-lg font-bold text-primary-600 dark:text-primary-400 leading-tight">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </div>
                                <div class="text-xs text-red-500 italic">
                                    *Terlambat registrasi ulang
                                </div>
                            @else
                                <span class="text-sm text-gray-400 italic">-- : --</span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <div class="p-3 bg-gray-100 dark:bg-gray-800 rounded-full mb-4">
                    <x-heroicon-o-calendar class="w-8 h-8 text-gray-400" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tidak Ada Jadwal Aktif</h3>
                <p class="text-sm text-gray-500 mb-6 max-w-xs mx-auto">Anda belum terdaftar dalam antrian pemeriksaan
                    hari ini.</p>
                <x-filament::button tag="a" href="/registrations/create" size="sm">
                    Daftar Baru
                </x-filament::button>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
