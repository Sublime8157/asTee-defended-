<?php

namespace App\Console\Commands;

use App\Models\adminLogin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

/**
 * Create an admin account from the console.
 *
 * Replaces the self-service web registration at /regsiterAccount +
 * /submitRegistration, which was unauthenticated. Combined with the unsigned
 * /verifyAdmin/{email} route, anyone could create an admin account and mark it
 * verified in two requests.
 *
 * Console-only creation means an attacker needs shell access on the server,
 * at which point the admin panel is no longer the weakest link.
 */
class MakeAdmin extends Command
{
    protected $signature = 'astee:make-admin
                            {--email= : Email address for the new admin}
                            {--username= : Login username}
                            {--fname= : First name}
                            {--lname= : Last name}';

    protected $description = 'Create a verified admin account';

    public function handle(): int
    {
        $email = $this->option('email') ?: $this->ask('Email address');
        $username = $this->option('username') ?: $this->ask('Username');
        $fname = $this->option('fname') ?: $this->ask('First name');
        $lname = $this->option('lname') ?: $this->ask('Last name');
        $password = $this->secret('Password (input hidden)');

        $validator = Validator::make(compact('email', 'username', 'fname', 'lname', 'password'), [
            'email' => ['required', 'email', Rule::unique('admin_login', 'email')],
            'username' => ['required', 'string', 'max:255', Rule::unique('admin_login', 'username')],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'password' => ['required', Password::min(12)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        // mname and age are NOT NULL with no default in admin_login, but nothing
        // in the admin panel ever reads them — they are copied from the customer
        // table's shape. Filled with empties rather than prompted for. Making
        // them nullable belongs to the Phase 3 migration set, and would not help
        // an existing production database anyway.
        adminLogin::create([
            'fname' => $fname,
            'mname' => '',
            'lname' => $lname,
            'age' => 0,
            'email' => $email,
            'username' => $username,
            'password' => Hash::make($password),
            'profie' => 'adminIcon.jpg',
            'email_verified_at' => now(),
        ]);

        $this->info("Admin account created for {$email}.");
        $this->line('Sign in at /loginAdmin');

        return self::SUCCESS;
    }
}
