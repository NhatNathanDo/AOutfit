<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property string $id
 * @property string $order_id
 * @property string $transaction_id
 * @property string $payment_gateway
 * @property float $amount
 * @property string $currency
 * @property string $status
 * @property Carbon|null $paid_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Order $order
 *
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payments';
	public $incrementing = false;

	protected $casts = [
		'amount' => 'float',
		'paid_at' => 'datetime'
	];

	protected $fillable = [
		'order_id',
		'transaction_id',
		'payment_gateway',
		'amount',
		'currency',
		'status',
		'paid_at'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
