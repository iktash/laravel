<?php

namespace App;

interface Sanitizible
{
    /**
     * Makes sure that all fields are compatible
     * 
     * @return void
     */
    public function sanitize();
}
