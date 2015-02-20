<?php

namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use App\Repositories\CurrenciesRepo;
use App\Repositories\CountriesMessagesNumberRepo;

class ProcessMessage extends Command implements SelfHandling, ShouldBeQueued {

    use InteractsWithQueue, SerializesModels;

    protected $currencyFrom;
    protected $currencyTo;
    protected $country;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($currencyFrom, $currencyTo, $country)
    {
        $this->currencyFrom = $currencyFrom;
        $this->currencyTo = $currencyTo;
        $this->country = $country;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(
        CurrenciesRepo $curRepo,
        CountriesMessagesNumberRepo $numberRepo
    ) {
        $curId = $curRepo->createIfNotExists(
            $this->currencyFrom,
            $this->currencyTo
        );

        if (!$curId) {
            return;
        }

        $result = $numberRepo->increment($this->country, $curId);

        if ($result) {
            \Log::info('new message is processed');
        }
    }

}
