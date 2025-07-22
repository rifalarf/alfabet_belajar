<?php

namespace App\Http\Controllers;

use App\Models\Alphabet; 
use Illuminate\Http\Request;

class BelajarController extends Controller
{
    /**
     * Menampilkan halaman utama Belajar dengan semua pilihan huruf.
     */
    public function index()
    {
        // Ambil semua data dari tabel alphabets, urutkan berdasarkan huruf
        $alphabets = Alphabet::orderBy('letter')->get();

        // Kirim data ke view 'belajar.index'
        return view('belajar.index', ['alphabets' => $alphabets]);
    }

    /**
     * Menampilkan detail dari satu huruf yang dipilih.
     */
    public function show(Alphabet $alphabet)
    {
        // Kirim data huruf yang dipilih ke view 'belajar.show'
        // Laravel secara otomatis akan mencari Alphabet berdasarkan ID atau key yang ada di URL
        return view('belajar.show', ['alphabet' => $alphabet]);
    }
}
