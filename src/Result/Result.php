<?php

namespace Jackal\Lighthouse\Result;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Result
{
    /** @var array  */
    protected $response;

    public function __construct(array $response)
    {
        $this->response = $response;

        $options = new OptionsResolver();
        $options->setDefaults([
            'categories' => [
                'performance' => [
                    'score' => null,
                ],
                'accessibility' => [
                    'score' => null,
                ],
                'best-practices' => [
                    'score' => null,
                ],
                'seo' => [
                    'score' => null,
                ],
                'pwa' => [
                    'score' => null,
                ],
            ],
        ]);

        foreach (array_keys($response) as $key){
            $options->setDefault($key, null);
        }

        $this->response = $options->resolve($response);
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return json_encode($this->response);
    }

    /**
     * @return array
     */
    public function getRawData() : array
    {
        return $this->response;
    }

    /**
     * @return int|null
     */
    public function getPerformance() : ?int
    {
        $value = $this->response['categories']['performance']['score'];
        if(!$value){
            return $value;
        }

        return $value * 100;
    }

    /**
     * @return int|null
     */
    public function getAccessibility() : ?int
    {
        $value = $this->response['categories']['accessibility']['score'];
        if(!$value){
            return $value;
        }

        return $value * 100;
    }

    /**
     * @return int|null
     */
    public function getBestPractices() : ?int
    {
        $value = $this->response['categories']['best-practices']['score'];
        if(!$value){
            return $value;
        }

        return $value * 100;
    }

    /**
     * @return int|null
     */
    public function getSEO() : ?int
    {
        $value = $this->response['categories']['seo']['score'];
        if(!$value){
            return $value;
        }

        return $value * 100;
    }

    /**
     * @return int|null
     */
    public function getProgressiveWebApp() : ?int
    {
        $value = $this->response['categories']['pwa']['score'];
        if(!$value){
            return $value;
        }

        return $value * 100;
    }
}
