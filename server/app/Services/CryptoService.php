<?php

namespace App\Services;

use App\Exceptions\DecryptException;
use App\Exceptions\EncryptException;
use Illuminate\Support\Str;

/**
 * CryptoService class
 */
class CryptoService
{
    private string $cipherAlgo = 'aes-256-cbc';

    public function encrypt(mixed $content, string $key, string $iv): string
    {
        $encryptionKey = $this->decryptEncryptionKey(base64_decode($key));

        $cipher = openssl_encrypt($content, $this->cipherAlgo, $encryptionKey, 0, base64_decode($iv));

        if ($cipher === false) {
            throw new EncryptException('Could not encrypt the data.');
        }

        return $cipher;
    }

    public function decrypt(mixed $content, string $key, string $iv): string
    {
        $encryptionKey = $this->decryptEncryptionKey(base64_decode($key));

        $cipher = openssl_decrypt($content, $this->cipherAlgo, $encryptionKey, 0, base64_decode($iv));

        if ($cipher === false) {
            throw new DecryptException('Could not decrypt the data.');
        }

        return $cipher;
    }

    protected function decryptEncryptionKey(string $key): string
    {
        $decrypted = openssl_decrypt($key, $this->cipherAlgo, base64_decode(env('ENCRYPTION_KEY')), 0, base64_decode(env('ENCRYPTION_KEY_IV')));
        if ($decrypted === false) {
            throw new DecryptException('Could not decrypt the encryptionkey.');
        }

        return $decrypted;
    }

    protected function encryptEncryptionKey(string $key): string
    {
        $encrypted = openssl_encrypt($key, $this->cipherAlgo, base64_decode(env('ENCRYPTION_KEY')), 0, base64_decode(env('ENCRYPTION_KEY_IV')));
        if ($encrypted === false) {
            throw new EncryptException('Could not encrypt the encryption key.');
        }

        return $encrypted;
    }

    public function generateEncryptionKey(): string
    {
        return base64_encode($this->encryptEncryptionKey(Str::random(32)));
    }

    public function generateRandomIV(): string
    {
        return base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipherAlgo)));
    }

    public function simpleEncrpyt(mixed $content): string
    {
        $cipher = openssl_encrypt($content, $this->cipherAlgo, base64_decode(env('ENCRYPTION_KEY')), 0, base64_decode(env('ENCRYPTION_KEY_IV')));

        if ($cipher === false) {
            throw new EncryptException('Could not encrypt the data.');
        }

        return $cipher;
    }

    public function simpleDecrypt(mixed $content): string
    {
        $cipher = openssl_decrypt($content, $this->cipherAlgo, base64_decode(env('ENCRYPTION_KEY')), 0, base64_decode(env('ENCRYPTION_KEY_IV')));

        if ($cipher === false) {
            throw new DecryptException('Could not decrypt the data.');
        }

        return $cipher;
    }
}
