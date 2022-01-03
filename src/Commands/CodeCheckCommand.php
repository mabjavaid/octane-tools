<?php

namespace Mabjavaid\OctaneTools\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class CodeCheckCommand extends Command
{
    protected $signature = 'octane:check';
    protected $description = 'Run PHPMD on the code base.';

    private $errorOutput = [];

    public const EXIT_CODE_ERROR = 1;
    public const EXIT_CODE_SUCCESS = 0;

    public function handle()
    {
        $this->runPhpMd();
        if ($this->hasFailed()) {
            echo $this->getErrorOutput();
            $this->error('Clean code checks failed.');

            return self::EXIT_CODE_ERROR;
        }

        $this->info('Code looks fine!');

        return self::EXIT_CODE_SUCCESS;
    }

    private function runPhpMd()
    {
        $dirs = implode(',', config('octane-tools.phpmd.dirs'));
        $exclude = implode(',', config('octane-tools.phpmd.exclude'));
        $configPath = config('octane-tools.phpmd.config-file');

        $this->runCustomCommand("vendor/bin/phpmd $dirs text $configPath --exclude $exclude --suffixes php");
    }

    private function markAsFailed(Process $process): self
    {
        $this->errorOutput[] = $process->getOutput();

        return $this;
    }

    private function hasFailed(): bool
    {
        return count($this->errorOutput) > 0;
    }

    private function getErrorOutput(): string
    {
        return implode(PHP_EOL . PHP_EOL, array_unique(explode(PHP_EOL , $this->errorOutput[0])));
    }

    private function runCustomCommand(string $command)
    {
        $process = new Process(explode(' ', $command));
        $process->setTimeout(config('octane-tools.timeout'));
        $process->run();

        if (!$process->isSuccessful()) {
            $this->markAsFailed($process);
        }
    }
}
