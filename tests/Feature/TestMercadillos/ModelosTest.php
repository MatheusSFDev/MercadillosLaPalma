<?php
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use App\Models\User;
use App\Models\Municipality;
use App\Models\FleaMarket;
use App\Models\Stall;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);


it('belongs to a flea market', function () {
    $stall = new Stall();
    $relation = $stall->fleaMarket();
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('belongs to a user', function () {
    $stall = new Stall();
    $relation = $stall->user();
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

?>