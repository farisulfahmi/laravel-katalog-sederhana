<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Daftar produk bawaan
    private function dataAwal()
    {
        return [
            ['nama' => 'Kopi Susu', 'harga' => 5000, 'stok' => 10],
            ['nama' => 'Kopi Gula Aren', 'harga' => 3000, 'stok' => 20],
            ['nama' => 'Kopi Kapal Api', 'harga' => 2000, 'stok' => 0],
            ['nama' => 'Kopi Tugu Buaya', 'harga' => 2000, 'stok' => 0],
        ];
    }

    // Menampilkan halaman katalog & logika Search
    public function index(Request $request)
    {
        // Ambil data dari session, jika belum ada gunakan dataAwal()
        $produks = session('daftar_produk', $this->dataAwal());

        // Cek apakah user mengetik kata kunci di kolom search
        $keyword = $request->query('search');
        if ($keyword) {
            $produks = array_filter($produks, function ($item) use ($keyword) {
                return stripos($item['nama'], $keyword) !== false;
            });
        }

        return view('produk.katalog', compact('produks', 'keyword'));
    }

    // Logika menyimpan produk baru dari form
    public function store(Request $request)
    {
        // Validasi input agar tidak kosong dan harga/stok berupa angka
        $request->validate([
            'nama' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        // Ambil daftar produk yang tersimpan saat ini
        $produks = session('daftar_produk', $this->dataAwal());

        // Masukkan produk baru ke dalam daftar
        $produks[] = [
            'nama' => $request->nama,
            'harga' => (int) $request->harga,
            'stok' => (int) $request->stok,
        ];

        // Simpan kembali daftar terbaru ke session
        session(['daftar_produk' => $produks]);

        // Kembali ke halaman katalog dengan pesan sukses
        return redirect('/katalog')->with('sukses', 'Produk baru berhasil ditambahkan!');
    }
}
