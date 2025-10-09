<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderItem
 * 
 * @property string $id
 * @property string $order_id
 * @property string $product_id
 * @property int $quantity
 * @property float $price
 * 
 * @property Order $order
 * @property Product $product
 *
 * @package App\Models
 */
class OrderItem extends Model
{
	protected $table = 'order_items';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'quantity' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'order_id',
		'product_id',
		'quantity',
		'price'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
