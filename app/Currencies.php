<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model implements Sanitizible, UniqueInterface {

    protected $table = 'currencies';

    public $timestamps = false;

    protected $hidden = ['id'];

    public static $validationRules = [
        'from' => 'required|size:3|different:to',
        'to' => 'required|size:3|different:from'
    ];

    public function messageNumbers()
    {
        return $this->hasMany('App\CountriesMessagesNumber', 'currencies_id', 'id');
    }

    /**
     * Makes sure that all fields are compatible
     * 
     * @return void
     */
    public function sanitize()
    {
        $this->from = strtoupper($this->from);
        $this->to = strtoupper($this->to);
    }

    public function save(array $options = array())
    {
        $this->sanitize();

        $v = \Validator::make($this->getAttributes(), static::$validationRules);

        if ($v->fails()) {
            throw new \Exception('Invalid data provided for model Currencies');
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
            ->where('from', $this->from)
            ->where('to', $this->to)
            ->first();
    }
}
