<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Sidebar
{
    public static function sections(): Collection
    {
        $user = Auth::user();

        return collect(config('sidebar'))
            ->map(function (array $section) use ($user) {
                $section['menus'] = collect($section['menus'])
                    ->map(fn(array $menu) => static::normalize($menu, $user))
                    ->filter()
                    ->values();

                return $section;
            })
            ->filter(fn(array $section) => $section['menus']->isNotEmpty())
            ->values();
    }

    protected static function normalize(array $menu, $user): ?array
    {
        // Menu dengan submenu
        if (isset($menu['children'])) {
            $children = collect($menu['children'])
                ->filter(fn(array $child) => static::allowed($child['permission'] ?? null, $user))
                ->map(function (array $child) {
                    $child['active'] ??= [$child['route'] . '*'];

                    return $child;
                })
                ->values();

            if ($children->isEmpty()) {
                return null;
            }

            $menu['children'] = $children;
            $menu['active'] ??= $children->pluck('active')->flatten()->unique()->values()->all();

            return $menu;
        }

        // Menu tunggal
        if (! static::allowed($menu['permission'] ?? null, $user)) {
            return null;
        }

        $menu['active'] ??= [$menu['route'] . '*'];

        return $menu;
    }

    protected static function allowed(?string $permission, $user): bool
    {
        return blank($permission) || $user->can($permission);
    }
}
