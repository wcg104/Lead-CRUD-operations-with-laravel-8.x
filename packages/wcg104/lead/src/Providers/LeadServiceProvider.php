<?php
   
    namespace Wcg104\Lead\Providers;
    use Illuminate\Support\ServiceProvider;
    
    class LeadServiceProvider extends ServiceProvider {

        public function boot()
        {
          $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
          $this->loadViewsFrom(__DIR__.'/../resources/views', 'test');
          $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
   }
?>