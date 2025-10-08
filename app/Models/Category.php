<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property string $id
 * @property string $name
 * @property string|null $parent_id
 * @property string $slug
 * 
 * @property Category|null $category
 * @property Collection|Category[] $categories
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'name',
		'parent_id',
		'slug'
	];

	public function category()
	{
		return $this->belongsTo(Category::class, 'parent_id');
	}

	public function categories()
	{
		return $this->hasMany(Category::class, 'parent_id');
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
