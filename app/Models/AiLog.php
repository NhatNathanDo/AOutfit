<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AiLog
 * 
 * @property string $id
 * @property string $user_id
 * @property string $action
 * @property array|null $input_data
 * @property array|null $output_data
 * @property float $confidence
 * @property Carbon $created_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class AiLog extends Model
{
	protected $table = 'ai_logs';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'input_data' => 'json',
		'output_data' => 'json',
		'confidence' => 'float'
	];

	protected $fillable = [
		'user_id',
		'action',
		'input_data',
		'output_data',
		'confidence'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
