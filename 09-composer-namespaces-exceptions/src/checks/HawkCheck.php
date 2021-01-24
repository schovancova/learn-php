<?php


namespace main\checks;


interface HawkCheck
{
    public function checkApiResponse($response): ?bool;

}