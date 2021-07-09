<?php declare(strict_types=1);


namespace App\Services;


use App\Models\Transaction;

class DBSource implements TransactionsInterface
{
    public function all(): array
    {
        return Transaction::all()->toArray();
    }
}
