<?php

namespace App\Clients\Google;

final class GoogleSearch extends GoogleClient
{
    public function __construct()
    {
        parent::__construct();
    }

    public function placeAutoComplete(string $locationName): object | bool
    {
        $queryString = "autocomplete/json?input={$locationName}";
        return $this->placesApiCall($queryString);
    }

    public function placeDetails(string $placeId): object|bool
    {
        $queryString = "details/json?place_id={$placeId}";
        return $this->placesApiCall($queryString);
    }
}