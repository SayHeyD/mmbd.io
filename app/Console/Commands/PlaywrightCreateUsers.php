<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\UniqueConstraintViolationException;

class PlaywrightCreateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playwright:create-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create users to test out the password reset with playwright';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating users for playwright tests');

        $emails = [
            'david+webkit@docampo.ch',
            'david+firefox@docampo.ch',
            'david+chromium@docampo.ch'
        ];

        foreach ($emails as $email) {

            try {
                User::factory()->create([
                    'email' => $email
                ]);
                $this->info(sprintf('User %s created...', $email));
            } catch (UniqueConstraintViolationException $e) {
                $this->info(sprintf('User %s already exists, skipping...', $email));
            }
        }

        $this->info('Users created...');
    }
}
