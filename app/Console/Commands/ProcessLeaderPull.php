<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Console\Command;

class ProcessLeaderPull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leader-pull:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обработка лидерского пула';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::query()->get();

        $result = [];

        foreach ($users as $user)
        {
            $pull_list = $user->getLeaderPull();

            $current_pull = null;

            foreach ($pull_list as $pull)
            {
                if ($pull['status'] != 'completed')
                {
                    continue;
                }

                $current_pull = $pull;
            }

            if (is_null($current_pull))
            {
                continue;
            }

            $result[$user['id']] = $current_pull;
        }

        $pull_sum = 100000000;

        $transactions = [];

        foreach ($result as $key => $value)
        {
            $transactions[] = [
                'id' => \Str::uuid(),
                'user_id' => $key,
                'type' => 'leader_pull',
                'status' => 'completed',
                'amount' => $pull_sum * $value['percent'],
                'direction' => 'inner',
                'details' => json_encode([
                    'pull' => $value['pull'],
                    'percent' => $value['percent'],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Transaction::insert($transactions);
    }
}
