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

    // 🧠 PROSES CBR
    public function proses(Request $request)
    {
        $inputText = strtolower($request->gejala_input ?? '');
        $inputText = preg_replace('/[^a-z0-9\s]/', ' ', $inputText);
        $inputText = preg_replace('/\s+/', ' ', trim($inputText));
        $inputWords = array_filter(explode(' ', $inputText));

        // Hapus stopwords umum
        $stopwords = ['tidak', 'dan', 'atau', 'yang', 'di', 'ke', 'dari', 'ada', 'nya', 'bisa', 'saat', 'pada', 'dengan'];
        $inputWords = array_diff($inputWords, $stopwords);
        $inputWords = array_values($inputWords);

        $semuaGejala = Gejala::all();
        $inputGejala = [];

        // 🔥 DETEKSI GEJALA - exact phrase match atau cocok semua kata penting
        foreach ($semuaGejala as $g) {
            $nama = strtolower($g->nama_gejala);
            $nama = preg_replace('/[^a-z0-9\s]/', ' ', $nama);
            $nama = preg_replace('/\s+/', ' ', trim($nama));

            // Hapus stopwords dari nama gejala juga
            $gejalaWords = array_diff(
                array_filter(explode(' ', $nama)),
                $stopwords
            );
            $gejalaWords = array_values($gejalaWords);

            // Hitung kata penting yang cocok (panjang > 3 karakter)
            $importantWords = array_filter($gejalaWords, fn($w) => strlen($w) > 3);
            $importantInput = array_filter($inputWords, fn($w) => strlen($w) > 3);

            if (empty($importantWords)) continue;

            $matchCount = 0;
            foreach ($importantWords as $word) {
                if (in_array($word, $importantInput)) {
                    $matchCount++;
                }
            }

            // Harus cocok SEMUA kata penting dari nama gejala
            if ($matchCount === count($importantWords) && $matchCount > 0) {
                $inputGejala[$g->id] = 1;
            }
        }

        if (empty($inputGejala)) {
            return back()->with('error', 'Gejala tidak dikenali, coba lebih spesifik');
        }

        // 🔥 HITUNG KEMIRIPAN pakai Jaccard + Bobot
        $kasusList = Kasus::with(['gejala', 'diagnosa'])->get();

        $hasil = collect($kasusList)->map(function ($kasus) use ($inputGejala) {

            $gejalaKasus = $kasus->gejala;
            $kasusIds = $gejalaKasus->pluck('id')->toArray();
            $inputIds = array_keys($inputGejala);

            // Intersect: gejala yang ada di kedua sisi
            $intersection = array_intersect($kasusIds, $inputIds);
            // Union: gabungan semua gejala
            $union = array_unique(array_merge($kasusIds, $inputIds));

            if (empty($union)) {
                $similarity = 0;
            } else {
                // Jaccard similarity dengan bobot
                $intersectScore = 0;
                $totalBobot = 0;

                foreach ($gejalaKasus as $g) {
                    $bobot = $g->pivot->bobot ?? 1;
                    $totalBobot += $bobot;
                    if (in_array($g->id, $inputIds)) {
                        $intersectScore += $bobot;
                    }
                }

                // Penalty: gejala input yang tidak ada di kasus ini
                $notMatched = count(array_diff($inputIds, $kasusIds));
                $penalty = 1 / (1 + $notMatched);

                $similarity = $totalBobot > 0
                    ? ($intersectScore / $totalBobot) * $penalty
                    : 0;
            }

            return [
                'kasus_id' => $kasus->id,
                'kasus' => $kasus,
                'similarity' => $similarity
            ];

        })->filter(fn($item) => $item['similarity'] > 0)
          ->groupBy('kasus_id')
          ->map(fn($items) => collect($items)->sortByDesc('similarity')->first())
          ->values()
          ->sortByDesc('similarity')
          ->values()
          ->toArray();

        if (empty($hasil)) {
            return back()->with('error', 'Tidak ditemukan kasus yang cocok');
        }

        $terbaik = $hasil[0] ?? null;

        // =========================
        // 🧠 SIMPAN RIWAYAT
        // =========================
        $userId = session('id_user');

        if ($terbaik && $userId && DB::table('users')->where('id', $userId)->exists()) {
            DB::table('riwayat')->insert([
                'user_id'        => $userId,
                'input_text'     => $request->gejala_input,
                'hasil_diagnosa' => $terbaik['kasus']->diagnosa->nama_diagnosa ?? '-',
                'similarity'     => round($terbaik['similarity'] * 100, 2),
                'solusi'         => $terbaik['kasus']->diagnosa->solusi ?? '-',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // =========================
        // 🔥 AUTO LEARNING - hanya jika similarity tinggi tapi tidak sempurna
        // =========================
        if ($terbaik && $terbaik['similarity'] >= 0.5 && $terbaik['similarity'] < 0.95) {

            $existing = Kasus::with('gejala')->get();
            $inputIds = array_keys($inputGejala);
            sort($inputIds);

            $alreadyExists = false;
            foreach ($existing as $k) {
                $existingIds = $k->gejala->pluck('id')->toArray();
                sort($existingIds);
                if ($existingIds == $inputIds) {
                    $alreadyExists = true;
                    break;
                }
            }

            if (!$alreadyExists) {
                $kasusId = DB::table('kasus')->insertGetId([
                    'diagnosa_id' => $terbaik['kasus']->diagnosa_id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                foreach ($inputGejala as $gid => $score) {
                    DB::table('kasus_gejala')->insert([
                        'kasus_id' => $kasusId,
                        'gejala_id' => $gid,
                        'bobot'    => 2,
                    ]);
                }
            }
        }

        return view('hasil', [
            'terbaik' => $terbaik,
            'hasil'   => $hasil
        ]);
    }

    // 🔐 LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'identitas' => 'required',
            'password'  => 'required'
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
            'login'    => true,
            'id_user'  => $user->id,
            'nama'     => $user->name,
            'username' => $user->email
        ]);

        return redirect('/index');
    }

    // 📝 REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nama'      => 'required',
            'identitas' => 'required',
            'password'  => 'required'
        ]);

        $cek = DB::table('users')
            ->where('email', $request->identitas)
            ->first();

        if ($cek) {
            return back()->with('error', 'Email sudah digunakan!');
        }

        DB::table('users')->insert([
            'name'     => $request->nama,
            'email'    => $request->identitas,
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

    // 📊 RIWAYAT
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