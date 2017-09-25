<?php

require 'bootstrap/app.php';

while (!sleep(config('app.reindex.interval'))) {
    App\Models\Search::reindex();
}
