<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->exclude('var')
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'blank_line_before_statement' => [
            'statements' => ['return', 'throw', 'continue', 'break'],
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
        ],
        'no_unused_imports' => true,
        'single_quote' => true,
    ])
    ->setFinder($finder);
