<?php


namespace App\Repositories\PaymentHistory;


use Illuminate\Database\Eloquent\Model;

class PaymentHistoryRepository extends \App\Repositories\BasicRepository implements PaymentHistoryRepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    public function testController()
    {
        return $this->model->where('status', 'paid')->paginate(15);
    }
    public function createPayment($data)
    {
        $value = $this->model;
        $value['first_name'] = $data['first_name'];
        $value['last_name'] = $data['last_name'];
        $value['email'] = $data['email'];
        $value['zakat'] = $data['zakat'];
        $value['sadaqah'] = $data['sadaqah'];
        $value['status'] = $data['status'];
        $value['riba'] = $data['riba'];
        $value->save();
        $result = $value;
        return $result;
    }
    public function totalPaymentCount()
    {
        $count = $this->model->where('status', 'paid')->get()->count();
        return $count;
    }
    public function searchData($name)
    {
        $result = $this->model->where('status', 'paid')
            ->where('email', 'LIKE', "%$name%")
            ->orWhere('first_name', 'LIKE', "%$name%")
            ->paginate(15);
        return $result;
    }
    public function updateStatus($Ok)
    {
        $data = $this->model->find($Ok['id']);
        $data['status'] = $Ok['status'];
        $data->save();
        return $data;
    }

    public function getSingleStatus($id)
    {
        return $this->model->find($id);
    }
}
