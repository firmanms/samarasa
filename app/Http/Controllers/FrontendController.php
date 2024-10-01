<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {

        return view('frontend.index', ['sekolah' => null,'bantuan' => null, 'query' => '', 'token' => '']); // Awalnya tidak ada hasil
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
            // 'captcha' => 'required|captcha',
            'token' => 'required|string|max:255',
        ]);

        // Ambil input dengan benar
        $query = $request->input('query');
        $token = $request->input('token');
        // dd($token);
        // Mencari sekolah
        $sekolah = Sekolah::where('npsn', '=', $query)->where('token', '=', $token)->first();


        // Cek apakah sekolah ditemukan
        if (is_null($sekolah)) {
            // Tampilkan pesan kesalahan atau kembali ke halaman sebelumnya
            return redirect()->back()->withErrors(['query' => 'Sekolah tidak ditemukan.']);
        }

        $id_sekolah = $sekolah->id;

        $bantuan = Bantuan::where('sekolahs_id',$id_sekolah)->with('databantuan')->orderBy('tahun','asc')->get();

        // dd($bantuan);

        return view('frontend.index', ['sekolah' => $sekolah,'bantuan' => $bantuan, 'query' => $query, 'token' => $token]);
    }


}
