<?php

namespace App;

use App\Concerns\ColumnFillable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Invoice extends Model
{
    use ColumnFillable;

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Stakeholder::class, 'vendor_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Stakeholder::class, 'client_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(
            Product::class,
            Order::class,
            'invoice_id',
            'id',
            'id',
            'product_id'
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            $model->orders()->each(function ($order) {
                $order->delete();
            });
        });
    }

    public function pay($user)
    {
        $transaction = Transaction::where('invoice_id', $this->id)->where('status_id', 7)->orWhere('status_id', 3)->get();

        throw_if($transaction->isNotEmpty(), new Exception());

        return Transaction::create([
            'user_id' => $user->id,
            'invoice_id' => $this->id,
            'reference' => $this->createReference(),
            'amount' => $this->total(),
            'url' => config('services.placetoPay.urlEndPoint'),
            'status_id' => 'in process'
        ]);
    }

    public function createReference()
    {
        $date = Carbon::parse($this->created_at);

        return 'EIS_'. $this->id. '_' . $date->format('Ymd') . $this->total() * 100;
    }

    public function total()
    {
        $orders = Order::where('invoice_id', $this->id)->get();
        return collect($orders)->reduce(static function ($subtotal, $order) {
            return $subtotal + $order->quantity * $order->unit_price;
        }, 0);
    }
}
