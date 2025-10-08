<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OutfitSet
 * 
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string|null $style
 * @property string $gender
 * @property string|null $image_preview
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|OutfitSetItem[] $outfit_set_items
 * @property Collection|UserOutfitCollection[] $user_outfit_collections
 *
 * @package App\Models
 */
class OutfitSet extends Model
{
	protected $table = 'outfit_sets';
	public $incrementing = false;

	protected $fillable = [
		'name',
		'description',
		'style',
		'gender',
		'image_preview'
	];

	public function outfit_set_items()
	{
		return $this->hasMany(OutfitSetItem::class);
	}

	public function user_outfit_collections()
	{
		return $this->hasMany(UserOutfitCollection::class);
	}
}
