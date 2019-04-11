<?php
/**
 * Created by PhpStorm.
 * User: hrach
 * Date: 4/11/19
 * Time: 14:16
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class UsersTeam extends Model
{
	use HasRoles;

	protected $guard_name = 'api';
}