<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpSchool\CliMenu\CliMenu;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new module';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $features = [];

        $callable = function (CliMenu $menu) use (&$features) {
            $text = $menu->getSelectedItem()->getText();

            if (\in_array($text, $features)) {
                unset($features[$text]);
            } else {
                $features[] = $text;
            }
        };

        $this->menu('Module Features')
            ->setForegroundColour('white')
            ->setBackgroundColour('black')

            ->addCheckboxItem('Config', $callable)
            ->addCheckboxItem('Model', $callable)
            ->addCheckboxItem('Factory', $callable)
            ->addCheckboxItem('Controller', $callable)
            ->addCheckboxItem('Views', $callable)
            ->addCheckboxItem('Tests', $callable)
            ->addLineBreak(' ')

            ->setExitButtonText('Create')
            ->open();

        $features = \join(',', $features);
        $moduleName = $this->argument('name');

        // Actually create a module
        $this->line("Creating module with name: {$moduleName}, with features: {$features}");
    }
}
