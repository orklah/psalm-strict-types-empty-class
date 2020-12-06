<?php

declare(strict_types=1);

namespace Orklah\StrictTypesEmptyClass\Hooks;

use Psalm\Codebase;
use Psalm\Context;
use Psalm\Plugin\Hook\AfterFileAnalysisInterface;
use Psalm\StatementsSource;
use Psalm\Storage\FileStorage;
use function count;

class StrictTypesEmptyClassAnalyzer implements AfterFileAnalysisInterface
{

    public static function afterAnalyzeFile(
        StatementsSource $statements_source,
        Context $file_context,
        FileStorage $file_storage,
        Codebase $codebase
    ): void {
        if($file_storage->has_extra_statements === true){
            //this is an issue by itself
            return;
        }

        if(count($file_storage->classlikes_in_file) !== 1){
            //don't touch multi class files nor empty files
            return;
        }

        $class = array_pop($file_storage->classlikes_in_file);
        $class_storage = $codebase->classlike_storage_provider->get($class);
        if(count($class_storage->methods) !== 0){
            //the class has methods. Not interested. However, we may go further and allow abstact methods or empty methods
            return;
        }

        $file_contents = file_get_contents($file_storage->file_path);
        $new_file_contents = str_replace('<?php', '<?php declare(strict_types=1);', $file_contents);
        file_put_contents($file_storage->file_path, $new_file_contents);
    }
}
