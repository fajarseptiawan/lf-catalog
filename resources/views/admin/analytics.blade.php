@extends('layouts.admin')

@section('title', 'Analytics Pengunjung - Admin LF Catalog')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Analytics Pengunjung</h1>
    <p class="text-gray-500">Pantau traffic website dan perangkat pengunjung secara real-time.</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between mb-3">
            <div class="p-2 bg-blue-50 rounded-lg">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-1">Hari Ini</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($visitorsToday) }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ number_format($uniqueVisitorsToday) }} unik</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between mb-3">
            <div class="p-2 bg-green-50 rounded-lg">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-1">Bulan Ini</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($visitorsMonth) }}</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between mb-3">
            <div class="p-2 bg-purple-50 rounded-lg">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-1">Total Kunjungan</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($visitorsTotal) }}</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between mb-3">
            <div class="p-2 bg-orange-50 rounded-lg">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-1">Unique Visitors</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($uniqueDevices) }}</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between mb-3">
            <div class="p-2 bg-rose-50 rounded-lg">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-1">Halaman Populer</p>
        <p class="text-2xl font-bold text-gray-900">{{ $topPages->count() }}</p>
    </div>
</div>

<!-- Grafik Pengunjung Bulanan + Top Halaman -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Grafik Pengunjung Per Bulan</h2>
                <p class="text-sm text-gray-500">12 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span>
                    Total
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                    Unik
                </span>
            </div>
        </div>
        <div class="relative" style="height: 320px;">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- Top Halaman Hari Ini -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-1">Halaman Populer</h2>
        <p class="text-sm text-gray-500 mb-4">Hari ini</p>
        @if($topPages->count() > 0)
        <div class="space-y-3">
            @foreach($topPages as $index => $page)
            <div class="flex items-center gap-3">
                <span class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                    {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : ($index === 1 ? 'bg-gray-100 text-gray-600' : ($index === 2 ? 'bg-orange-100 text-orange-700' : 'bg-gray-50 text-gray-500')) }}">
                    {{ $index + 1 }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate" title="{{ $page->url }}">{{ $page->url }}</p>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1">
                        <div class="bg-blue-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $topPages->max('visits') > 0 ? ($page->visits / $topPages->max('visits') * 100) : 0 }}%"></div>
                    </div>
                </div>
                <span class="text-sm font-bold text-gray-700 flex-shrink-0">{{ $page->visits }}</span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <p class="text-sm italic">Belum ada kunjungan hari ini</p>
        </div>
        @endif
    </div>
</div>

<!-- Tabel Ringkasan Harian (30 hari terakhir) -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-900">Ringkasan Pengunjung Per Hari</h2>
        <p class="text-sm text-gray-500">30 hari terakhir</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Total</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Unik</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Mobile
                        </span>
                    </th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Desktop
                        </span>
                    </th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Tablet
                        </span>
                    </th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Top Browser</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Top OS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($dailySummary as $day)
                @php
                    $isToday = $day->visit_date === now()->toDateString();
                @endphp
                <tr class="hover:bg-gray-50 transition {{ $isToday ? 'bg-blue-50/50' : '' }}">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($day->visit_date)->translatedFormat('d M Y') }}
                        @if($isToday)
                        <span class="ml-1.5 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Hari ini</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900 text-center">{{ number_format($day->total_visits) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ number_format($day->unique_visitors) }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($day->mobile_count > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold">
                            {{ $day->mobile_count }}
                        </span>
                        @else
                        <span class="text-gray-300 text-xs">0</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($day->desktop_count > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold">
                            {{ $day->desktop_count }}
                        </span>
                        @else
                        <span class="text-gray-300 text-xs">0</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($day->tablet_count > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-purple-50 text-purple-700 rounded-full text-xs font-semibold">
                            {{ $day->tablet_count }}
                        </span>
                        @else
                        <span class="text-gray-300 text-xs">0</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <span class="inline-flex items-center gap-1">
                            @if($day->top_browser === 'Chrome')
                            <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                            @elseif($day->top_browser === 'Safari')
                            <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>
                            @elseif($day->top_browser === 'Firefox')
                            <span class="w-2 h-2 rounded-full bg-orange-500 inline-block"></span>
                            @elseif($day->top_browser === 'Edge')
                            <span class="w-2 h-2 rounded-full bg-cyan-500 inline-block"></span>
                            @else
                            <span class="w-2 h-2 rounded-full bg-gray-400 inline-block"></span>
                            @endif
                            {{ $day->top_browser }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $day->top_os }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400 italic">
                        <div class="flex flex-col items-center">
                            <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Belum ada data pengunjung. Data akan muncul setelah ada kunjungan ke website.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Detail Pengunjung Hari Ini -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Detail Pengunjung Hari Ini</h2>
            <p class="text-sm text-gray-500">Log kunjungan real-time</p>
        </div>
        <div class="flex items-center gap-3">
            @if($todayVisitors->count() > 0)
            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">{{ $todayVisitors->count() }} pengunjung</span>
            @endif
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="searchVisitors" class="pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white outline-none transition w-full sm:w-56" placeholder="Cari IP, browser, OS..." oninput="filterVisitorTable()">
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left" id="visitorTable">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">IP Address</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Perangkat</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Browser</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Sistem Operasi</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Halaman</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="visitorTableBody">
                @forelse($todayVisitors as $index => $visitor)
                <tr class="hover:bg-gray-50 transition visitor-row"
                    data-search="{{ strtolower($visitor->ip_address . ' ' . $visitor->browser . ' ' . $visitor->os . ' ' . $visitor->device_type . ' ' . $visitor->url) }}">
                    <td class="px-6 py-4 text-sm text-gray-500 visitor-row-number">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-700">{{ $visitor->ip_address }}</td>
                    <td class="px-6 py-4">
                        @if($visitor->device_type === 'Mobile')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold border border-green-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Mobile
                        </span>
                        @elseif($visitor->device_type === 'Tablet')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-purple-50 text-purple-700 rounded-full text-xs font-semibold border border-purple-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Tablet
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold border border-blue-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Desktop
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <span class="inline-flex items-center gap-1">
                            @if($visitor->browser === 'Chrome')
                            <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                            @elseif($visitor->browser === 'Safari')
                            <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>
                            @elseif($visitor->browser === 'Firefox')
                            <span class="w-2 h-2 rounded-full bg-orange-500 inline-block"></span>
                            @elseif($visitor->browser === 'Edge')
                            <span class="w-2 h-2 rounded-full bg-cyan-500 inline-block"></span>
                            @elseif($visitor->browser === 'Samsung Browser')
                            <span class="w-2 h-2 rounded-full bg-indigo-500 inline-block"></span>
                            @else
                            <span class="w-2 h-2 rounded-full bg-gray-400 inline-block"></span>
                            @endif
                            {{ $visitor->browser }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $visitor->os }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <span class="inline-block max-w-[200px] truncate" title="{{ $visitor->url }}">{{ $visitor->url }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $visitor->created_at->format('H:i:s') }}</td>
                </tr>
                @empty
                <tr id="emptyVisitorRow">
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">
                        <div class="flex flex-col items-center">
                            <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Belum ada pengunjung hari ini.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination Footer -->
    @if($todayVisitors->count() > 0)
    <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-sm text-gray-500">Menampilkan <span id="visitorShowingCount">0</span> dari <span id="visitorTotalCount">{{ $todayVisitors->count() }}</span> pengunjung</p>
        <div class="flex items-center gap-1" id="visitorPaginationControls"></div>
    </div>
    @endif
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
// ===== Monthly Chart =====
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthlyData);

    const gradient = ctx.createLinearGradient(0, 0, 0, 320);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.01)');

    const gradientGreen = ctx.createLinearGradient(0, 0, 0, 320);
    gradientGreen.addColorStop(0, 'rgba(16, 185, 129, 0.12)');
    gradientGreen.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyData.map(d => d.label),
            datasets: [
                {
                    label: 'Total Kunjungan',
                    data: monthlyData.map(d => d.total),
                    borderColor: '#3B82F6',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                },
                {
                    label: 'Visitor Unik',
                    data: monthlyData.map(d => d.unique),
                    borderColor: '#10B981',
                    backgroundColor: gradientGreen,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10B981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: true,
                    boxPadding: 4,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: 11, weight: '500' },
                        color: '#9CA3AF',
                        stepSize: 1,
                        callback: function(value) { if (Number.isInteger(value)) return value; }
                    },
                    grid: {
                        color: 'rgba(243, 244, 246, 1)',
                        drawBorder: false,
                    },
                    border: { display: false },
                },
                x: {
                    ticks: {
                        font: { size: 11, weight: '500' },
                        color: '#9CA3AF',
                        maxRotation: 45,
                    },
                    grid: { display: false },
                    border: { display: false },
                }
            }
        }
    });

    // Initialize visitor table pagination
    initVisitorPagination();
});

// ===== Visitor Table: Search + Pagination =====
const VISITOR_PER_PAGE = 15;
let visitorCurrentPage = 1;
let visitorFilteredRows = [];

function filterVisitorTable() {
    const searchVal = document.getElementById('searchVisitors').value.toLowerCase();
    const rows = document.querySelectorAll('.visitor-row');
    visitorFilteredRows = [];

    rows.forEach(row => {
        const searchData = row.getAttribute('data-search');
        if (!searchVal || searchData.includes(searchVal)) {
            visitorFilteredRows.push(row);
        }
    });

    visitorCurrentPage = 1;
    renderVisitorPage();
}

function renderVisitorPage() {
    const rows = document.querySelectorAll('.visitor-row');
    const totalFiltered = visitorFilteredRows.length;
    const totalPages = Math.max(1, Math.ceil(totalFiltered / VISITOR_PER_PAGE));
    const start = (visitorCurrentPage - 1) * VISITOR_PER_PAGE;
    const end = start + VISITOR_PER_PAGE;

    rows.forEach(row => row.style.display = 'none');

    visitorFilteredRows.forEach((row, index) => {
        if (index >= start && index < end) {
            row.style.display = '';
            row.querySelector('.visitor-row-number').textContent = index + 1;
        }
    });

    const showingEl = document.getElementById('visitorShowingCount');
    const totalEl = document.getElementById('visitorTotalCount');
    if (showingEl) showingEl.textContent = totalFiltered === 0 ? '0' : `${start + 1}-${Math.min(end, totalFiltered)}`;
    if (totalEl) totalEl.textContent = totalFiltered;

    // Pagination controls
    const controls = document.getElementById('visitorPaginationControls');
    if (!controls) return;
    controls.innerHTML = '';
    if (totalPages <= 1) return;

    const prevBtn = document.createElement('button');
    prevBtn.innerHTML = '&laquo;';
    prevBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${visitorCurrentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
    prevBtn.disabled = visitorCurrentPage === 1;
    prevBtn.onclick = () => { if (visitorCurrentPage > 1) { visitorCurrentPage--; renderVisitorPage(); } };
    controls.appendChild(prevBtn);

    for (let i = 1; i <= totalPages; i++) {
        if (totalPages > 7 && i > 3 && i < totalPages - 2 && Math.abs(i - visitorCurrentPage) > 1) {
            if (i === 4 || i === totalPages - 3) {
                const dots = document.createElement('span');
                dots.textContent = '...';
                dots.className = 'px-2 py-1.5 text-sm text-gray-400';
                controls.appendChild(dots);
            }
            continue;
        }
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.className = `px-3 py-1.5 text-sm rounded-lg transition ${i === visitorCurrentPage ? 'bg-blue-600 text-white font-bold' : 'text-gray-700 hover:bg-gray-100'}`;
        btn.onclick = () => { visitorCurrentPage = i; renderVisitorPage(); };
        controls.appendChild(btn);
    }

    const nextBtn = document.createElement('button');
    nextBtn.innerHTML = '&raquo;';
    nextBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${visitorCurrentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
    nextBtn.disabled = visitorCurrentPage === totalPages;
    nextBtn.onclick = () => { if (visitorCurrentPage < totalPages) { visitorCurrentPage++; renderVisitorPage(); } };
    controls.appendChild(nextBtn);
}

function initVisitorPagination() {
    const rows = document.querySelectorAll('.visitor-row');
    visitorFilteredRows = Array.from(rows);
    renderVisitorPage();
}
</script>
@endsection
