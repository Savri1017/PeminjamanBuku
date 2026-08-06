<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $fillable = ['buku_id', 'nama_peminjam', 'tanggal_pinjam', 'status'];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
