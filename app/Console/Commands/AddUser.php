<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-user {username?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Add a new user to the system';

    public function handle()
    {

        $username = $this->argument('username') ?? $this->ask('Enter username:');
        $email = $this->argument('email') ?? $this->ask('Enter email:');
        $password = $this->argument('password') ?? $this->secret('Enter password  (leave empty to generate a random password):') ??  Str::random(10);
        $generateKey = $this->choice('Generate API key?', ['No','Yes'],0,null, false);

        try {
            $user = User::create([
                'name' => $username,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            $this->info('User created successfully!');
            $this->info('username: '.$username);
            $this->info('password: '.$password);

            if ($generateKey) {
                $accessToken = $user->createToken('API token')->plainTextToken;
                $this->info('API token: '.$accessToken);
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }

    }
}

