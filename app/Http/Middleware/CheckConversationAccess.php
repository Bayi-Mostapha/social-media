<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckConversationAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $conversationId = $request->route('cid'); 

        $conversation = Conversation::find($conversationId);

        if (!$conversation || !($conversation->user_id1 == auth()->user()->id || $conversation->user_id2 == auth()->user()->id)) {
            abort(403);
        }

        return $next($request);
    }
}
