<?php


namespace Jackal\Lighthouse\Result;

class Result
{
    protected $response;
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function __toString()
    {
        return json_encode($this->response);
    }

    public function getRawData()
    {
        return $this->response;
    }

    public function getPerformance()
    {
        return $this->response['categories']['performance']['score'] * 100;
    }

    public function getAccessibility()
    {
        return $this->response['categories']['accessibility']['score'] * 100;
    }

    public function getBestPractices()
    {
        return $this->response['categories']['best-practices']['score'] * 100;
    }

    public function getSEO()
    {
        return $this->response['categories']['seo']['score'] * 100;
    }

    public function getProgressiveWebApp()
    {
        return $this->response['categories']['pwa']['score'] * 100;
    }
}
