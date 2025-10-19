<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Helpers\HasUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $gender
 * @property Carbon|null $birth_date
 * @property string|null $skin_tone
 * @property string|null $face_shape
 * @property string|null $body_type
 * @property string|null $avatar_image
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|AiLog[] $ai_logs
 * @property Collection|Cart[] $carts
 * @property Collection|FaceAnalysisResult[] $face_analysis_results
 * @property Collection|Order[] $orders
 * @property Collection|Recommendation[] $recommendations
 * @property Collection|UserOutfitCollection[] $user_outfit_collections
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use HasUuid;
	protected $table = 'users';
	public $incrementing = false;
	protected $keyType = 'string';

	protected $casts = [
		'birth_date' => 'datetime',
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'gender',
		'birth_date',
		'skin_tone',
		'face_shape',
		'body_type',
		'avatar_image',
		'email_verified_at',
		'remember_token'
	];

	public function ai_logs()
	{
		return $this->hasMany(AiLog::class);
	}

	public function carts()
	{
		return $this->hasMany(Cart::class);
	}

	public function face_analysis_results()
	{
		return $this->hasMany(FaceAnalysisResult::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function recommendations()
	{
		return $this->hasMany(Recommendation::class);
	}

	public function user_outfit_collections()
	{
		return $this->hasMany(UserOutfitCollection::class);
	}
}
