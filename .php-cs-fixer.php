<?php

declare(strict_types=1);

$finder = \PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

return (new \PhpCsFixer\Config())->setRiskyAllowed(true)
    ->setRules([
        '@PHP81Migration' => true,
        '@Symfony' => true,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
