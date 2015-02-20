<?php

namespace App\Repositories;

use App\CountriesMessagesNumber;

class CountriesMessagesNumberRepo
{
    protected $model;

    public function __construct(CountriesMessagesNumber $number)
    {
        $this->model = $number;
    }

    /**
     * Saves one record if it doesn't exists
     * or increments 'messages_number' field otherwise
     * 
     * @param string $country
     * @param int $currenciesId
     * 
     * @return bool Whether a record has been saved or not
     */
    public function increment($country, $currenciesId)
    {
        $this->model->country = $country;
        $this->model->currencies_id = $currenciesId;
        $this->model->messages_number = 1;

        if (!$this->model->unique()) {
            $another = $this->model->findAnotherByUniqueFields();

            $another->messages_number++;

            try {
                $another->save();
            } catch (\Exception $e) {
                \Log::error('Couldn\'t increment counter: ' . $e->getMessage());

                return false;
            }

            return true;
        }

        try {
            $this->model->save();
        } catch (\Exception $e) {
            \Log::error('Couldn\'t save counter: ' . $e->getMessage());

            return false;
        }

        return true;
    }
}
