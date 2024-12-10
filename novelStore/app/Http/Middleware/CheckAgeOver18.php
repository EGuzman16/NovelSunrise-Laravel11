<?php

namespace App\Http\Middleware;

use App\Models\Novel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAgeOver18
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        $novel = Novel::with('tags')->findOrFail($id);


        $hasTag = $novel->tags->contains('tag_id', 1);

        if ($hasTag) {
            if (!session('age-verified', false)) {
                return redirect()
                    ->route('novels.age-verification.form', ['id' => $id]);
            }
        }

        return $next($request);
    }
}
