<?php

use App\Modules\Catalog\Providers\CatalogServiceProvider;
use App\Modules\Membership\Providers\MembershipServiceProvider;
use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    CatalogServiceProvider::class,
    MembershipServiceProvider::class,
];
