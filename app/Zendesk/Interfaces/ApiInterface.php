<?php


namespace App\Zendesk\Interfaces;


interface ApiInterface
{
    public function processData($data);
    public function nextPage($page);
}
