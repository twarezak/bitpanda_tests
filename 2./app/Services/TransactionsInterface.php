<?php
declare(strict_types=1);

namespace App\Services;

interface TransactionsInterface
{
    public function all(): array;
}
