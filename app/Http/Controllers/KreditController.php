<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KreditController extends Controller
{
    public function index()
    {
      
        return view('kredit.index');
    }

    public function hitung(Request $request)
    {
        $client_name = $request->input('client_name', 'SUGUS'); 
        $otr = $request->input('otr');
        $dp_persen = $request->input('dp_persen');
        $tenor_bulan = $request->input('tenor_bulan');

        // Kalkulasi kredit
        $dp_nominal = $otr * ($dp_persen / 100);
        $pokok_utang = $otr - $dp_nominal;

        $bunga_pa = 0;
        if ($tenor_bulan <= 12) {
            $bunga_pa = 12;
        } elseif ($tenor_bulan > 12 && $tenor_bulan <= 24) {
            $bunga_pa = 14;
        } elseif ($tenor_bulan > 24) {
            $bunga_pa = 16.5;
        }

        $tenor_tahun = $tenor_bulan / 12;
        $total_bunga_persen = $bunga_pa * $tenor_tahun; 
        
        $nominal_bunga = $pokok_utang * ($total_bunga_persen / 100);
        $total_utang = $pokok_utang + $nominal_bunga;
        
        $angsuran_per_bulan = round($total_utang / $tenor_bulan, -3); 

        $lastKontrak = DB::table('kontraks')->orderBy('KONTRAK_NO', 'desc')->first();
        if ($lastKontrak) {
            $lastNumber = (int) substr($lastKontrak->KONTRAK_NO, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $kontrak_no = 'AGR' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        DB::table('kontraks')->insert([
            'KONTRAK_NO' => $kontrak_no,
            'CLIENT_NAME' => strtoupper($client_name),
            'OTR' => $otr
        ]);

        $jadwal = [];
        $tanggal_mulai = Carbon::create(2024, 1, 25); 

        for ($i = 1; $i <= $tenor_bulan; $i++) {
            $jadwal[] = [
                'KONTRAK_NO' => $kontrak_no,
                'ANGSURAN_KE' => $i,
                'ANGSURAN_PER_BULAN' => $angsuran_per_bulan,
                'TANGGAL_JATUH_TEMPO' => $tanggal_mulai->copy()->addMonths($i - 1)->format('Y-m-d')
            ];
        }
        DB::table('jadwal_angsurans')->insert($jadwal);

        $soal2 = $this->getJawabanSoal2();
        $soal3 = $this->getJawabanSoal3();

        return view('kredit.index', compact(
            'client_name', 'kontrak_no', 'otr', 'dp_persen', 'tenor_bulan', 'dp_nominal', 
            'pokok_utang', 'bunga_pa', 'nominal_bunga', 'angsuran_per_bulan', 'soal2', 'soal3'
        ))->with('success', 'Berhasil! Data tersimpan dengan Nomor Kontrak: ' . $kontrak_no);
    }

    // Query soal no 2 dan 3
    private function getJawabanSoal2() {
        return DB::select("
            SELECT KONTRAK_NO, 'SUGUS' AS `CLIENT_NAME`, SUM(ANGSURAN_PER_BULAN) AS `TOTAL_ANGSURAN`, '14 AGUSTUS 2024' AS `JATUH_TEMPO`
            FROM jadwal_angsurans
            WHERE KONTRAK_NO = 'AGR00001' AND TANGGAL_JATUH_TEMPO <= '2024-08-14'
            GROUP BY KONTRAK_NO
        ");
    }

    // Query soal no 3
    private function getJawabanSoal3() {
        return DB::select("
            SELECT KONTRAK_NO, 'SUGUS' AS `CLIENT_NAME`, ANGSURAN_KE AS `INSTALLMENT_NO`, 
            DATEDIFF('2024-08-14', TANGGAL_JATUH_TEMPO) AS `HARI_KETERLAMBATAN`,
            ROUND(ANGSURAN_PER_BULAN * 0.001 * DATEDIFF('2024-08-14', TANGGAL_JATUH_TEMPO)) AS `TOTAL_DENDA`
            FROM jadwal_angsurans
            WHERE KONTRAK_NO = 'AGR00001' 
            AND TANGGAL_JATUH_TEMPO > '2024-05-25' AND TANGGAL_JATUH_TEMPO <= '2024-08-14'
        ");
    }
}