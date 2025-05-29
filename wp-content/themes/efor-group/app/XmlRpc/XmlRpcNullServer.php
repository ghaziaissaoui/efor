<?php

declare(strict_types=1);

namespace App\XmlRpc;

class XmlRpcNullServer
{
    public function serve_request(): void // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        header('HTTP/1.0 403 Forbidden');
        echo "You don't have permission to access this resource.";
        exit;
    }
}
