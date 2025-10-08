<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property string $id
 * @property string $user_id
 * @property string|null $cart_id
 * @property float $total_amount
 * @property string $status
 * @property string $payment_method
 * @property string $shipping_address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Cart|null $cart
 * @property User $user
 * @property Collection|OrderItem[] $order_items
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';
	public $incrementing = false;

	protected $casts = [
		'total_amount' => 'float'
	];

	protected $fillable = [
		'user_id',
		'cart_id',
		'total_amount',
		'status',
		'payment_method',
		'shipping_address'
	];

	public function cart()
	{
		return $this->belongsTo(Cart::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function order_items()
	{
		return $this->hasMany(OrderItem::class);
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}
}
