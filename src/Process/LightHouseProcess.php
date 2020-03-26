<?php

namespace Jackal\Lighthouse\Process;

use Jackal\BinLocator\BinLocator;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Process\Process;

class LightHouseProcess
{
    /** @var array $options */
    protected $options;

    /**
     * LightHouseProcess constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'interactive' => false,
            'output' => 'json',
            'path' => sys_get_temp_dir() . '/' . uniqid() . '.json',
            'username' => null,
            'password' => null,
        ]);

        $resolver->setAllowedValues('output', [
            'json','html',
        ]);

        $this->options = $resolver->resolve($options);
    }

    /**
     * @return string|null
     */
    protected function getBasicAuth() : ?string
    {
        if($this->getUsername() and $this->getPassword()) {
            return sprintf('Basic %s', base64_encode($this->getUsername() . ':' . $this->getPassword()));
        }

        return null;
    }

    /**
     * @param $url
     * @return array
     */
    protected function getShellCommand($url) : array {
        $headers = addcslashes(json_encode(['authorization' => $this->getBasicAuth()]), '"');

        $options = [
            $this->isInteractive() ? '' : '--chrome-flags="--headless --no-sandbox"',
            $this->getOutputPath() ? '--output=' . $this->getOutputType() : '--output=json',
            '--output-path=' . $this->getOutputPath(),
            $this->getBasicAuth() ? '--extra-headers="' . $headers . '"' : '',
        ];

        $options = array_reduce($options, function ($options, $currOption){
            if($currOption != ''){
                $options[] = $currOption;
            }

            return $options;
        }, []);

        return array_merge([$url], $options);
    }

    /**
     * @param $url
     * @return Process
     */
    public function getProcess($url) : Process{

        $binLocator = new BinLocator('lighthouse');

        return $binLocator->getProcess($this->getShellCommand($url));

    }

    /**
     * @return string
     */
    public function getOutputPath() : string {
        return $this->options['path'];
    }

    /**
     * @return string
     */
    public function getOutputType() : string {
        return $this->options['output'];
    }

    /**
     * @return bool
     */
    public function isInteractive() : bool {
        return $this->options['interactive'] == true;
    }

    /**
     * @return string|null
     */
    public function getUsername() : ?string {
        return $this->options['username'];
    }

    /**
     * @return string|null
     */
    public function getPassword() : ?string {
        return $this->options['password'];
    }
}