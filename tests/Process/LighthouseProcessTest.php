<?php


namespace Jackal\Lighthouse\Test\Process;


use Jackal\Lighthouse\Process\LightHouseProcess;
use PHPUnit\Framework\TestCase;

class LighthouseProcessTest extends TestCase
{
    public function testGetCommandStringDefaultValues(){
        $process = new LightHouseProcess([
            'path' => __DIR__.'/unittest.json'
        ]);

        $this->assertEquals('/usr/bin/lighthouse http://localhost/ --chrome-flags="--headless --no-sandbox" --output=json --output-path='.__DIR__.'/unittest.json',
            $process->getProcess('http://localhost/')->getCommandLine()
        );
    }

    public function testGetCommandStringInteractive(){
        $process = new LightHouseProcess([
            'path' => __DIR__.'/unittest.json',
            'interactive' => true,
        ]);

        $this->assertEquals('/usr/bin/lighthouse http://localhost/ --output=json --output-path='.__DIR__.'/unittest.json',
            $process->getProcess('http://localhost/')->getCommandLine()
        );
    }

    public function testGetCommandHTMLOutput(){
        $process = new LightHouseProcess([
            'path' => __DIR__.'/unittest.html',
            'interactive' => true,
            'output' => 'html'
        ]);

        $this->assertEquals('/usr/bin/lighthouse http://localhost/ --output=html --output-path='.__DIR__.'/unittest.html',
            $process->getProcess('http://localhost/')->getCommandLine()
        );
    }
}