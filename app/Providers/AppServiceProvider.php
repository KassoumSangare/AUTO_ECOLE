<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Utiliser les vues de pagination Bootstrap pour que ->links() rende correctement
        if (method_exists(Paginator::class, 'useBootstrapFive')) {
            Paginator::useBootstrapFive();
        } else {
            Paginator::useBootstrap();
        }

        /**
         * Directive @active('pattern') — applique la classe "active"
         * si l'URL courante correspond au pattern.
         *
         * Utilisation dans les vues :
         *   class="sidebar-link @active('admin/tableau*')"
         */
        Blade::directive('active', function ($pattern) {
            return "<?php echo request()->is({$pattern}) ? 'active' : ''; ?>";
        });
    }
}