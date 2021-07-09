<?php declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UnsupportedSourceTypeException;

class TransactionsService
{
    const SOURCE_DB = 'db';
    const SOURCE_CSV = 'csv';

    private TransactionsInterface $source;

    public function determinateSource(string $source): void
    {
        switch ($source){
            case self::SOURCE_CSV:
                $source = new CSVSource();
                break;
            case self::SOURCE_DB:
                $source = new DBSource();
                break;
            default:
                throw new UnsupportedSourceTypeException();
        }

        $this->source = $source;
    }

    public function getAllTransactions(): array
    {
        return $this->source->all();
    }
}
