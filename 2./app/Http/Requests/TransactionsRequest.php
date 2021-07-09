<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionsRequest extends FormRequest
{
    private function getSourceTypes(): array
    {
        return [
            'db',
            'csv',
        ];
    }

    public function rules(): array
    {
        return [
            'source' => 'required|string|in:' . \implode(',', self::getSourceTypes()),
        ];
    }
}
