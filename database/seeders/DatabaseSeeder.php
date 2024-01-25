<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SaleSeeder::class);
        $this->call(SellerSeeder::class);
        User::factory()->create([
            'name' => 'Admin',
            'is_admin' => true,
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
    }
}
