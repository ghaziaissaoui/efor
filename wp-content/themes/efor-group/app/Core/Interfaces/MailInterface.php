<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

interface MailInterface
{
    public function init(string $to, string $subject, string $from_name = '', string $from = ''): self;
    public function setBody(string $content): self;
    public function send(): bool;
}
