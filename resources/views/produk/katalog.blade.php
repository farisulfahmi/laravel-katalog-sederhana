@extends('layouts.app')

@section('content')
    <!-- Notifikasi jika produk berhasil ditambahkan -->
    @if (session('sukses'))
        <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px; border-radius: 4px;">
            {{ session('sukses') }}
        </div>
    @endif

    <!-- Bagian 1: Form Tambah Produk -->
    <div style="background: #f8f9fa; padding: 15px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 25px;">
        <h3 style="margin-top: 0;">Tambah Produk Baru</h3>
        <form action="/katalog" method="POST" style="display: flex; gap: 10px; flex-wrap: wrap;">
            @csrf
            <input type="text" name="nama" placeholder="Nama Produk" required style="padding: 8px; flex: 2;">
            <input type="number" name="harga" placeholder="Harga (Rp)" min="0" required style="padding: 8px; flex: 1;">
            <input type="number" name="stok" placeholder="Stok" min="0" required style="padding: 8px; flex: 1;">
            <button type="submit" style="padding: 8px 16px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                + Tambah Produk
            </button>
        </form>
    </div>

    <!-- Bagian 2: Header Daftar Produk & Form Search -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; flex-wrap: wrap; gap: 10px;">
        <h3 style="margin: 0;">Daftar Produk</h3>

        <form action="/katalog" method="GET" style="display: flex; gap: 5px;">
            <input class="search" type="search" name="search" value="{{ $keyword ?? '' }}" placeholder="Cari nama produk..." style="padding: 7px; width: 220px;">
            <button type="submit" style="padding: 7px 14px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Cari
            </button>
            @if (!empty($keyword))
                <a href="/katalog" style="padding: 7px 12px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Bagian 3: Tabel Data Produk -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Status Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produks as $produk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $produk['nama'] }}</td>
                    
                    <!-- Format Harga Rupiah -->
                    <td>Rp {{ number_format($produk['harga'], 0, ',', '.') }}</td>
                    
                    <!-- Kondisi Status Stok -->
                    <td>
                        @if ($produk['stok'] > 0)
                            <span style="color: green; font-weight: bold;">Tersedia ({{ $produk['stok'] }})</span>
                        @else
                            <span style="color: red; font-weight: bold;">Stok Habis ({{ $produk['stok'] }})</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #666;">
                        @if (!empty($keyword))
                            Produk dengan kata kunci "<strong>{{ $keyword }}</strong>" tidak ditemukan.
                        @else
                            Belum ada data produk yang tersedia.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
