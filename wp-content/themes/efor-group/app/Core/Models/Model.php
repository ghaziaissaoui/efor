<?php

namespace App\Core;

use WPQueryBuilder\Query;

class Model
{
    /**
     * @var Query
     */
    public $qb;

    public $table;

    public function __construct(string $table = 'posts')
    {
        global $wpdb;
        $this->table = $wpdb->prefix . $table;
        $this->qb = new Query($wpdb);
    }
}
