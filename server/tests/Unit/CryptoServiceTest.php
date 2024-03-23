<?php

namespace Tests\Unit;

use App\Services\CryptoService;
use Mockery;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;

/**
 * CryptoServiceTest class
 */
class CryptoServiceTest extends TestCase
{

    private string $cipherAlgo = 'aes-256-cbc';

    /**
     * @covers ::encrypt
     */
    public function test_value_can_be_encrypted(): void
    {
        $key = Str::random(32);
        $cryptoService = new CryptoService();

        $content = fake()->word();

        $encryptionKey = base64_encode(openssl_encrypt($key, $this->cipherAlgo, base64_decode(env('ENCRYPTION_KEY')), 0, base64_decode(env('ENCRYPTION_KEY_IV'))));

        $iv = base64_encode(Str::random(openssl_cipher_iv_length($this->cipherAlgo)));

        $encrypted = $cryptoService->encrypt($content, $encryptionKey, $iv);

        $this->assertNotNull($encrypted);

    }

    /**
     * @covers ::decrypt
     */
    public function test_encrypted_value_can_be_decrpyted(): void
    {
        $key = Str::random(32);
        $cryptoService = new CryptoService();

        $content = fake()->word();

        $encryptionKey = base64_encode(openssl_encrypt($key, $this->cipherAlgo, base64_decode(env('ENCRYPTION_KEY')), 0, base64_decode(env('ENCRYPTION_KEY_IV'))));

        $iv = base64_encode(Str::random(openssl_cipher_iv_length($this->cipherAlgo)));

        $encrypted = $cryptoService->encrypt($content, $encryptionKey, $iv);

        $this->assertNotNull($encrypted);

        $decrypted = $cryptoService->decrypt($encrypted, $encryptionKey, $iv);

        $this->assertEquals($content, $decrypted);
    }

    /**
     * @covers ::generateEncryptionKey
     */
    public function test_encryption_key_can_be_generated(): void
    {
        $cryptoService = new CryptoService();

        $encryptionKey = $cryptoService->generateEncryptionKey();

        $this->assertNotNull($encryptionKey);
    }

    /**
     * @covers ::generateRandomIV
     */
    public function test_random_iv_can_be_generated(): void
    {
        $cryptoService = new CryptoService();

        $iv = $cryptoService->generateRandomIV();

        $this->assertNotNull($iv);
    }

    /**
     * @covers ::simpleEncrpyt
     */
    public function test_value_can_be_encrypted_with_simple_encrypt(): void
    {
        $cryptoService = new CryptoService();

        $content = fake()->word();

        $encrypted = $cryptoService->simpleEncrpyt($content);

        $this->assertNotNull($encrypted);
    }

     /**
     * @covers ::simpleEncrpyt
     */
    public function test_simple_encrypted_value_can_be_decrypted(): void
    {
        $cryptoService = new CryptoService();

        $content = fake()->word();

        $encrypted = $cryptoService->simpleEncrpyt($content);

        $this->assertNotNull($encrypted);

        $this->assertEquals($content,$cryptoService->simpleDecrypt($encrypted));
    }

    /**
     * @covers ::decryptEncryptionKey
     */
    public function test_encryption_key_can_be_decrypted(): void
    {
        $cryptoService = Mockery::mock(CryptoService::class)->shouldAllowMockingProtectedMethods()->makePartial();

        $encryptedKey = base64_encode(Str::random(32));
        $decryptedKey = base64_decode(Str::random(32));

        $cryptoService->shouldReceive('decryptEncryptionKey')->once()->with($encryptedKey)->andReturn($decryptedKey);

        $decrypted = $cryptoService->decryptEncryptionKey($encryptedKey);

        $this->assertEquals($decryptedKey, $decrypted);
    }

    /**
     * @covers ::encryptEncryptionKey
     */
    public function test_encrpytion_key_can_be_encrypted(): void
    {
        $cryptoService = Mockery::mock(CryptoService::class)->shouldAllowMockingProtectedMethods()->makePartial();

        $encryptionKey = Str::random(32);
        $encrtpyedKey = base64_encode(Str::random(32));

        $cryptoService->shouldReceive('encryptEncryptionKey')->once()->with($encryptionKey)->andReturn($encrtpyedKey);

        $encrypted = $cryptoService->encryptEncryptionKey($encryptionKey);

        $this->assertEquals($encrtpyedKey, $encrypted);
    }
}
