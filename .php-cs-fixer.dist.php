<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/src', __DIR__.'/tests']);

return (new PhpCsFixer\Config())->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP71Migration' => true,
        '@PHP71Migration:risky' => true,
        '@PHPUnit60Migration:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'global_namespace_import' => ['import_functions' => true],
        'method_chaining_indentation' => true,
        'no_useless_else' => true,
        'ordered_imports' => ['imports_order' => ['class', 'function', 'const']],
        'php_unit_test_annotation' => true,
        'php_unit_mock' => true,
        'php_unit_method_casing' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
