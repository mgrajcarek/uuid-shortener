<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@PSR1' => true,
        'blank_line_before_return' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__.DIRECTORY_SEPARATOR.'src')
            ->in(__DIR__.DIRECTORY_SEPARATOR.'tests')
    )
    ->setRiskyAllowed(true)
    ->setUsingCache(true);