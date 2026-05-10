<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Support\RbacPermissions;

class SyncIntegrationLogoPermissions extends Migration
{
    public function up()
    {
        $catalog = RbacPermissions::all();
        $now = now();

        foreach ($catalog as $slug => $name) {
            $exists = DB::table('permissions')->where('slug', $slug)->first();
            if ($exists) {
                DB::table('permissions')->where('id', $exists->id)->update([
                    'name' => $name,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('permissions')->insert([
                    'name' => $name,
                    'slug' => $slug,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $superRole = DB::table('roles')->where('slug', 'super-admin')->first();
        if ($superRole) {
            $newSlugs = [
                'integrationlogo.view',
                'integrationlogo.create',
                'integrationlogo.update',
                'integrationlogo.delete',
                'integrationlogo.manage',
            ];
            $permissionIds = DB::table('permissions')
                ->whereIn('slug', $newSlugs)
                ->pluck('id')
                ->toArray();

            foreach ($permissionIds as $permissionId) {
                $exists = DB::table('role_permission')
                    ->where('role_id', $superRole->id)
                    ->where('permission_id', $permissionId)
                    ->first();
                if (!$exists) {
                    DB::table('role_permission')->insert([
                        'role_id' => $superRole->id,
                        'permission_id' => $permissionId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }

    public function down()
    {
        // Keep fixed permissions.
    }
}
