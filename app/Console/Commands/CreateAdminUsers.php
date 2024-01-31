<?php

namespace App\Console\Commands;

use App\Models\Team;
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
        $this->info('Fetching Administrator team...');
        $team = Team::where('name', 'Administrators')->first();

        $this->info('Fetching Administrator users...');
        $davidDocampo = User::where([
            ['email', 'david@docampo.ch'],
            ['admin', true],
        ])->first();

        $this->info('Checking if Administrator users exist...');
        if ($davidDocampo == null) {
            $name = 'David Docampo';
            $email = 'david@docampo.ch';

            $this->info(sprintf('Creating user for %s (%s)...', $name, $email));
            $davidDocampo = User::factory()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(openssl_random_pseudo_bytes(64)),
                'admin' => true
            ]);
        }

        $this->info('Checking if Administrator team exists...');
        if ($team == null) {
            $name = 'Administrators';

            $this->info(sprintf('Creating %s team...', $name));
            $team = Team::factory()->create([
                'name' => $name,
                'user_id' => $davidDocampo->id,
                'personal_team' => false
            ]);
        }

        $this->info('Adding users to team...');
        $team->users()->attach($davidDocampo->id, ['role' => 'admin']);

        $davidDocampo->switchTeam($team);

        $this->info('New users can reset their password via the login form');
    }
}
