<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BasicRolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // member role
		$memberRole = Role::create(['name' => 'member']);
		$memberPermission = Permission::create(['name' => 'view team members']);

		$memberRole->givePermissionTo($memberPermission);

		// owner role
	    $ownerRole = Role::create(['name' => 'owner']);
	    $ownerPermissions[] = Permission::create(['name' => 'create team']);
	    $ownerPermissions[] = Permission::create(['name' => 'edit team title']);
	    $ownerPermissions[] = Permission::create(['name' => 'delete team']);
	    $ownerPermissions[] = Permission::create(['name' => 'assign member to team']);
	    $ownerPermissions[] = $memberPermission;

	    $ownerRole->syncPermissions($ownerPermissions);

    }
}
