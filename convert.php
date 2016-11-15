#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use TomasFejfar\Json2Trados\Command\ToTrados;

$application = new Application();
$application->add(new ToTrados());
$application->run();
