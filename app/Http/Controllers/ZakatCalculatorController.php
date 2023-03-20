<?php

namespace App\Http\Controllers;

use App\Repositories\Calculation\CalculationRepositoryInterface;
use App\Repositories\Converter\ConverterRepository;
use App\Repositories\Converter\ConverterRepositoryInterface;
use App\Repositories\Zakat\ZakatRepositoryInterface;
use Illuminate\Http\Request;

class ZakatCalculatorController extends Controller
{

    /**
     * @var ZakatRepositoryInterface
     */
    private $zakatRepository;
    /**
     * @var ConverterRepositoryInterface
     */
    private $convertRepository;
    /**
     * @var CalculationRepositoryInterface
     */
    private $calculationRepository;

    public function __construct(
        ZakatRepositoryInterface $zakatRespository,
        ConverterRepositoryInterface $converterRepository,
        CalculationRepositoryInterface $calculationRepository
    )

    {
        $this->zakatRepository = $zakatRespository;
        $this->convertRepository = $converterRepository;
        $this->calculationRepository = $calculationRepository;
    }

    public function zakatCalculation(Request $request)
    {
        // pension calculation with condition $data
        $neshab = $this->calculationRepository->neshabZakatAmount();
        $allCalculation = $this->calculationRepository->allCalculationForZakat($request->data,$neshab['silver_nishab']);

        return [
            'status'=>1,
            'calculation'=>$allCalculation,
            'total_neshab'=>$neshab,
            'currency_based'=>'GBP'
        ];
    }

}
