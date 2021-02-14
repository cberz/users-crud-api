<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'avatar',
    'personal_id',
    'name',
    'lastname',
    'date_of_birth',
    'email',
    'password',
    'is_admin',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password',
      'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
      'date_of_birth' => 'date',
      'is_admin' => 'boolean',
  ];

  /**
   * Get the user's age.
   *
   * @return string
   */
  public function getAgeAttribute()
  {
    return $this->date_of_birth->diffInYears(now());
  }
}
