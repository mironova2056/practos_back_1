<?php

namespace Controller;
use Model\User;
use Src\Request;
class UserSearch
{
    public static function search(string $query = null)
    {
        $search = User::query()->with('roles');

        if ($query) {
            $search->where(function($q) use ($query) {
                $q->where('login', 'LIKE', "%{$query}%")
                    ->orWhereHas('roles', function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    });
            });
        }

        return $search->get();
    }

    public static function getSearchQuery(Request $request): ?string
    {
        return $request->get('search') ? trim($request->get('search')) : null;
    }
}