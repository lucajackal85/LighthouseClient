<?php

namespace Jackal\Lighthouse\Process;

use Jackal\BinLocator\BinLocator;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Process\Process;

class LightHouseProcess
{
    protected $options;

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

    protected function getBasicAuth() : ?string
    {
        if($this->getUsername() and $this->getPassword()) {
            return sprintf('Basic %s', base64_encode($this->getUsername() . ':' . $this->getPassword()));
        }

        return null;
    }

    protected function getShellCommand($url) {
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

    public function getProcess($url) : Process{

        $binLocator = new BinLocator('lighthouse');

        return $binLocator->getProcess($this->getShellCommand($url));

    }

    public function getOutputPath(){
        return $this->options['path'];
    }

    public function getOutputType(){
        return $this->options['output'];
    }

    public function isInteractive(){
        return $this->options['interactive'] == true;
    }

    public function getUsername(){
        return $this->options['username'];
    }

    public function getPassword(){
        return $this->options['password'];
    }
}