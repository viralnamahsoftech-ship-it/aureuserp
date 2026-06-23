<?php

use Webkul\BusinessParty\Models\PartyMaster;

it('can instantiate the business party party model', function () {
    $model = new PartyMaster;

    expect($model->getTable())->toBe('bp_party_masters');
});
