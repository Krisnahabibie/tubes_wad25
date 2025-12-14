<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model // Huruf besar
{

    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'user_id', 'nama_tamu', 'nomor_telepon', 
        'jumlah_tamu', 'tanggal_waktu_reservasi', 
        'status_reservasi', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function up()
{
    Schema::create('reservasi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang pesan
        $table->string('nama_pemesan'); // Nama (bisa beda dengan user akun)
        $table->string('no_hp');
        $table->date('tanggal_reservasi');
        $table->time('jam_reservasi');
        $table->integer('jumlah_orang');
        $table->text('catatan')->nullable(); // Request khusus (cth: kursi bayi)
        $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}
}
