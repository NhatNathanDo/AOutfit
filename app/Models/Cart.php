<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 * 
 * @property string $id
 * @property string $user_id
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|CartItem[] $cart_items
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class Cart extends Model
{
	protected $table = 'carts';
	public $incrementing = false;

	protected $fillable = [
		'user_id',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function cart_items()
	{
		return $this->hasMany(CartItem::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
