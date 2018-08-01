<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use App\Http\Controllers\HomeController;

class ExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'exchange:command';
       protected $signature ='';
    /**
     * The console command description.
     *
     * @var string
     */
     // protected $description = 'Get Currency Exchange Rate From Api';
        protected $description = '';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       // $homeController =new HomeController();
       // $homeController->getCurrencyExchangeRates();
//        return redirect('currency/get-exchange-rate');
//        $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
