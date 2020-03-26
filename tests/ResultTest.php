<?php

namespace Jackal\Lighthouse\Test;

use Jackal\Lighthouse\Result\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testResultFromEmptyResult(){

        $response = new Result([]);

        $this->assertNull($response->getPerformance());
        $this->assertNull($response->getAccessibility());
        $this->assertNull($response->getBestPractices());
        $this->assertNull($response->getSEO());
        $this->assertEquals([
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
        ], $response->getRawData());

        $this->assertEquals('{"categories":{"performance":{"score":null},"accessibility":{"score":null},"best-practices":{"score":null},"seo":{"score":null},"pwa":{"score":null}}}', (string) $response);
    }
}