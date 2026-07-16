<?php

use App\Models\Warga;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it seeds GPS coordinates from the research dataset', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Warga::count())->toBe(73);

    expect(Warga::where('nik', '3527010101800001')->firstOrFail())
        ->latitude->toBe(-6.887385)
        ->longitude->toBe(113.758617);

    expect(Warga::where('nik', '3527010101800045')->firstOrFail())
        ->latitude->toBe(-6.893272)
        ->longitude->toBe(113.748929);

    expect(Warga::where('nik', '3527010101800073')->firstOrFail())
        ->latitude->toBe(-6.898450)
        ->longitude->toBe(113.762267);
});
