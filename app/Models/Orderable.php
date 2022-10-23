<?php

namespace App\Models;

interface Orderable
{
    public function getOrderColumnName(): string;
}
