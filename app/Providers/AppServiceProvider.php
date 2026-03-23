<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
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