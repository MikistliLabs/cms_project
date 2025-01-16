<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        // $this->middleware('auth')->only('logout');
        $this->middleware('guest')->except('logout');
    }
    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Redirige al usuario según su rol después del inicio de sesión.
     */
    protected function redirectTo()
    {
        return Auth::user()->role == 1 ? '/admin' : '/lista-articulos';
    }

    /**
     * Manejo del inicio de sesión con reCAPTCHA y protección contra fuerza bruta.
     */
    public function login(Request $request)
    {
        // Aplicar protección contra intentos fallidos
        $this->limitaIntentos($request);

        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'g-recaptcha-response' => !$this->isLocal() ? 'required' : '',
        ]);

        // Validar reCAPTCHA si no estamos en entorno local
        if (!$this->isLocal() && !$this->validateCaptcha($request)) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['Verificación reCAPTCHA fallida. Intenta de nuevo.']
            ]);
        }

        // Intentar autenticar al usuario
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Verifica el reCAPTCHA con Google.
     */
    protected function validateCaptcha(Request $request)
    {
        $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        return $response->json()['success'] ?? false;
    }

    /**
     * Aplica protección contra intentos de fuerza bruta.
     */
    protected function limitaIntentos(Request $request)
    {
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            throw ValidationException::withMessages([
                'email' => ['Demasiados intentos de inicio de sesión. Inténtalo más tarde.']
            ])->status(429);
        }
    }
    /**
     * Determina si la aplicación se ejecuta en entorno local.
     */
    protected function isLocal()
    {
        return app()->environment('local');
    }
}
