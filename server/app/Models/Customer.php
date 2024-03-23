<?php

namespace App\Models;

use App\Services\CryptoService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'id_data' => 'json',
    ];

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    protected function idData(): Attribute
    {
        $cryptoService = app(CryptoService::class);

        return Attribute::make(
            get: fn ($value) => collect(json_decode($value,true))->map(fn($value, $key) => $cryptoService->simpleDecrypt($value))->toArray(),
        );
    }
}
