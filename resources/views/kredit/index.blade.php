<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS Finance Kalkulator Kredit</title>
    <script src="https://cdn.tailwindcss.com"></script>
   
</head>
<body class="bg-slate-50 min-h-screen py-8 px-4 text-slate-800">

    <div class="max-w-5xl mx-auto space-y-6">
        
        <div class="mb-8 border-b pb-4">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">IMS Finance</h1>
            <p class="text-slate-500 text-sm mt-1">Sistem Simulasi & Kalkulasi Angsuran Kendaraan</p>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
            <div class="bg-slate-800 px-6 py-3 border-b border-slate-700">
                <h2 class="text-sm font-semibold text-white uppercase tracking-wider">Formulir Pengajuan Kredit</h2>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    @if(isset($success))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 mb-5 rounded-md text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            {{ $success }}
                        </div>
                    @endif

                    <form action="{{ route('hitung.kredit') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nama Client</label>
                            <input type="text" name="client_name" value="{{ $client_name ?? '' }}" required 
                                class="w-full px-3 py-2 border border-slate-300 rounded focus:ring-1 focus:ring-slate-800 focus:border-slate-800 text-sm transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Harga OTR (Rp)</label>
                            <input type="number" name="otr" value="{{ $otr ?? '' }}" required 
                                class="w-full px-3 py-2 border border-slate-300 rounded focus:ring-1 focus:ring-slate-800 focus:border-slate-800 text-sm transition-colors">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Down Payment (%)</label>
                                <input type="number" name="dp_persen" value="{{ $dp_persen ?? '' }}" required 
                                    class="w-full px-3 py-2 border border-slate-300 rounded focus:ring-1 focus:ring-slate-800 focus:border-slate-800 text-sm transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Tenor (Bulan)</label>
                                <input type="number" name="tenor_bulan" value="{{ $tenor_bulan ?? '' }}" required 
                                    class="w-full px-3 py-2 border border-slate-300 rounded focus:ring-1 focus:ring-slate-800 focus:border-slate-800 text-sm transition-colors">
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" 
                                class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium py-2.5 px-4 rounded transition-colors text-sm">
                                Proses & Simpan Data
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-slate-50 border border-slate-200 p-6 rounded-md">
                    @if(isset($angsuran_per_bulan))
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200 pb-3 mb-4">Ringkasan Persetujuan</h3>
                        
                        <div class="space-y-3 text-sm mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">Nomor Kontrak</span>
                                <span class="font-bold text-slate-900 bg-slate-200 px-2 py-0.5 rounded">{{ $kontrak_no }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Nama Debitur</span>
                                <span class="font-medium text-slate-900">{{ $client_name }}</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-dashed border-slate-300">
                                <span class="text-slate-500">Pokok Utang</span>
                                <span class="font-medium text-slate-900">Rp {{ number_format($pokok_utang, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Bunga p.a</span>
                                <span class="font-medium text-slate-900">{{ $bunga_pa }}%</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Total Beban Bunga</span>
                                <span class="font-medium text-slate-900">Rp {{ number_format($nominal_bunga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="bg-white border border-emerald-200 rounded p-4 text-center">
                            <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Angsuran Per Bulan</p>
                            <p class="text-3xl font-extrabold text-emerald-600">Rp {{ number_format($angsuran_per_bulan, 0, ',', '.') }}</p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-slate-400 text-sm">
                            <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p>Data akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if(isset($angsuran_per_bulan))
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                <div class="bg-slate-100 px-5 py-3 border-b border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700">Data Jatuh Tempo (14 Ags 2024)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3 font-medium">Kontrak No</th>
                                <th class="px-5 py-3 font-medium">Client</th>
                                <th class="px-5 py-3 font-medium text-right">Total Angsuran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @if(isset($soal2) && count($soal2) > 0)
                                @foreach($soal2 as $row)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-5 py-3 font-medium text-slate-900">{{ $row->KONTRAK_NO }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $row->CLIENT_NAME }}</td>
                                    <td class="px-5 py-3 text-right font-medium text-slate-900">Rp {{ number_format($row->TOTAL_ANGSURAN, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="px-5 py-8 text-center text-slate-400">Belum ada data query</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                <div class="bg-slate-100 px-5 py-3 border-b border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700">Kalkulasi Denda Keterlambatan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3 font-medium">No</th>
                                <th class="px-5 py-3 font-medium">Ke</th>
                                <th class="px-5 py-3 font-medium">Terlambat</th>
                                <th class="px-5 py-3 font-medium text-right">Total Denda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @if(isset($soal3) && count($soal3) > 0)
                                @foreach($soal3 as $row)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-5 py-3 font-medium text-slate-900">{{ $row->KONTRAK_NO }}</td>
                                    <td class="px-5 py-3 text-slate-600 text-center">{{ $row->INSTALLMENT_NO }}</td>
                                    <td class="px-5 py-3 text-slate-600">
                                        <span class="bg-amber-100 text-amber-800 py-0.5 px-2 rounded text-xs">{{ $row->HARI_KETERLAMBATAN }} Hari</span>
                                    </td>
                                    <td class="px-5 py-3 text-right font-bold text-red-600">Rp {{ number_format($row->TOTAL_DENDA, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-slate-400">Belum ada data query</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        @endif
        </div>

</body>
</html>