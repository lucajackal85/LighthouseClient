<?php


namespace Jackal\Lighthouse\Test\Process;


use Jackal\Lighthouse\Process\LightHouseProcess;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class LighthouseOptionsTest extends TestCase
{
    public function testDefaultValues(){
        $process = new LightHouseProcess();

        $this->assertNull($process->getUsername());
        $this->assertNull($process->getPassword());
        $this->assertEquals('json',$process->getOutputType());
        $this->assertTrue(is_dir(dirname($process->getOutputPath())));
        $this->assertFalse($process->isInteractive());
    }

    public function testRaiseExceptionOnInvalidOutput(){

        $this->expectException(InvalidOptionsException::class);
        $this->expectExceptionMessage('The option "output" with value "invalid" is invalid. Accepted values are: "json", "html".');

        new LightHouseProcess([
            'output' => 'invalid'
        ]);
    }
}