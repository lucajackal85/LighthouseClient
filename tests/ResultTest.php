<?php


namespace Jackal\Lighthouse\Test;


use Jackal\Lighthouse\Result\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testResultFromEmptyResult(){

        $response = new Result([]);

        $this->assertEquals([],$response->getRawData());
    }
}