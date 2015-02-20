<?php

use App\Commands\ProcessMessage;
use \Mockery as m;

class ProcessMessageTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testHandleFails()
    {
        $curRepo = m::mock('App\Repositories\CurrenciesRepo');
        $curRepo->shouldReceive('createIfNotExists')->once()->andReturn(false);

        $numberRepo = m::mock('App\Repositories\CountriesMessagesNumberRepo');
        $numberRepo->shouldReceive('increment')->never();

        $command = new ProcessMessage(1, 1, 1);
        $command->handle($curRepo, $numberRepo);
    }

    public function testHandle()
    {
        $currencyFrom = 'USD';
        $currencyTo = 'EUR';
        $country = 'FR';
        $currencyId = 5;

        $curRepo = m::mock('App\Repositories\CurrenciesRepo');
        $curRepo
            ->shouldReceive('createIfNotExists')
            ->once()
            ->with($currencyFrom, $currencyTo)
            ->andReturn($currencyId);

        $numberRepo = m::mock('App\Repositories\CountriesMessagesNumberRepo');
        $numberRepo
            ->shouldReceive('increment')
            ->once()
            ->with($country, $currencyId)
            ->andReturn(true);

        \Log::shouldReceive('info')->once();

        $command = new ProcessMessage($currencyFrom, $currencyTo, $country);
        $command->handle($curRepo, $numberRepo);
    }
}
