<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role::create(['name' => 'quan-ly', 'guard_name' => 'web']);
        // Role::create(['name' => 'giao-vien', 'guard_name' => 'web']);

        $manager = User::find(62);

        if ($manager) {
            $manager->assignRole('quan-ly');
        }

        // $teachers = User::where('id', '!=', 2)->get();
        // foreach ($teachers as $teacher) {
        //     $teacher->assignRole('giao-vien');
        // }
    }
}
