<?php

namespace App\Console\Commands;

use App\Models\MetalConvertablePrice;
use Illuminate\Console\Command;

class UpdateMetalPriceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metal:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update metal price';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = "https://www.metals-api.com/api/latest?access_key=t8fnolzcp7c7c6qllso4hn2c5fnd390emvz8yaxuw74es22a6d6s1d7fr18i&base=GBP&symbols=XAU,XAG";

        $data = json_decode(file_get_contents($url), true);

        foreach ($data['rates'] as $key => $value) {
            $insertData['metal_code'] = $key;
            $insertData['price']      = $value;

            MetalConvertablePrice::create($insertData);
        }
    }
}
