<?php

namespace Jackal\Lighthouse;

use Jackal\Lighthouse\Process\LightHouseProcess;
use Jackal\Lighthouse\Result\Result;
use Symfony\Component\Process\Exception\RuntimeException;

class LighthouseClient
{
    /** @var LightHouseProcess $lighthouseProcess */
    protected $lighthouseProcess;

    public function __construct(array $options)
    {
        $this->lighthouseProcess = new LightHouseProcess($options);
    }

    /**
     * @param $url
     * @return Result|null
     */
    public function run($url) : Result
    {
        $process = $this->lighthouseProcess->getProcess($url);

        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new RuntimeException($process->getErrorOutput());
        }

        $result = new Result(json_decode(file_get_contents($this->lighthouseProcess->getOutputPath()), true));
        $this->clearFiles();
        return $result;
    }

    protected function clearFiles(){
        if(is_file($this->lighthouseProcess->getOutputPath())) {
            unlink($this->lighthouseProcess->getOutputPath());
        }
    }

    public function __destruct()
    {
        $this->clearFiles();
    }
}
