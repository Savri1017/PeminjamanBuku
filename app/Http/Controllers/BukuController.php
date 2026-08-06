<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;


class BukuController extends Controller
{
    public function index()
    {
        $page = max(1, (int) request()->query('page', 1));
        $limit = max(1, (int) request()->query('limit', 5));
        $offset = ($page - 1) * $limit;
        $totaldata = Buku::count();
        $totalpage = (int) ceil($totaldata / $limit);

        $buku = Buku::offset($offset)
            ->limit($limit)
            ->get();   
            
        $formatbuku = $buku->map(function ($item) {
            return [
                'id' => $item->id,
                'judul' => $item->judul,
                'penulis' => $item->penulis,
                'status_buku' => $item->is_aktif ? 'Tersedia/Aktif' : 'Tidak Tersedia/Nonaktif',
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data buku berhasil diambil',
            'meta' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total_data' => $totaldata,
                'total_page' => $totalpage,
            ],
            'data' => $formatbuku
        ], 200);
    }

    public function toggleAktif($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->is_aktif = !$buku->is_aktif;
        $buku->save();

        return response()->json([
            'message' => 'Status buku berhasil diubah.',
            'data' => $buku
        ]);
    }

    public function show($id)
    {
       $buku = Buku::findOrFail($id);

        return response()->json([
            'data' => [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'status_buku' => $buku->is_aktif ? 'Tersedia/Aktif' : 'Tidak Tersedia/Nonaktif',
                'is_aktif' => (bool) $buku->is_aktif,
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
        ]);

        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'is_aktif' => true,
        ]);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data' => $buku
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
        ]);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data' => $buku
        ], 200);
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }

    public function trash()
    {
        $buku = Buku::onlyTrashed()->get();

            return response()->json([
                'message' => 'Data buku yang dihapus',
                'data' => $buku
            ], 200);

        return response()->json($buku, 200);
    }

    public function restore($id)
    {
        $buku = Buku::onlyTrashed()->findOrFail($id);
        $buku->restore();

        return response()->json([
            'message' => 'Buku berhasil dikembalikan',
            'data' => $buku
        ], 200);
    }

    public function forceDelete($id)
    {
        $buku = Buku::onlyTrashed()->findOrFail($id);
        $buku->forceDelete();

        return response()->json([
            'message' => 'Buku berhasil dihapus secara permanen'
        ], 200);
    }
}
