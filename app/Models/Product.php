<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $category_id
 * @property string $brand_id
 * @property string|null $description
 * @property float $price
 * @property string $gender
 * @property string|null $style
 * @property string|null $color
 * @property string|null $material
 * @property string|null $image_url
 * @property int $stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Brand $brand
 * @property Category $category
 * @property Collection|CartItem[] $cart_items
 * @property Collection|OrderItem[] $order_items
 * @property Collection|OutfitSetItem[] $outfit_set_items
 * @property Collection|Recommendation[] $recommendations
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';
	public $incrementing = false;

	protected $casts = [
		'price' => 'float',
		'stock' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'category_id',
		'brand_id',
		'description',
		'price',
		'gender',
		'style',
		'color',
		'material',
		'image_url',
		'stock'
	];

	public function brand()
	{
		return $this->belongsTo(Brand::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function cart_items()
	{
		return $this->hasMany(CartItem::class);
	}

	public function order_items()
	{
		return $this->hasMany(OrderItem::class);
	}

	public function outfit_set_items()
	{
		return $this->hasMany(OutfitSetItem::class);
	}

	public function recommendations()
	{
		return $this->hasMany(Recommendation::class);
	}
}
