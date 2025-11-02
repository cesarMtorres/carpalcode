<?php

namespace App\Actions\Rules;

use Exception;
use PhpParser\ParserFactory;

class TryCode
{
    /** Validate and create a newly registered user. */
    public function validate(string $code): array
    {
        $status = 'success';
        $message = 'valid code';

        rescue(function () use ($code): void {

            $parser = (new ParserFactory)->createForNewestSupportedVersion();
            $parser->parse($code);

        }, function () use (&$status, &$message): void {
            $status = 'error';
            $message = 'Error on code';
        });

        return compact('status', 'message');
    }

    // todo pasar la version de php
    public function execute(string $code, string $phpVersion = ''): array
    {
        try {
            $parser = (new ParserFactory)->createForNewestSupportedVersion();

            $ast = $parser->parse($code);

            if (empty($ast)) {
                return [
                    'success' => false,
                    'output' => 'Código PHP inválido',
                    'error' => 'El código no pudo ser parseado',
                ];
            }

            $tempFile = $this->createTempFile($code);

            ob_start();
            $result = include $tempFile;
            $output = ob_get_clean();

            unlink($tempFile);

            return [
                'success' => true,
                'output' => $output ?: 'Código ejecutado correctamente',
                'result' => $result,
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'output' => '',
                'error' => $e->getMessage(),
            ];
        }
    }

    private function createTempFile(string $code): string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'php_rule_');
        file_put_contents($tempFile, $code);

        return $tempFile;
    }
}
