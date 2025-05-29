<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->notPath("ampforwp")
    ->notPath("resources/views")
;

return (new PhpCsFixer\Config())
  ->setFinder($finder);
