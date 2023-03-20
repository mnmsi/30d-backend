<?php


namespace App\Repositories\Calculation;


use App\Repositories\BasicRepository;
use App\Repositories\MetalPrice\MetalPriceRepositoryInterface;

class CalculationRepository extends BasicRepository implements CalculationRepositoryInterface
{
    /**
     * @var MetalPriceRepositoryInterface
     */
    private $metalPrice;

    public function __construct(MetalPriceRepositoryInterface $metalPriceRepository)
    {
        $this->metalPrice = $metalPriceRepository;
    }

    public function neshabZakatAmount()
    {
        $gold = '';
        $silver = '';
        // get all metal price
        $allMeatlPrices = $this->metalPrice->getAllMetalPriceFromDB();
        foreach ($allMeatlPrices as $item) {
            if ($item->metal_code == 'XAU') {
                $gold = $item->price;
            }
            if ($item->metal_code == 'XAG') {
                $silver = $item->price;
            }
        }
        // price convert into OUNCE to GRAM
        $goldInGram = (87.48 / 28.3495);
        $nishabGold = $goldInGram * $gold; /// min 87.84 gram of gold
        $silverInGream = (612.36 / 28.3495);
        $nishabSilver = ($silverInGream * $silver); // min 612.36 gram of silver

        return ['silver_nishab' => $nishabSilver, 'gold_nishab' => $nishabGold]; // return total amount of nishab
    }

    public function allCalculationForZakat($data, $neshab)
    {
        //// for pension
        if (empty($data['pension'])) {
            if (isset($data['pension_unknown']))
                $pension = $this->pensionCalculation($data['pension_unknown']);
        } else {
            $pension = $data['pension'] ?? 0;
        }
        /// trust fund
        if (isset($data['trust'])) {
            $trustCovert = $this->TwentyFivePercentOfMainAmount($data['trust']['stock']);
            $totallTrust = $trustCovert + $data['trust']['others'];
        }

        /// share
        if (isset($data['share'])) {
            $covertedTrust = $this->TwentyFivePercentOfMainAmount($data['share']['other']);
            $totallShare = $covertedTrust + $data['share']['capital'];
        }


        if (empty($data['gold_money'])) {
            $gold = $this->convertMetalPriceGramToOunce($data['gold_gram'], 'XAU');
        } else {
            $gold = $data['gold_money'] ?? 0;
        }

        if (empty($data['silver_money'])) {
            $silver = $this->convertMetalPriceGramToOunce($data['silver_gram'], 'XAG');
        } else {
            $silver = $data['silver_money'] ?? 0;
        }

        $cash = $data['cash'] ?? 0;
        $owe = $data['owe_to_me'] ?? 0;
        $business = $data['business'] ?? 0;
        $crypto = $data['crypto'] ?? 0;
        $metal = $gold + $silver;
        $finalAdditionalOutput = $this->totalAdditionMoney($cash, $owe, $metal, $totallShare ?? 0, $pension ?? 0, $crypto, $business, $totallTrust ?? 0);
        $oweT = $data['owe'] ?? 0;
        $out = $finalAdditionalOutput - $oweT;
        $finalResult = $out >= 0 ? $out : 0;

        if ($finalResult > $neshab)
        {
            $finalZakat = $finalResult * .025;
        }
        else{
            $finalZakat = 0;
        }

        return [
            'add' => round($finalAdditionalOutput, 2),
            'minus' => $oweT,
            'equal' => round($finalResult, 2),
            'final_zakat' => round($finalZakat, 2)
        ];
    }

    public function totalAdditionMoney($cash = 0, $owed_to_me = 0, $metal = 0, $share = 0, $pension = 0, $crypto = 0, $business = 0, $trust = 0)
    {
        return ($cash + $owed_to_me + $metal + $share + $pension + $crypto + $business + $trust);
    }

    public function pensionCalculation($data)
    {
        foreach ($data as $key => $item) {
            if ($key == 'bond') {
                $value = $item;
            }
            if ($key == 'shares') {
                $value = ($item * 0.27);
            }
            if ($key == 'real_estate') {
                $value = ($item * 0.15);
            }
            if ($key == 'mix') {
                $value = ($item * 0.5);
            }
            if ($key == 'sharia') {
                $value = ($item * 0.26);
            }
        }
        return $value;
    }

    public function TwentyFivePercentOfMainAmount($data)
    {
        return ($data * .25);
    }

    public function convertMetalPriceGramToOunce($amount, $name)
    {
        $value = $this->metalPrice->getMetalPriceInOunce($name);
        $gramToOunce = $amount / 28.3495;
        return ($gramToOunce * $value->price);
    }
}
