<?php

namespace Database\Seeders;

use App\Models\Praktikan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([]);;

        $admin = User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@mail.io',
            'peran' => 'ADMIN',
        ]);

        $dev = User::factory()->create([
            'name' => 'dev',
            'username' => 'dev',
            'email' => 'dev@mail.io',
            'peran' => 'DEVELOPER',
        ]);

        $kepala_lab = User::factory()->create([
            'name' => 'kepala_lab',
            'username' => 'kepala_lab',
            'email' => 'kepala_lab@mail.io',
            'peran' => 'KEPALA_LAB_DAN_DOSEN',
        ]);

        for ($i = 0; $i < 5; $i++) {

            $asisten = User::factory()->create([
                'name' => 'asisten 0' . ($i + 1),
                'username' => 'asisten_0' . ($i + 1),
                'email' => 'asisten_0' . ($i + 1) . '@mail.io',
                'peran' => 'ASISTEN',
            ]);
        }

        for ($i = 0; $i < 5; $i++) {

            $praktikan = User::factory()->create([
                'name' => 'Praktikan 0' . ($i + 1),
                'username' => 'praktikan_0' . ($i + 1),
                'email' => 'praktikan_0' . ($i + 1) . '@mail.io',
                'peran' => 'PRAKTIKAN'
            ]);

            Praktikan::create([
                'user_id' => $praktikan->id,
                'kelas' =>  fake()->word(),
                'jurusan' => fake()->word(),
            ]);
        }
    }
}
