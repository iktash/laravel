<?php

use App\Repositories\CurrenciesRepo;
use \Mockery as m;

class CurrenciesRepoTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testCreateIfNotExistsNotUnique()
    {
        $id = 5;

        $anotherModelMock = m::mock('App\Currencies');
        $anotherModelMock->shouldReceive('getAttribute')->with('id')->andReturn($id);

        $model = m::mock('App\Currencies');
        $model->shouldReceive('setAttribute');
        $model->shouldReceive('unique')->once()->andReturn(false);
        $model->shouldReceive('findAnotherByUniqueFields')
            ->once()->andReturn($anotherModelMock);

        $repo = new CurrenciesRepo($model);
        $resultId = $repo->createIfNotExists(1, 1);

        $this->assertEquals($id, $resultId);
    }

    public function testCreateIfNotExistsUnique()
    {
        $id = 5;

        $model = m::mock('App\Currencies');
        $model->shouldReceive('setAttribute');
        $model->shouldReceive('unique')->once()->andReturn(true);
        $model->shouldReceive('save')->once();
        $model->shouldReceive('getAttribute')->with('id')->andReturn($id);

        $repo = new CurrenciesRepo($model);
        $resultId = $repo->createIfNotExists(1, 1);

        $this->assertEquals($id, $resultId);
    }

    public function testCreateIfNotExistsFails()
    {
        $model = m::mock('App\Currencies');
        $model->shouldReceive('setAttribute');
        $model->shouldReceive('unique')->once()->andReturn(true);
        $model->shouldReceive('save')->once()->andThrow(new \Exception);
        $model->shouldReceive('getAttribute')->with('id')->never();

        \Log::shouldReceive('error')->once();

        $repo = new CurrenciesRepo($model);
        $result = $repo->createIfNotExists(1, 1);

        $this->assertFalse($result);
    }

    public function testGetCurrenciesStatistics()
    {
        $limit = 10;

        $model = m::mock('App\Currencies');
        $model->shouldReceive('has')->once()->with('messageNumbers')->andReturn($model);
        $model->shouldReceive('with')->once()->andReturn($model);
        $model->shouldReceive('take')->once()->with($limit)->andReturn($model);
        $model->shouldReceive('get')->once()->andReturn('foo');

        $repo = new CurrenciesRepo($model);
        $result = $repo->getCurrenciesStatistics($limit);

        $this->assertEquals('foo', $result);
    }
}
