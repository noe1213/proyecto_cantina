<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use Notifiable;

	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
	];
}
