<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FaceAnalysisResult
 * 
 * @property string $id
 * @property string $user_id
 * @property string $face_shape
 * @property string $skin_tone
 * @property array|null $recommended_colors
 * @property array|null $recommended_styles
 * @property Carbon $created_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class FaceAnalysisResult extends Model
{
	protected $table = 'face_analysis_results';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'recommended_colors' => 'json',
		'recommended_styles' => 'json'
	];

	protected $fillable = [
		'user_id',
		'face_shape',
		'skin_tone',
		'recommended_colors',
		'recommended_styles'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
