<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Transactions;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','surname', 'country','company','mobile_number','date_of_birth','user_number', 'email', 'password', 'role_id', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
    public function transactions()
    {
        return $this->hasMany(Transactions::class);

    }
    public function upgrades()
    {
        return $this->hasMany(Upgrade::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($value)
        {
            $value->upgrades()->delete();

        });
    }

	public function canViewRoute($route, $method = 'GET', $mode = null)
	{
		$status = false;
		if(!$mode) $mode = $this->role->mode;
		$routes = explode("\n", $this->role->routes);

		foreach($routes as &$pattern)
		{
			$pattern = trim($pattern);
			if(empty($pattern)) continue;

			$status = preg_match('/'.$pattern.'/ix', $method.Role::METHOD_DELIM.$route);
			if($status) break;
		}

		if(($status && $mode == Role::LIST_MODE_WHITE) || (!$status && $mode == Role::LIST_MODE_BLACK)) return true;
		else return false;
	}
}
