<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentHistory\PaymentHistoryRequest;
use App\Models\PaymentHistory;
use App\Repositories\PaymentHistory\PaymentHistoryRepositoryInterface;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{

    /**
     * @var PaymentHistoryRepositoryInterface
     */
    private $model;

    public function __construct(PaymentHistoryRepositoryInterface $paymentHistoryRepository)
    {
        $this->model = $paymentHistoryRepository;
    }

    public function index()
    {
        $data = $this->model->testController();
        return view('PaymentHistory.index', ['data' => $data]);
    }


    public function insert(PaymentHistoryRequest $request)
    {

        try {
            $data = $request->only('first_name', 'last_name', 'email', 'zakat', 'sadaqah', 'riba');
            $result = $this->model->createPayment($data);
            return ['status' => 1, 'data' => 'Payment successfully done.'];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => 'something went wrong try again letter'];
        }
    }


    public function search(Request $request)
    {
        $data = $this->model->searchData($request->search);
        return view('PaymentHistory.index', ['data' => $data]);
    }
}
