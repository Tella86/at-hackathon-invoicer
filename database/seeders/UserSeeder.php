<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create a demo user you can log in with
        User::firstOrCreate(
            ['email' => 'demo@app.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );
    }
}
