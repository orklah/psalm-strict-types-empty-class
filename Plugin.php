<?php
namespace Orklah\StrictTypesEmptyClass;

use Orklah\StrictTypesEmptyClass\Hooks\StrictTypesEmptyClassAnalyzer;
use SimpleXMLElement;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;

class Plugin implements PluginEntryPointInterface
{
    /** @return void */
    public function __invoke(RegistrationInterface $psalm, ?SimpleXMLElement $config = null): void
    {
        if(class_exists(StrictTypesEmptyClassAnalyzer::class)){
            $psalm->registerHooksFromClass(StrictTypesEmptyClassAnalyzer::class);
        }
    }
}
