<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vost4crowd:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vost4Crowd Installation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data['name'] = $this->ask('Name ? ');
        $data['email'] = $this->ask('Email ? ');
        $data['password'] = $this->secret('Password ? ');
        $data['password_confirmation'] = $this->secret('Password (confirm) ? ');


        $validator = Validator::make($data, [
            'name' => ['required', 'min:2'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        if ($validator->fails()) {
            $this->info('User not created. See error messages below : ');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        if ($this->confirm('Are you sure ?')) {

            try{
                User::create($data);
            }catch (\Throwable $t){
                $this->error($t->getMessage());
                return 1;
            }
        }

        $this->info('User account created.');

        return 0;
    }
}
