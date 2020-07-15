<?php

$h = fopen('https://coronavirus.data.gov.uk/downloads/csv/coronavirus-deaths_latest.csv', 'r');

$csv = fgetcsv($h);
var_dump($csv);