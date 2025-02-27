<?php

// Include Composer's autoload file to autoload Symfony components
require 'vendor/autoload.php';

// Use the LoggerInterface to log messages
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;

// Create a basic service container
$container = new ContainerBuilder();

// Set up a logger service (using Monolog)
$container->register('logger', \Monolog\Logger::class)
    ->addArgument('app') // Channel name (app)
    ->addArgument([new \Monolog\Handler\StreamHandler('var/log/test.log', \Monolog\Logger::DEBUG)]);

// Fetch the logger service
$logger = $container->get('logger');

// Write a log message
$logger->info('Test message: This is a log message from the custom PHP script!');

// Log a warning message
$logger->warning('This is a warning log!');

// Log an error message
$logger->error('This is an error message!');

// Output message to show the log is being written
echo "Log messages have been written. Check the ";