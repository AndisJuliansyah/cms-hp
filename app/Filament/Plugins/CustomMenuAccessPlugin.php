<?php

namespace App\Filament\Plugins;

use App\Models\Menu;
use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Illuminate\Support\Facades\Auth;

class CustomMenuAccessPlugin implements Plugin
{
    public function getId(): string
    {
        return 'custom-menu-access';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        $panel->navigation(function (NavigationBuilder $builder): NavigationBuilder {
            $user = auth()->user();

            if (!$user) {
                return $builder;
            }

            $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();

            $menus = Menu::with(['permissions', 'children.permissions'])
                ->where('is_active', true)
                ->whereNull('parent_id')
                ->orderBy('order')
                ->get();

            $groupedMenus = $menus->groupBy('group');

            foreach ($groupedMenus as $groupName => $menusInGroup) {
                $items = [];

                foreach ($menusInGroup as $menu) {
                    $menuPermissions = $menu->permissions->pluck('name')->toArray();

                    if (!empty($menuPermissions) && empty(array_intersect($userPermissions, $menuPermissions))) {
                        continue;
                    }

                    $children = $menu->children->filter(function ($child) use ($userPermissions) {
                        $childPermissions = $child->permissions->pluck('name')->toArray();
                        return empty($childPermissions) || !empty(array_intersect($userPermissions, $childPermissions));
                    });

                    if ($children->isNotEmpty()) {
                        foreach ($children as $child) {
                            $items[] = NavigationItem::make()
                                ->label($child->name)
                                ->icon($child->icon ?? 'heroicon-o-rectangle-stack')
                                ->url(route($child->route));
                        }
                    } else {
                        $items[] = NavigationItem::make()
                            ->label($menu->name)
                            ->icon($menu->icon ?? 'heroicon-o-rectangle-stack')
                            ->url(route($menu->route));
                    }
                }

                if (!empty($items)) {
                    $builder->group(
                        NavigationGroup::make()
                            ->label($groupName)
                            ->items($items)
                    );
                }
            }

            return $builder;
        });
    }
}
