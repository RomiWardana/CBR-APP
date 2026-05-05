<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasus;
use App\Models\Gejala;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CBRController extends Controller
{
    // 🏠 FORM
    public function index()
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        return view('diagnosa');
    }

    // 🧠 PROSES CBR + AUTO LEARNING + RIWAYAT (FIX STABLE)
    public function proses(Request $request)
    {
        $inputText = strtolower($request->gejala_input ?? '');
        $inputText = preg_replace('/[^a-z0-9\s]/', ' ', $inputText);
        $inputText = preg_replace('/\s+/', ' ', trim($inputText));

        $inputWords = array_filter(explode(' ', $inputText));

        $semuaGejala = Gejala::all();
        $inputGejala = [];

        // 🔥 DETEKSI GEJALA
        // 🔥 DETEKSI GEJALA - partial match
foreach ($semuaGejala as $g) {
    $nama = strtolower($g->nama_gejala);
    $nama = preg_replace('/[^a-z0-9\s]/', ' ', $nama);
    $nama = preg_replace('/\s+/', ' ', trim($nama));
    $gejalaWords = array_filter(explode(' ', $nama));

    $stopwords = ['tidak', 'dan', 'atau', 'yang', 'di', 'ke', 'dari', 'ada', 'nya', 'bisa', 'saat', 'pada', 'dengan', 'sering'];

    // Kata kunci penting dari nama gejala (tanpa stopwords, panjang > 3)
    $keywords = array_filter($gejalaWords, fn($w) => strlen($w) > 3 && !in_array($w, $stopwords));

    if (empty($keywords)) continue;

    $matchCount = 0;
    foreach ($keywords as $keyword) {
        foreach ($inputWords as $inputWord) {
            // Cek apakah kata input mengandung keyword atau sebaliknya
            if (str_contains($inputWord, $keyword) || str_contains($keyword, $inputWord)) {
                $matchCount++;
                break;
            }
        }
    }

    // Cocok minimal 1 kata kunci penting
    if ($matchCount >= 1) {
        $ratio = $matchCount / count($keywords);
        $inputGejala[$g->id] = $ratio;
    }
}

        // 🔥 HITUNG KEMIRIPAN
        $kasusList = Kasus::with(['gejala', 'diagnosa'])->get();
       $hasil = collect($kasusList)->map(function ($kasus) use ($inputGejala) {

    $gejalaKasus = $kasus->gejala; // objek dengan pivot bobot

    $totalBobot = 0;
    $matchScore = 0;

    foreach ($gejalaKasus as $g) {
        $bobot = $g->pivot->bobot ?? 1;
        $totalBobot += $bobot;

        if (isset($inputGejala[$g->id])) {
            $matchScore += $bobot;
        }
    }

    $similarity = $totalBobot > 0 ? $matchScore / $totalBobot : 0;

    return [
        'kasus_id' => $kasus->id,
        'kasus' => $kasus,
        'similarity' => $similarity
    ];

})->groupBy('kasus_id')
  ->map(fn($items) => collect($items)->sortByDesc('similarity')->first())
  ->values()
  ->sortByDesc('similarity')
  ->values()
  ->toArray();

        $terbaik = $hasil[0] ?? null;

        // =========================
        // 🧠 SIMPAN RIWAYAT (FIX FINAL)
        // =========================
        $userId = session('id_user');

        if ($terbaik && $userId && DB::table('users')->where('id', $userId)->exists()) {

            DB::table('riwayat')->insert([
                'user_id' => $userId,
                'input_text' => $request->gejala_input,
                'hasil_diagnosa' => $terbaik['kasus']->diagnosa->nama_diagnosa ?? '-',
                'similarity' => round($terbaik['similarity'] * 100, 2),
                'solusi' => $terbaik['kasus']->diagnosa->solusi ?? '-',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =========================
        // 🔥 AUTO LEARNING (NO DUPLICATE CASE)
        // =========================
        if ($terbaik && $terbaik['similarity'] > 0.6) {

            $existing = Kasus::with('gejala')->get();

            $inputIds = array_keys($inputGejala);
            sort($inputIds);

            foreach ($existing as $k) {
                $existingIds = $k->gejala->pluck('id')->toArray();
                sort($existingIds);

                if ($existingIds == $inputIds) {
                    return view('hasil', compact('terbaik', 'hasil'));
                }
            }

            $kasusId = DB::table('kasus')->insertGetId([
                'diagnosa_id' => $terbaik['kasus']->diagnosa_id,
            ]);

            foreach ($inputGejala as $gid => $score) {
                DB::table('kasus_gejala')->insert([
                    'kasus_id' => $kasusId,
                    'gejala_id' => $gid,
                    'bobot' => $score
                ]);
            }
        }

        return view('hasil', [
            'terbaik' => $terbaik,
            'hasil' => $hasil
        ]);
    }

    // 🔐 LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'identitas' => 'required',
            'password' => 'required'
        ]);

        $user = DB::table('users')
            ->where('email', $request->identitas)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Login gagal');
        }

        session()->flush();
        session()->regenerate();

        session([
            'login' => true,
            'id_user' => $user->id,
            'nama' => $user->name,
            'username' => $user->email
        ]);

        return redirect('/index');
    }

    // 📝 REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'identitas' => 'required',
            'password' => 'required'
        ]);

        $cek = DB::table('users')
            ->where('email', $request->identitas)
            ->first();

        if ($cek) {
            return back()->with('error', 'Email sudah digunakan!');
        }

        DB::table('users')->insert([
            'name' => $request->nama,
            'email' => $request->identitas,
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Registrasi berhasil!');
    }

    // 🚪 LOGOUT
    public function logout()
    {
        session()->flush();
        session()->regenerateToken();

        return redirect('/login');
    }

    // 📊 RIWAYAT (FINAL FIX)
    public function riwayat()
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        $userId = session('id_user');

        $riwayat = DB::table('riwayat')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat', compact('riwayat'));
    }
}