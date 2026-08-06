<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'nama_peminjam' => 'required|string',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if (!$buku->is_aktif) {
            return response()->json([
                'message' => 'Buku sedang tidak tersedia untuk dipinjam!'
            ], 400); 
        }
        $peminjaman = Peminjaman::create([
            'buku_id' => $buku->id,
            'nama_peminjam' => $request->nama_peminjam,
            'tanggal_pinjam' => now(),
            'status' => 'dipinjam',
        ]);

        $buku->update([
            'is_aktif' => false
        ]);

        return response()->json([
            'message' => 'Peminjaman berhasil dicatat',
            'data' => $peminjaman->load('buku')
        ], 201);
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status === 'dikembalikan') {
            return response()->json([
                'message' => 'Buku sudah dikembalikan sebelumnya.'
            ], 400);
        }

        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        $buku = Buku::findOrFail ($peminjaman->buku_id);
        $buku->update([
            'is_aktif' => true
        ]);

        return response()->json([
            'message' => 'Buku berhasil dikembalikan.',
            'data' => $peminjaman->load('buku')
        ],200);
    }
}