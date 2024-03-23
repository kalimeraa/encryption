<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use App\Services\CryptoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers ::store
     * @return void
     */
    public function test_customer_can_be_created(): void
    {
        $encryptionKey = fake()->word();
        $iv = fake()->word();

        Storage::fake('public');

        $cryptoService = Mockery::mock(CryptoService::class)
            ->shouldReceive('generateEncryptionKey')
            ->andReturn($encryptionKey)
            ->shouldReceive('generateRandomIV')
            ->andReturn($iv)
            ->shouldReceive('encrypt')
            ->andReturn('encrypted')
            ->shouldReceive('simpleEncrpyt')
            ->andReturn('encrypted');

        $this->app->instance(CryptoService::class, $cryptoService->getMock());

        $user = User::factory()->create();

        $payload = [
            'id_data' => [
                'gender' => fake()->randomElement(['male','female']),
                'first_name' => fake()->name(),
                'last_name' => fake()->name(),
                'id' => fake()->numerify('###########'),
                'serial_number' => fake()->sentence(),
                'birth_date' => fake()->dateTimeBetween('-30 years','-1 years')->format('Y-m-d'),
            ],
            'email' => fake()->unique()->safeEmail(),
            'website' => fake()->url(),
            'company' => fake()->company(),
            'id_file' => UploadedFile::fake()->image('id_file.jpg',100,100),
        ];
        
        $response = $this->actingAs($user)->post(route('customers.store'), $payload);

        $response->assertStatus(302)->assertSessionHasNoErrors();

        $this->assertDatabaseHas('customers', [
            'email' => $payload['email'],
            'website' => $payload['website'],
            'company' => $payload['company'],
            'id_data' => $this->castAsJson(array_map(function($value) {
                return 'encrypted';
            }, $payload['id_data'])),
        ]);

        $this->assertDatabaseHas('files', [
            'key' => 'id_front',
            'value' => $payload['id_file']->getClientOriginalName() . '.enc',
            'fileable_type' => Customer::class,
            'iv' => $iv,
            'encryption_key' => $encryptionKey,
        ]);

        Storage::disk('public')->assertExists($payload['id_file']->getClientOriginalName() . '.enc');
    }
}