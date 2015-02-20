<?php

namespace App;

interface UniqueInterface
{
    /**
     * Checks if model's fields are unique
     * 
     * @return bool
     */
    public function unique();

    /**
     * Gets a model with the same unique fields
     * 
     * @return Model|null
     */
    public function findAnotherByUniqueFields();
}
