<?php

require 'bootstrap/app.php';

$i = 0;

do {
    $i += 1;
    echo 'Reindexing';
    [$n, $d] = App\Models\Search::reindex(function () {
        echo '.';
    });
    echo " DONE, $n upserted, $d deleted. ($i)\n";
} while (!sleep(config('app.reindex.interval')));
