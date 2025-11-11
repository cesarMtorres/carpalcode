<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GithubCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $code = $request->query('code');
        $error = $request->query('error');

        if ($error) {
            return redirect('/github')->with('message', 'Error de GitHub: '.$error);
        }

        if ( ! $code) {
            return redirect('/github')->with('message', 'Error: No se recibió el código de autorización');
        }

        // Guardar en sesión para que Livewire lo recupere
        Session::put('github_code', $code);

        // Redirige a Livewire
        return to_route('github.dashboard');
    }
}
