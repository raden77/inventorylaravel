<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\purchase;
use DB;

class inbound extends Model
{
    use HasFactory;

    protected $table = 'inbounds';

    protected $primaryKey = 'inboundId';

    protected $fillable = ['kodeInbound','purchaseId','description','status'];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(purchase::class,'purchaseId');
    }

    public static function boot()
    {
        parent::boot();

        // Event saat menyimpan data
        static::creating(function ($inbounds) {
            $inbounds->generateKode();
            $inbounds->status=1;
        });
    }

    protected function generateKode()
    {
        // Mulai transaksi database untuk memastikan nomor urut konsisten
        DB::beginTransaction();

        try {
            // Lock tabel agar nomor urut tidak berubah saat simultan proses
            $lastInbound = static::lockForUpdate()->orderBy('inboundId', 'desc')->first();

            $datePart = now()->format('Ym');
            $sequence = $lastInbound ? ((int)substr($lastInbound->kodeInbound, -4)) + 1 : 1;

            // Padding nomor urut dengan nol hingga panjang 4 karakter
            $sequencePart = str_pad($sequence, 4, '0', STR_PAD_LEFT);

            $this->kodeInbound = 'INB'.$datePart.$sequencePart;

            DB::commit(); // Commit transaksi jika sukses
        } catch (\Exception $e) {

            DB::rollback(); // Rollback transaksi jika terjadi kesalahan
            throw $e;
        }
    }
}
