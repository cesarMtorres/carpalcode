<?php

use App\Actions\Rules\AnalizeAction;

it('Action test', function (): void {
    $action = new AnalizeAction;

    $result = $action->handle('pedio');

    expect($result)->toBeArray();

    expect($result['output'])->toContain('Rector is done!');

});
