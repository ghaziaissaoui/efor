<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/resources/views')
;

return (new PhpCsFixer\Config())
  ->setIndent("  ")
  ->setFinder($finder);
