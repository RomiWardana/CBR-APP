<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CBRSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // 🧹 RESET (BIAR GAK DOUBLE)
        // =========================
        DB::table('kasus_gejala')->delete();
        DB::table('kasus')->delete();
        DB::table('gejala')->delete();
        DB::table('diagnosa')->delete();

        // =========================
        // 🔧 GEJALA (UNIQUE, CLEAN)
        // =========================
        $gejala = [
            ['nama_gejala' => 'komputer tidak menyala'],
            ['nama_gejala' => 'laptop tidak hidup'],
            ['nama_gejala' => 'layar blank'],
            ['nama_gejala' => 'kipas tidak berputar'],
            ['nama_gejala' => 'bunyi beep berulang'],
            ['nama_gejala' => 'komputer cepat panas'],
            ['nama_gejala' => 'harddisk tidak terbaca'],
            ['nama_gejala' => 'ssd tidak terdeteksi'],
            ['nama_gejala' => 'windows gagal booting'],
            ['nama_gejala' => 'printer tidak bisa print'],
            ['nama_gejala' => 'printer offline'],
            ['nama_gejala' => 'keyboard tidak berfungsi'],
            ['nama_gejala' => 'mouse tidak terdeteksi'],
        ];

        DB::table('gejala')->insert($gejala);

        // =========================
        // 🧠 DIAGNOSA (REAL CASE)
        // =========================
        $diagnosa = [
            ['nama_diagnosa' => 'Power Supply Rusak', 'solusi' => 'Ganti PSU atau cek kabel power'],
            ['nama_diagnosa' => 'Motherboard Error', 'solusi' => 'Periksa jalur motherboard atau ganti board'],
            ['nama_diagnosa' => 'Overheating CPU', 'solusi' => 'Bersihkan kipas & ganti thermal paste'],
            ['nama_diagnosa' => 'Harddisk/SSD Error', 'solusi' => 'Backup data dan ganti storage'],
            ['nama_diagnosa' => 'Windows Corrupt', 'solusi' => 'Repair atau reinstall Windows'],
            ['nama_diagnosa' => 'Printer Error', 'solusi' => 'Install ulang driver printer'],
            ['nama_diagnosa' => 'Keyboard Error', 'solusi' => 'Ganti keyboard atau cek konektor'],
            ['nama_diagnosa' => 'Mouse Error', 'solusi' => 'Ganti mouse atau cek USB'],
        ];

        DB::table('diagnosa')->insert($diagnosa);

        // =========================
        // 📦 KASUS (TRAINING SET)
        // =========================
        $kasus = [
            ['diagnosa_id' => 1],
            ['diagnosa_id' => 2],
            ['diagnosa_id' => 3],
            ['diagnosa_id' => 4],
            ['diagnosa_id' => 5],
            ['diagnosa_id' => 6],
            ['diagnosa_id' => 7],
            ['diagnosa_id' => 8],
        ];

        DB::table('kasus')->insert($kasus);

        // =========================
        // 🔗 RELASI KASUS - GEJALA
        // =========================
        $relasi = [

            // PSU
            ['kasus_id' => 1, 'gejala_id' => 1],
            ['kasus_id' => 1, 'gejala_id' => 3],

            // Motherboard
            ['kasus_id' => 2, 'gejala_id' => 5],
            ['kasus_id' => 2, 'gejala_id' => 6],

            // Overheat
            ['kasus_id' => 3, 'gejala_id' => 4],
            ['kasus_id' => 3, 'gejala_id' => 6],

            // Storage
            ['kasus_id' => 4, 'gejala_id' => 7],
            ['kasus_id' => 4, 'gejala_id' => 8],

            // Windows
            ['kasus_id' => 5, 'gejala_id' => 9],
            ['kasus_id' => 5, 'gejala_id' => 3],

            // Printer
            ['kasus_id' => 6, 'gejala_id' => 10],
            ['kasus_id' => 6, 'gejala_id' => 11],

            // Keyboard
            ['kasus_id' => 7, 'gejala_id' => 12],

            // Mouse
            ['kasus_id' => 8, 'gejala_id' => 13],
        ];

        DB::table('kasus_gejala')->insert($relasi);
    }
}