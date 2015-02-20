<?php

namespace App\Repositories;

use App\Currencies;

class CurrenciesRepo
{
    protected $model;

    public function __construct(Currencies $currencies)
    {
        $this->model = $currencies;
    }

    /**
     * Saves one record to currencies, but only if its unique
     * 
     * @param string $currencyFrom
     * @param string $currencyTo
     * 
     * @return int|false ID of the record or false if something's went wrong
     */
    public function createIfNotExists($currencyFrom, $currencyTo)
    {
        $this->model->from = $currencyFrom;
        $this->model->to = $currencyTo;
        
        if (!$this->model->unique()) {
            $another = $this->model->findAnotherByUniqueFields();

            return $another->id;
        }

        try {
            $this->model->save();
        } catch (\Exception $e) {
            \Log::error('Couldn\'t save Currencies: ' . $e->getMessage());

            return false;
        }

        return $this->model->id;        
    }

    /**
     * Returns currencies with country message numbers attached
     * 
     * @param int $limit Limit number of currencies records
     * 
     * @return EloquentCollection
     */
    public function getCurrenciesStatistics($limit = 50)
    {
        return $this->model
            ->has('messageNumbers')
            ->with(['messageNumbers' => function($query) {
                $query->orderBy('messages_number', 'desc');
            }])
            ->take($limit)
            ->get();
    }
}
