<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountriesMessagesNumber extends Model implements Sanitizible, UniqueInterface {

    protected $table = 'countries_messages_number';

    public $timestamps = false;

    protected $hidden = ['id', 'currencies_id'];

    public static $validationRules = [
        'country' => 'required|size:2',
        'currencies_id' => 'required|exists:currencies,id'
    ];

    public function currencies()
    {
        return $this->belongsTo('App\Currencies', 'currencies_id', 'id');
    }

    /**
     * Makes sure that all fields are compatible
     * 
     * @return void
     */
    public function sanitize()
    {
        $this->country = strtoupper($this->country);
    }

    public function save(array $options = array())
    {
        $this->sanitize();

        $v = \Validator::make($this->getAttributes(), static::$validationRules);

        if ($v->fails()) {
            throw new \Exception('Invalid data provided for model CountriesMessagesNumber');
        }

        parent::save($options);
    }

    /**
     * Checks if model's fields are unique
     * 
     * @return bool
     */
    public function unique()
    {
        $another = $this->findAnotherByUniqueFields();

        if ($another) {
            return false;
        }

        return true;
    }

    /**
     * Gets a model with the same unique fields
     * 
     * @return Model|null
     */
    public function findAnotherByUniqueFields()
    {
        $this->sanitize();

        return $this
            ->where('country', $this->country)
            ->where('currencies_id', $this->currencies_id)
            ->first();
    }
}
