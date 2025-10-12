<?php

/**
 * Created by Reliese Model.
 */

namespace App\Modules\Products\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Brand\Models\Brand;
use App\Modules\Category\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\OutfitSetItem;
use App\Models\Recommendation;
use App\Modules\Products\Models\ProductImage;

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
 * @property Collection|\App\Models\CartItem[] $cart_items
 * @property Collection|\App\Models\OrderItem[] $order_items
 * @property Collection|\App\Models\OutfitSetItem[] $outfit_set_items
 * @property Collection|\App\Models\Recommendation[] $recommendations
 * @property Collection|ProductImage[] $images
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';
	public $incrementing = false;
	protected $keyType = 'string';

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

	// New relations for multiple images
	public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('created_at');
	}

	public function primaryImage(): \Illuminate\Database\Eloquent\Relations\HasOne
	{
		return $this->hasOne(ProductImage::class)->where('is_primary', true);
	}
}
