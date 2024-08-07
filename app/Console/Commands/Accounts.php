<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Device;
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
        $accounts = Account::get();        
        $this->table(
            ['id', 'username', 'plan_id', 'started_at', 'finished_at', 'active'], 
            $accounts->toArray()
        );

        $devices = Device::orderBy('account_id')->get();
        $this->table(
            [],
            $devices->toArray()
        );

        $filtered = $accounts->filter(function(Account $account){
            return $account->number_devices == 0;
        });

        // $filtered = $accounts->reject(function(Account $account){
        //     return $account->devices->count() == 0;
        // });
        $this->line($filtered->filter());
        // $this->table(
        //     ['id', 'username', 'plan_id'], 
        //     $filtered->toArray()
        // );

    }
}
