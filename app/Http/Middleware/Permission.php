<?php

namespace App\Http\Middleware;

use Closure;

class Permission {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $permission) {
		$user = auth()->user();
		if (!$user) {
			return redirect('/');
		}
		$hasPermission = (bool) $user->permissions()->where('slug', $permission)->first();
		$hasRolesPermission = (bool) $user->roles()->whereHas('permissions', function ($q) use ($permission) {
			$q->where('permissions.slug', $permission);
		})->first();
		if ($hasPermission || $hasRolesPermission || $user->id === 1) {
			return $next($request);
		} else {
			return response("<center><h1>لاتملك الصلاحيات الكافية</h1></center>", 401);
		}

	}
}
