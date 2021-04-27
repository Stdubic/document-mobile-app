<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	public const METHOD_DELIM = ':';
	public const LIST_MODE_WHITE = 1;
	public const LIST_MODE_BLACK = 2;

	protected $fillable = [
        'name', 'view_all', 'mode', 'routes',
	];

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
