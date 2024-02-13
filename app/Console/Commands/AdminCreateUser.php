<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AdminCreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-user {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an admin user for the application. Provide name and email as arguments';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Creating admin user...');

        $this->info('Checking if user exists...');
        $user = User::where([
            ['email', $this->argument('email')],
            ['admin', true],
        ])->first();

        if ($user != null) {
            $this->info(sprintf('Admin user with email %s already exists', $this->argument('email')));
            return;
        }

        $this->info(sprintf('Creating user %s (%s)...', $this->argument('name'), $this->argument('email')));
        $user = User::factory()->create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => Hash::make(openssl_random_pseudo_bytes(64)),
            'admin' => true
        ]);

        $this->info('Checking if Administrators team exists...');
        $team = Team::where([
            'name' => 'Administrators'
        ])->first();

        if ($team == null) {
            $this->info('No team found, creating team...');
            $team = Team::factory()->create([
                'name' => 'Administrators',
                'user_id' => $user->id,
                'personal_team' => false,
            ]);
        }

        $this->info('Adding user to team...');
        $team->users()->attach($user->id, ['role' => 'admin']);

        $user->switchTeam($team);

        $this->info('The new user can reset their password via the login form');
    }
}
