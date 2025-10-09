<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OutfitSetItem
 * 
 * @property string $id
 * @property string $outfit_set_id
 * @property string $product_id
 * 
 * @property OutfitSet $outfit_set
 * @property Product $product
 *
 * @package App\Models
 */
class OutfitSetItem extends Model
{
	protected $table = 'outfit_set_items';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'outfit_set_id',
		'product_id'
	];

	public function outfit_set()
	{
		return $this->belongsTo(OutfitSet::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
