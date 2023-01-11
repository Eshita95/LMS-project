<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Course;
use App\Models\Curriculam;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $defaultPermission = ['lead-management', 'create-admin', 'user-management'];
        foreach ($defaultPermission as $permission) {
            Permission::create(['name' => $permission]);
        }

        $this->create_user_with_role('Super Admin', 'Super Admin', 'super-admin@lms.test');
        $this->create_user_with_role('Communication', 'Communication Team', 'communication@lms.test');
        $teacher = $this->create_user_with_role('Teacher', 'Teacher', 'teacher@lms.test');
        $this->create_user_with_role('Leads', 'Leads', 'leads@lms.test');



        // create leads
        Lead::factory()->count(100)->create();

        // course create
        $course = Course::create([
            'name' => 'Laravel',
            'description' => 'Laravel is an open-source PHP framework, which is robust and easy to understand. It follows a model-view-controller design pattern.',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png',
            'user_id' => $teacher->id,
            'price' => 500
        ]);

        Curriculam::factory()->count(10)->create();
    }

    private function create_user_with_role($type, $name, $email)
    {
        $role = Role::create([
            'name' => $type
        ]);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt('password')
        ]);

        if ($type == 'Super Admin') {
            $role->givePermissionTo(Permission::all());
        } elseif ($type == 'Leads') {
            $role->givePermissionTo('lead-management');
        }

        $user->assignRole($role);

        return $user;
    }
}
