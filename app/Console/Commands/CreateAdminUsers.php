<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-admin-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::factory()->create([
            'name' => 'David Docampo',
            'email' => 'david@docampo.ch',
            'password' => Hash::make(openssl_random_pseudo_bytes(64)),
            'admin' => true
        ]);
    }
}
