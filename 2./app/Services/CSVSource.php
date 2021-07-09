<?php declare(strict_types=1);


namespace App\Services;

class CSVSource implements TransactionsInterface
{

    private string $source = 'transactions.csv';

    public function all(): array
    {
        $csv = \array_map('str_getcsv', file(base_path($this->source)));
        $transactions = [];
        $header = null;

        foreach ($csv as $row) {
            if (\is_null($header)) {
                $header = $row;
            } else {
                $transaction = \array_combine($header, $row);

                $transaction['id'] = (int)$transaction['id'];
                $transaction['user_id'] = (int)$transaction['user_id'];

                $transactions[] = $transaction;
            }
        }

        return $transactions;
    }
}
