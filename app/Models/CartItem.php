<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\HasUuid;
use App\Modules\Products\Models\Product;

/**
 * Class CartItem
 * 
 * @property string $id
 * @property string $cart_id
 * @property string $product_id
 * @property int $quantity
 * @property float $price
 * 
 * @property Cart $cart
 * @property Product $product
 *
 * @package App\Models
 */
class CartItem extends Model
{
	protected $table = 'cart_items';
	public $incrementing = false;
	public $timestamps = false;
	use HasUuid;

	protected $casts = [
		'quantity' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'cart_id',
		'product_id',
		'quantity',
		'price'
	];

	public function cart()
	{
		return $this->belongsTo(Cart::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id');
	}
}
