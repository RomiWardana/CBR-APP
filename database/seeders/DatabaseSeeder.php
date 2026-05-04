<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // 🔧 GEJALA (FINAL FIXED VERSION)
        // =========================
        DB::table('gejala')->insert([
            ['nama_gejala' => 'Komputer tidak menyala'],
            ['nama_gejala' => 'Laptop tidak menyala'],
            ['nama_gejala' => 'Laptop mati mendadak'],
            ['nama_gejala' => 'Layar hitam saat booting'],
            ['nama_gejala' => 'Tidak ada tampilan monitor'],
            ['nama_gejala' => 'CPU cepat panas'],
            ['nama_gejala' => 'Kipas tidak berputar'],
            ['nama_gejala' => 'Bunyi beep berulang'],
            ['nama_gejala' => 'Harddisk tidak terbaca'],
            ['nama_gejala' => 'SSD tidak terdeteksi'],
            ['nama_gejala' => 'Laptop tidak mengisi daya'],
            ['nama_gejala' => 'Baterai cepat habis'],
            ['nama_gejala' => 'Blue screen muncul'],
            ['nama_gejala' => 'Komputer restart sendiri'],
            ['nama_gejala' => 'Windows gagal booting'],
            ['nama_gejala' => 'Printer tidak bisa print'],
            ['nama_gejala' => 'Printer offline'],
            ['nama_gejala' => 'Kertas printer macet'],
            ['nama_gejala' => 'Hasil print buram'],
            ['nama_gejala' => 'Keyboard tidak berfungsi'],
            ['nama_gejala' => 'Mouse tidak terdeteksi'],
            ['nama_gejala' => 'Internet lambat'],
            ['nama_gejala' => 'WiFi tidak terhubung'],
        ]);

        // =========================
        // 🧠 DIAGNOSA (STABLE)
        // =========================
        DB::table('diagnosa')->insert([
            ['nama_diagnosa' => 'Power Supply Rusak', 'solusi' => 'Ganti PSU atau cek kabel power'],
            ['nama_diagnosa' => 'Motherboard Error', 'solusi' => 'Cek jalur motherboard atau ganti board'],
            ['nama_diagnosa' => 'Overheating CPU', 'solusi' => 'Bersihkan kipas dan ganti thermal paste'],
            ['nama_diagnosa' => 'Kerusakan RAM', 'solusi' => 'Bersihkan RAM atau ganti modul RAM'],
            ['nama_diagnosa' => 'Harddisk/SSD Error', 'solusi' => 'Backup data dan ganti storage'],
            ['nama_diagnosa' => 'Windows Corrupt', 'solusi' => 'Repair atau reinstall Windows'],
            ['nama_diagnosa' => 'Printer Error', 'solusi' => 'Install ulang driver atau cek printer'],
            ['nama_diagnosa' => 'Keyboard Error', 'solusi' => 'Ganti keyboard atau cek konektor'],
            ['nama_diagnosa' => 'Mouse Error', 'solusi' => 'Ganti mouse atau cek USB'],
            ['nama_diagnosa' => 'Jaringan Bermasalah', 'solusi' => 'Reset router atau cek konfigurasi'],
            ['nama_diagnosa' => 'Baterai Laptop Rusak', 'solusi' => 'Ganti baterai atau adaptor'],
            ['nama_diagnosa' => 'Overheating Laptop', 'solusi' => 'Bersihkan kipas dan cooling system'],
        ]);

        // =========================
        // 📦 KASUS (CBR CLEAN STRUCTURE)
        // =========================
        DB::table('kasus')->insert([
            ['diagnosa_id' => 1],
            ['diagnosa_id' => 2],
            ['diagnosa_id' => 3],
            ['diagnosa_id' => 4],
            ['diagnosa_id' => 5],
            ['diagnosa_id' => 6],
            ['diagnosa_id' => 7],
            ['diagnosa_id' => 8],
            ['diagnosa_id' => 9],
            ['diagnosa_id' => 10],
            ['diagnosa_id' => 11],
            ['diagnosa_id' => 12],
        ]);

        // =========================
        // 🔗 RELASI GEJALA - KASUS (FIXED + BOBOT REAL)
        // =========================

        // 🔥 POWER SUPPLY
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 1, 'gejala_id' => 1, 'bobot' => 3],
            ['kasus_id' => 1, 'gejala_id' => 5, 'bobot' => 2],
            ['kasus_id' => 1, 'gejala_id' => 8, 'bobot' => 2],
            ['kasus_id' => 1, 'gejala_id' => 14, 'bobot' => 1],
        ]);

        // 🔥 MOTHERBOARD
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 2, 'gejala_id' => 8, 'bobot' => 3],
            ['kasus_id' => 2, 'gejala_id' => 5, 'bobot' => 2],
            ['kasus_id' => 2, 'gejala_id' => 13, 'bobot' => 2],
        ]);

        // 🔥 OVERHEATING CPU
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 3, 'gejala_id' => 6, 'bobot' => 3],
            ['kasus_id' => 3, 'gejala_id' => 7, 'bobot' => 3],
            ['kasus_id' => 3, 'gejala_id' => 14, 'bobot' => 1],
        ]);

        // 🔥 RAM
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 4, 'gejala_id' => 13, 'bobot' => 3],
            ['kasus_id' => 4, 'gejala_id' => 8, 'bobot' => 2],
        ]);

        // 🔥 STORAGE
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 5, 'gejala_id' => 9, 'bobot' => 3],
            ['kasus_id' => 5, 'gejala_id' => 10, 'bobot' => 3],
        ]);

        // 🔥 WINDOWS
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 6, 'gejala_id' => 15, 'bobot' => 3],
            ['kasus_id' => 6, 'gejala_id' => 13, 'bobot' => 2],
        ]);

        // 🔥 PRINTER
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 7, 'gejala_id' => 16, 'bobot' => 3],
            ['kasus_id' => 7, 'gejala_id' => 17, 'bobot' => 3],
        ]);

        // 🔥 KEYBOARD
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 8, 'gejala_id' => 20, 'bobot' => 3],
        ]);

        // 🔥 MOUSE
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 9, 'gejala_id' => 21, 'bobot' => 3],
        ]);

        // 🔥 INTERNET
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 10, 'gejala_id' => 22, 'bobot' => 3],
            ['kasus_id' => 10, 'gejala_id' => 23, 'bobot' => 3],
        ]);

        // 🔥 BATERAI
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 11, 'gejala_id' => 11, 'bobot' => 3],
            ['kasus_id' => 11, 'gejala_id' => 12, 'bobot' => 3],
        ]);

        // 🔥 OVERHEATING LAPTOP
        DB::table('kasus_gejala')->insert([
            ['kasus_id' => 12, 'gejala_id' => 6, 'bobot' => 3],
            ['kasus_id' => 12, 'gejala_id' => 7, 'bobot' => 3],
            ['kasus_id' => 12, 'gejala_id' => 3, 'bobot' => 2],
        ]);
    }
}