<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    protected $signature = 'intok:admin:create {email?}';
    protected $description = 'Create or update an INTOK administrator account';

    public function handle(): int
    {
        $email = (string) ($this->argument('email') ?: $this->ask('Admin email'));
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->components->error('Please provide a valid email address.');
            return self::FAILURE;
        }
        $name = (string) $this->ask('Admin name');
        $password = (string) $this->secret('Password (minimum 12 characters)');
        if (mb_strlen($password) < 12) {
            $this->components->error('Password must contain at least 12 characters.');
            return self::FAILURE;
        }

        $adminRole = Role::findOrCreate('Admin', 'web');
        $user = User::query()->updateOrCreate(['email' => $email], ['name' => $name, 'password' => Hash::make($password)]);
        $user->syncRoles([$adminRole]);
        $this->components->info('Administrator account is ready.');
        return self::SUCCESS;
    }
}
