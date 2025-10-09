<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * 
 * @property string $id
 * @property string $name
 * @property string|null $country
 * 
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Brand extends Model
{
	protected $table = 'brands';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'name',
		'country'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
