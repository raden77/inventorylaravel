<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Log;
use App\Models\suppliers;
use App\Models\purchaseDetail;

class purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';

    protected $primaryKey = 'purchaseId';

    protected $fillable = ['kodePurchase','supplierId','description','status'];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(suppliers::class,'supplierId');
    }

    public function purchaseDetail(): HasMany
    {
        return $this->hasMany(purchaseDetail::class,'purchaseId');
    }

    public static function boot()
    {
        parent::boot();

        // Event saat menyimpan data
        static::creating(function ($purchases) {
            $purchases->generateKodePurchase();
            $purchases->status=1;
        });
    }

    protected function generateKodePurchase()
    {
        // Mulai transaksi database untuk memastikan nomor urut konsisten
        DB::beginTransaction();

        try {
            // Lock tabel agar nomor urut tidak berubah saat simultan proses
            $lastPurchase = static::lockForUpdate()->orderBy('purchaseId', 'desc')->first();

            $datePart = now()->format('Ym');
            $sequence = $lastPurchase ? ((int)substr($lastPurchase->kodePurchase, -4)) + 1 : 1;

            // Padding nomor urut dengan nol hingga panjang 4 karakter
            $sequencePart = str_pad($sequence, 4, '0', STR_PAD_LEFT);

            $this->kodePurchase = 'PR'.$datePart.$sequencePart;

            DB::commit(); // Commit transaksi jika sukses
        } catch (\Exception $e) {

            DB::rollback(); // Rollback transaksi jika terjadi kesalahan
            throw $e;
        }
    }

}
