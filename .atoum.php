<?php

$script->addTestsFromDirectory(__DIR__ . '/tests/Units');
$script->excludeDirectoriesFromCoverage([__DIR__ . '/vendor/']);
