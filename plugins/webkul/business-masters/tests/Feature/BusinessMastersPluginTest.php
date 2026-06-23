<?php

use Webkul\BusinessMasters\Models\CompanyMaster;

it('can instantiate the business masters company model', function () {
    $model = new CompanyMaster;

    expect($model->getTable())->toBe('bm_company_masters');
});
