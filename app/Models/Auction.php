<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Auction extends Model
{
    use HasFactory, SoftDeletes;

    // --- Tambahan: Default Attributes ---
    // Mengatur default duration 24 jam dan deposit 5% jika tidak diset saat pembuatan
    protected $attributes = [
        'duration_hours' => 24, // Default Timer: 24 Jam
        'payment_deadline_hours' => 24, // Default Pelunasan: 24 Jam
        'deposit_percentage' => 5.00, // Default Deposit: 5%
        'is_deposit_forfeited' => false,
    ];

    protected $fillable = [
        'vehicle_id',
        'starting_price',
        'current_price',
        'reserve_price',
        'deposit_amount',
        'deposit_percentage',
        'start_time',
        'end_time',
        'duration_hours',
        'status',
        'winner_id',
        'won_at',
        'payment_deadline',
        'payment_deadline_hours',
        'payment_completed',
        'payment_completed_at',
        'total_bids',
        'total_participants',
        'notes',
        'is_deposit_forfeited', 
    ];

    protected $casts = [
        'starting_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'reserve_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'deposit_percentage' => 'decimal:2',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'won_at' => 'datetime',
        'payment_deadline' => 'datetime',
        'payment_completed' => 'boolean',
        'payment_completed_at' => 'datetime',
        'duration_hours' => 'integer',
        'payment_deadline_hours' => 'integer',
        'total_bids' => 'integer',
        'total_participants' => 'integer',
        'is_deposit_forfeited' => 'boolean', 
    ];

    // --- Tambahan: Model Events untuk Otomatisasi Timer ---
    protected static function boot()
    {
        parent::boot();

        // Sebelum menyimpan/membuat Auction baru
        static::creating(function ($auction) {
            // 1. Tentukan waktu mulai saat ini (jika belum diset)
            if (empty($auction->start_time)) {
                $auction->start_time = Carbon::now();
            }

            // 2. Hitung waktu berakhir berdasarkan durasi jam
            // Jika duration_hours diset atau menggunakan default 24 jam
            if ($auction->duration_hours > 0) {
                $auction->end_time = $auction->start_time->copy()->addHours($auction->duration_hours);
            }

            // 3. Hitung Deposit Amount awal (berdasarkan starting_price)
            if (empty($auction->deposit_amount) && $auction->deposit_percentage > 0) {
                 $auction->deposit_amount = $auction->starting_price * ($auction->deposit_percentage / 100);
            }
        });
    }

    // Relationships
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class); 
    }

    public function bids()
    {
        return $this->hasMany(Bid::class)->orderBy('bid_amount', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    // Helper Methods
    public function isActive()
    {
        return $this->status === 'active' && now()->between($this->start_time, $this->end_time);
    }

    public function hasEnded()
    {
        return now()->greaterThan($this->end_time);
    }

    public function isPaymentOverdue()
    {
        // Cek jika batas waktu pelunasan sudah terlampaui dan pembayaran belum selesai
        return $this->payment_deadline 
               && now()->greaterThan($this->payment_deadline)
               && !$this->payment_completed;
    }

    public function isForfeited()
    {
        // Cek status deposit hangus
        return $this->is_deposit_forfeited === true;
    }

    /**
     * Logika untuk memproses deposit hangus dan membuka lelang kembali.
     * Metode ini harus dipanggil oleh Laravel Scheduler/Cron Job.
     */
    public function processForfeiture()
    {
        // Hanya proses jika pembayaran terlambat, belum hangus, dan ada pemenang
        if ($this->isPaymentOverdue() && !$this->isForfeited() && $this->winner_id) {

            // 1. Set status hangus dan update status lelang (misalnya ke 'forfeited')
            $this->update([
                'status' => 'forfeited', 
                'is_deposit_forfeited' => true,
            ]);

            // 2. Buka Lelang Kembali (ubah status kendaraan agar kembali muncul di daftar)
            // Asumsi model Vehicle berada di namespace yang sama atau di-import
            $vehicle = $this->vehicle; 
            if ($vehicle) {
                // Mengubah status Vehicle ke 'approved' agar kembali tayang
                $vehicle->update(['status' => 'approved']); 
            }

            // 3. Logika Pembagian Deposit (Contoh)
            // Di sini Anda akan dipanggil service/job untuk mendistribusikan
            // 'deposit_amount' kepada pemilik mobil dan aplikator.

            return true;
        }
        return false;
    }
}