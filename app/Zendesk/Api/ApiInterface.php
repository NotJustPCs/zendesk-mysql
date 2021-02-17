<?php


namespace App\Zendesk\Api;


interface ApiInterface
{
    public function processData($data);
    public function nextPage($page);
}
