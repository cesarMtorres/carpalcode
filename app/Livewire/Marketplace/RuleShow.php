<?php

declare(strict_types=1);

namespace App\Livewire\Marketplace;

use App\Models\Rule;
use Exception;
use Livewire\Component;

class RuleShow extends Component
{
    public array $rule;

    public string $ruleInput = '';

    public string $output = '';

    public function mount($id): void
    {
        $this->rule = Rule::query()->find($id)->toArray();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.marketplace.rule-show');
    }

    public function tryRule(): void
    {
        if ($this->ruleInput === '' || $this->ruleInput === '0') {
            $this->output = 'Por favor ingresa código PHP para analizar';

            return;
        }

        try {
            $ruleClass = $this->rule['title'];
            $namespace = 'Rector\CodeQuality\Rector\FuncCall\\' . $ruleClass;

            // Crea directorio temporal si no existe
            $tempDir = storage_path('app/tmp/rector_test');
            if ( ! file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Guarda el código del usuario en un archivo temporal
            $testFile = $tempDir.'/Example.php';
            file_put_contents($testFile, $this->ruleInput);

            // Genera el archivo rector.php
            $rectorConfig = <<<'PHP'
                <?php
                use Rector\Config\RectorConfig;

                return RectorConfig::configure()
                    ->withRules([
                        RULE_CLASS::class,
                    ]);
                PHP;

            $rectorConfig = str_replace('RULE_CLASS', $namespace, $rectorConfig);

            $configFile = $tempDir.'/rector.php';
            file_put_contents($configFile, $rectorConfig);

            // Ejecuta rector
            $phpBinary = $this->getPhpBinary();

            $process = new \Symfony\Component\Process\Process([
                $phpBinary,
                base_path('vendor/bin/rector'),
                'process',
                $testFile,
                '--config='.$configFile,
                '--dry-run',
                '--ansi',
                '--no-progress-bar',
            ]);

            $process->setTimeout(null);
            $process->run();

            // Obtén el código refactorizado
            $refactoredCode = file_get_contents($testFile);

            // Genera la diferencia
            if ($refactoredCode !== $this->ruleInput) {
                $this->output = $this->generateDiff($this->ruleInput, $refactoredCode);
            } else {
                $this->output = 'No se realizaron cambios. Esta regla podría no aplicarse a este código.';
            }

            // Limpia los archivos temporales
            @unlink($testFile);
            @unlink($configFile);

        } catch (Exception $exception) {
            $this->output = 'Error: '.$exception->getMessage();
        }
    }

    public function getDiff(string $path): string
    {
        $process = new Process(['git', 'diff'], $path);
        $process->run();

        return $process->getOutput();
    }

    private function generateDiff(string $original, string $refactored): string
    {
        $originalLines = explode("\n", $original);
        $refactoredLines = explode("\n", $refactored);

        $diff = [];
        $diff[] = "=== CÓDIGO ORIGINAL ===\n";
        $diff[] = implode("\n", array_map(fn ($line): string => '- ' . $line, $originalLines));
        $diff[] = "\n\n=== CÓDIGO REFACTORIZADO ===\n";
        $diff[] = implode("\n", array_map(fn ($line): string => '+ ' . $line, $refactoredLines));

        return implode("\n", $diff);
    }

    private function getPhpBinary(): string
    {
        // Rutas comunes para Herd en Mac y otros entornos
        $candidates = [
            // Herd en Mac
            '/Users/'.get_current_user().'/Library/Application Support/Herd/bin/php',
            // Rutas estándar en Mac
            '/opt/homebrew/bin/php',
            '/usr/local/bin/php',
            '/usr/bin/php',
            // Intenta con which
            trim(shell_exec('which php')),
        ];

        foreach ($candidates as $php) {
            if ($php !== '' && $php !== '0' && file_exists($php) && is_executable($php)) {
                return $php;
            }
        }

        throw new Exception('No se encontró el binario de PHP CLI');
    }
}
