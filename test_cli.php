<?php
echo "CLI OK @ ".date('c')."\n";
file_put_contents(__DIR__.'/cli_test.txt', "WROTE @ ".date('c')."\n", FILE_APPEND);
