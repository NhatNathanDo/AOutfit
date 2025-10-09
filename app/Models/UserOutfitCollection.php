<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserOutfitCollection
 * 
 * @property string $id
 * @property string $user_id
 * @property string $outfit_set_id
 * @property string|null $note
 * @property bool $is_favorite
 * @property Carbon $created_at
 * 
 * @property OutfitSet $outfit_set
 * @property User $user
 *
 * @package App\Models
 */
class UserOutfitCollection extends Model
{
	protected $table = 'user_outfit_collections';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'is_favorite' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'outfit_set_id',
		'note',
		'is_favorite'
	];

	public function outfit_set()
	{
		return $this->belongsTo(OutfitSet::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
