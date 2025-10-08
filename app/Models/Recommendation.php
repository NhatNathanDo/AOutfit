<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Recommendation
 * 
 * @property string $id
 * @property string $user_id
 * @property string $product_id
 * @property float $confidence_score
 * @property string|null $reason
 * @property Carbon $created_at
 * 
 * @property Product $product
 * @property User $user
 *
 * @package App\Models
 */
class Recommendation extends Model
{
	protected $table = 'recommendations';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'confidence_score' => 'float'
	];

	protected $fillable = [
		'user_id',
		'product_id',
		'confidence_score',
		'reason'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
