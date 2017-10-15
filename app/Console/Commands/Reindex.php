<?php

namespace App\Console\Commands;

use App\Models\Search;
use Illuminate\Console\Command;

class Reindex extends Command
{
    protected $signature = 'reindex';
    protected $description = 'Push items to Algolia index and remove deleted ones';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $done = 0;
        $this->info('Reindexing to Algolia (' . config('algolia.index') . ')');
        [$n, $d] = Search::reindex(function ($chunk, $total) use (&$done) {
            $done += $chunk;
            $l = strlen("$total");
            $dones = sprintf("%$l.d", $done);
            $chunk = sprintf('%3.d', $chunk);
            $this->info("Processing $chunk... [ $dones / $total ]");
        });
        $this->info("DONE: $n upserted, $d deleted.");
    }
}
