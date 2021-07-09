<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\UnsupportedSourceTypeException;
use App\Services\TransactionsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function list(TransactionsService $transactionsService): Response
    {
        try {
            $transactionsService->determinateSource(request()->get('source'));
        } catch (UnsupportedSourceTypeException $e) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Unsupported source');
        }

        return response(['data' => $transactionsService->getAllTransactions()]);
    }
}
