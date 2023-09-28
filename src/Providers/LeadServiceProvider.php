<?php
   
    namespace Wcg104\Lead\Providers;
    use Illuminate\Support\ServiceProvider;
    
    class LeadServiceProvider extends ServiceProvider {

        public function boot()
        {
         
            $this->publishes([
              __DIR__.'/../database/migrations/' => database_path('migrations')
              ], 'lead');
              $this->publishes([
                __DIR__.'/../Http/Controllers/' => app_path('Http/Controllers')
              ], 'lead');
              $this->publishes([
                __DIR__.'/../Models/' => app_path('Models')
              ], 'lead');
              $this->publishes([
                __DIR__.'/../Http/Requests' => app_path('Http/Requests')
              ], 'lead');
              $this->publishes([
                __DIR__.'/../test/Feature' => test_path('Feature')
              ], 'lead');
        }
   }
?>