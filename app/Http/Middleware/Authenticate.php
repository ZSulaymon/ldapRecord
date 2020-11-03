<?php namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->server('AUTH_USER') && ($user = User::where('username', $request->server('AUTH_USER'))->first()))
        {
            $this->auth->login($user);
        }
        else
        {
            return redirect()->guest('auth/login');
        }

        return $next($request);
    }

}
