<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\outboundDetail;
use DB;
use Log;

class outbound extends Model
{
    use HasFactory;

    protected $table = 'outbounds';

    protected $primaryKey = 'outboundId';

    protected $fillable = ['kodeOutbound','description','status'];

    public function outboundDetail(): HasMany
    {
        return $this->hasMany(outboundDetail::class,'outboundId');
    }

    public static function boot()
    {
        parent::boot();

        // Event saat menyimpan data
        static::creating(function ($outbounds) {
            $outbounds->generateKode();
            $outbounds->status=1;
        });
    }

    protected function generateKode()
    {
        // Mulai transaksi database untuk memastikan nomor urut konsisten
        DB::beginTransaction();

        try {
            // Lock tabel agar nomor urut tidak berubah saat simultan proses
            $lastOutbound = static::lockForUpdate()->orderBy('outboundId', 'desc')->first();

            $datePart = now()->format('Ym');
            $sequence = $lastOutbound ? ((int)substr($lastOutbound->kodeOutbound, -4)) + 1 : 1;

            // Padding nomor urut dengan nol hingga panjang 4 karakter
            $sequencePart = str_pad($sequence, 4, '0', STR_PAD_LEFT);

            $this->kodeOutbound = 'INB'.$datePart.$sequencePart;

            DB::commit(); // Commit transaksi jika sukses
        } catch (\Exception $e) {

            DB::rollback(); // Rollback transaksi jika terjadi kesalahan
            throw $e;
        }
    }
}
