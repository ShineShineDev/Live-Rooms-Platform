<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateLiveAndHotRandomly extends Command
{
    protected $signature = 'update:live-hot';
    protected $description = 'Randomly update is_live and is_hot for matches';

    public function handle()
    {

        $matches = DB::table('rooms')->get();

        foreach ($matches as $match) {
            $isLive = (bool) rand(0, 1);
            $isHot = (bool) rand(0, 1);

            DB::table('rooms')
                ->where('id', $match->id)
                ->update([
                    'is_live' => $isLive,
                    'is_hot' => $isHot,
                ]);

            $this->info("Updated match ID {$match->id} => is_live: {$isLive}, is_hot: {$isHot}");
        }

        $this->info("All matches updated successfully.");
    }
}
