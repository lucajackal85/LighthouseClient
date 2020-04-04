# LighthouseClient
[![Latest Stable Version](https://poser.pugx.org/jackal/lighthouse-client/v/stable)](https://packagist.org/packages/jackal/lighthouse-client)
[![Total Downloads](https://poser.pugx.org/jackal/lighthouse-client/downloads)](https://packagist.org/packages/jackal/lighthouse-client)
[![Latest Unstable Version](https://poser.pugx.org/jackal/lighthouse-client/v/unstable)](https://packagist.org/packages/jackal/lighthouse-client)
[![License](https://poser.pugx.org/jackal/lighthouse-client/license)](https://packagist.org/packages/jackal/lighthouse-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lucajackal85/LighthouseClient/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lucajackal85/LighthouseClient/?branch=master)
[![Build Status](https://travis-ci.org/lucajackal85/LighthouseClient.svg?branch=master)](https://travis-ci.org/lucajackal85/LighthouseClient)
## Requirements
To run, this package needs [lighthouse](https://www.npmjs.com/package/lighthouse) installed on your system

## Installation
```
composer require jackal/lighthouse-client
```

## Usage
```
require_once __DIR__ . '/vendor/autoload.php';

$client = new \Jackal\Lighthouse\LighthouseClient([
    'path' => __DIR__ . '/output.json',
    'interactive' => false,
]);

$result = $client->run('https://www.google.com/');

echo "\n";
echo 'Performance: ' . $result->getPerformance() . "\n";
echo 'Accessibility: ' . $result->getAccessibility() . "\n";
echo 'Best Practices: ' . $result->getBestPractices() . "\n";
echo 'SEO: ' . $result->getSEO() . "\n";
echo 'Progressive app: ' . $result->getProgressiveWebApp() . "\n";
```
