<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {

        return view('frontend.index', ['sekolah' => null,'bantuan' => null, 'query' => '']); // Awalnya tidak ada hasil
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
            'captcha' => 'required|captcha',
        ]);

        // Ambil input dengan benar
        $query = $request->input('query');

        // Mencari sekolah
        $sekolah = Sekolah::where('npsn', '=', $query)->first();

        // Cek apakah sekolah ditemukan
        if (is_null($sekolah)) {
            // Tampilkan pesan kesalahan atau kembali ke halaman sebelumnya
            return redirect()->back()->withErrors(['query' => 'Sekolah tidak ditemukan.']);
        }

        $id_sekolah = $sekolah->id;

        $bantuan = Bantuan::where('sekolahs_id',$id_sekolah)->with('databantuan')->orderBy('tahun','asc')->get();

        // dd($bantuan);

        return view('frontend.index', ['sekolah' => $sekolah,'bantuan' => $bantuan, 'query' => $query]);
    }


}
