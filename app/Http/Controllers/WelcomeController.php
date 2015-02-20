<?php

namespace App\Http\Controllers;

use App\Repositories\CurrenciesRepo;

class WelcomeController extends Controller
{
    protected $curRepo;

    public function __construct(CurrenciesRepo $curRepo)
    {
        $this->curRepo = $curRepo;
    }

    /**
     * Show the messages statistics
     *
     * @return Response
     */
    public function index()
    {
        $currencies = $this->curRepo->getCurrenciesStatistics();

        return view('welcome')->with('currencies', $currencies);
    }
}
