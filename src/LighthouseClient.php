<?php


namespace Jackal\Lighthouse;

use Jackal\BinLocator\BinLocator;
use Jackal\Lighthouse\Result\Result;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

class LighthouseClient
{
    protected $options;
    protected $lighthouse;

    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'interactive' => false,
            'output' => 'json',
            'path' => null,
            'headers' => []
        ]);

        $this->options = $resolver->resolve($options);
        $this->lighthouse = $this->getLighthousePath();
    }

    public function addBasicAuthorization($user, $password)
    {
        $this->options['headers']['authorization'] = sprintf('Basic %s', base64_encode($user.':'.$password));
    }

    /**
     * @param $url
     * @return Result|null
     */
    public function run($url)
    {
        $tempOutput = sys_get_temp_dir().'/'.uniqid().'.'.$this->options['output'];

        $headers = addcslashes(json_encode($this->options['headers']), '"');

        $options =[
            $this->options['interactive'] ? '' : '--chrome-flags="--headless --no-sandbox"',
            $this->options['path'] ? '--output='.$this->options['output'] : '--output=json',
            $this->options['path'] ? '--output-path='.$this->options['path'] : '--output-path='.$tempOutput,
            $this->options['headers'] ? '--extra-headers="'.$headers.'"' : ''
        ];

        $command = sprintf('%s %s %s', $this->lighthouse, $url, implode(' ', $options));
        $process = new Process($command);
        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new RuntimeException(sprintf('<error>%s</error>', $process->getErrorOutput()));
        }

        if (!$this->options['path']) {
            $result = new Result(json_decode(file_get_contents($tempOutput), true));
            unlink($tempOutput);
            return $result;
        }

        return null;
    }

    protected function getLighthousePath()
    {
        $binLocator = new BinLocator('lighthouse');
        return $binLocator->locate();
    }
}
