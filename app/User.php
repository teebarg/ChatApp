<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','remember_token', 'fname', 'lname', 'mobile', 'state_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'fname' => 'John',
        'lname' => 'Doe',
    ];

    /**
     * The model's default rules.
     *
     * @var array
     */
    public static $rules=[
        'username' => 'required|min:5|unique:users',
        'email'=>'required|email|unique:users',
        'password' => 'required|min:6',
        'fname' => '',
        'lname' => '',
        'mobile' => 'nullable|unique:users'
    ];

    /**
     * The model's default update rules.
     *
     * @var array
     */

    public function updateRules()
    {
        return [
            'username' => 'sometimes|required|min:5|unique:users,username,'.$this->id,
            'email'=>'sometimes|required|email|unique:users,email,'.$this->id,
            'password' => 'sometimes|required|min:6',
            'fname' => '',
            'lname' => '',
            'mobile' => 'nullable|unique:users,mobile,'.$this->id
        ];
    }

    /**
     * Relationship between user and state
     */
    public function state(){
        return $this->hasOne(State::class);
    }

    /**
     * Relationship between user and image
     */
    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Relationship between user and conversation
     */
    public function conversations(){
        return $this->hasMany(Conversation::class);
    }

    /**
     * Relationship between user and message
     */
    public function messages(){
        return $this->hasMany(Message::class);
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
