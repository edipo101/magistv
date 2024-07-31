<?php

namespace App\Console\Commands;

use App\Models\Account;
use Illuminate\Console\Command;

class Accounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->newLine();
        $this->line('Lista de cuentas');
        $this->newLine();
        $this->table(
            ['id', 'username', 'plan_id'], 
            Account::all()->toArray()
        );

    }
}
