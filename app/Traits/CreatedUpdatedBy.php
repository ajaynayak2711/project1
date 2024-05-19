<?php
    namespace App\Traits;

    trait CreatedUpdatedBy
    {
        protected static function boot()
        {
            parent::boot();
            static::creating(function ($model) {
                $model->created_by = isset(auth()->user()->id) ? auth()->user()->id : 0;
            });

            static::updating(function ($model) {
                $model->updated_by = isset(auth()->user()->id) ? auth()->user()->id : 0;
            });
        }

    }


?>