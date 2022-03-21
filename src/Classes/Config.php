<?php

namespace Cryptows\Classes;

class Config
{
    public $config;

    public function getConfig(): ?object
    {
        $config = (object) [

            'use_ssl' => false,

        ];

        return $config;
    }

}