<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $records = $this->displayRecords(User::all());
        $this->table(['user id','name','email'], $records);
        $selectedRecordIndex = $this->ask('Select a record by entering its index or type -1 for exit:');
        if ($selectedRecordIndex == -1) exit();
        if (array_key_exists($selectedRecordIndex,$records)) {
            $selectedRecord = $records[$selectedRecordIndex];
            $this->info('You selected ['. $selectedRecordIndex .']:  user:'. $selectedRecord['name'].', email:'. $selectedRecord['email']);
            $menu = $this->choice('Do you really want to reset API key for record: ',['Yes','Cancel']);
            if ($menu == 'Cancel') {
                $this->handle();
            }
            if ($menu == 'Yes') {
                $singleUser = User::find($selectedRecordIndex);
                PersonalAccessToken::where('tokenable_id','=',$selectedRecordIndex)->delete();
                $accessToken = $singleUser->createToken('API token')->plainTextToken;
                $this->info('User:'.$selectedRecord['name'].', API token:'.$accessToken);
                $option = $this->choice('Edit new record or exit: ',['New','Exit']);
                if ($option == 'New') $this->handle();
                exit();
            }
        } else {
            $this->error('Invalid selection.');
        }

    }

    private function displayRecords($records)
    {
        $final = [];
        foreach ($records as  $record) {
            $data = $record->toArray();
            $final[$data['id']] = [
                'id'=>$data['id'],
                'name'=>$data['name'],
                'email'=>$data['email'],
            ];
        }
        return $final;
    }
}
