<?php

use App\Repositories\CountriesMessagesNumberRepo;
use \Mockery as m;

class CountriesMessagesNumberRepoTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testIncrementUnique()
    {
        $anotherModelMock = m::mock('App\CountriesMessagesNumber');
        $anotherModelMock
            ->shouldReceive('getAttribute')
            ->with('messages_number');
        $anotherModelMock->shouldReceive('setAttribute');
        $anotherModelMock->shouldReceive('save');

        $model = m::mock('App\CountriesMessagesNumber');
        $model->shouldReceive('setAttribute');
        $model->shouldReceive('unique')->once()->andReturn(false);
        $model->shouldReceive('findAnotherByUniqueFields')
            ->once()->andReturn($anotherModelMock);

        $repo = new CountriesMessagesNumberRepo($model);
        $result = $repo->increment(1, 1);

        $this->assertTrue($result);
    }

    public function testIncrementUniqueFails()
    {
        $anotherModelMock = m::mock('App\CountriesMessagesNumber');
        $anotherModelMock
            ->shouldReceive('getAttribute')
            ->with('messages_number');
        $anotherModelMock->shouldReceive('setAttribute');
        $anotherModelMock->shouldReceive('save')->andThrow(new \Exception);

        $model = m::mock('App\CountriesMessagesNumber');
        $model->shouldReceive('setAttribute');
        $model->shouldReceive('unique')->once()->andReturn(false);
        $model->shouldReceive('findAnotherByUniqueFields')
            ->once()->andReturn($anotherModelMock);

        \Log::shouldReceive('error')->once();

        $repo = new CountriesMessagesNumberRepo($model);
        $result = $repo->increment(1, 1);

        $this->assertFalse($result);
    }

    public function testIncrementNotUnique()
    {
        $model = m::mock('App\CountriesMessagesNumber');
        $model->shouldReceive('setAttribute');
        $model->shouldReceive('unique')->once()->andReturn(true);
        $model->shouldReceive('save')->once();

        $repo = new CountriesMessagesNumberRepo($model);
        $result = $repo->increment(1, 1);

        $this->assertTrue($result);
    }

    public function testIncrementNotUniqueFails()
    {
        $model = m::mock('App\CountriesMessagesNumber');
        $model->shouldReceive('setAttribute');
        $model->shouldReceive('unique')->once()->andReturn(true);
        $model->shouldReceive('save')->once()->andThrow(new \Exception);

        \Log::shouldReceive('error')->once();

        $repo = new CountriesMessagesNumberRepo($model);
        $result = $repo->increment(1, 1);

        $this->assertFalse($result);
    }
}
