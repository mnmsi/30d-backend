<?php

namespace App\Http\Controllers;

use App\Repositories\Converter\ConverterRepositoryInterface;
use App\Repositories\MetalPrice\MetalPriceRepositoryInterface;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;

class MetalPriceConverterController extends Controller
{
    /**
     * @var ConverterRepositoryInterface
     */
    private $converter;
    /**
     * @var MetalPriceRepositoryInterface
     */
    private $metalConvert;

    public function __construct(
        ConverterRepositoryInterface $converterRepository,
        MetalPriceRepositoryInterface $metalPriceRepository
    )
    {
        $this->converter = $converterRepository;
        $this->metalConvert = $metalPriceRepository;
    }

    public function saveMetalCurrentPriceIntoDB()
    {
        $metalPrice = $this->converter->metalPriceGetFromApi();
        $result = '';
        try {
            foreach ($metalPrice->rates as $key => $item) {
                $result = $this->metalConvert->metalPriceInsertIntoDb($key, $item);
            }
            if (!empty($result)) {
                return ['status' => 1, 'message' => 'Data has updated successfully'];
            }
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => 'Something went wrong', 'with' => $e];
        }
    }
}
