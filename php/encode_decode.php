<?php

define('FILE_ENCRYPTION_KEY', 'X8f!jE#2$pL9@zY5&vK7*nM3%qR6^tU4');
/**
 * Encrypt a string using AES-256-CBC
 * @param string $plaintext The string to encrypt
 * @return string Encrypted string (base64 encoded)
 */
    function encode($plaintext)
{
    $key = hash('sha256', FILE_ENCRYPTION_KEY , true); // Replace with a strong secret key
    $iv = openssl_random_pseudo_bytes(16);
    $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext, $key, true);
    return strtr(base64_encode($iv . $hmac . $ciphertext), '+/=', '._-');
}

/**
 * Decrypt a string encrypted with the encode method
 * @param string $encrypted The encrypted string (base64 encoded)
 * @return string|false Decrypted string or false on failure
 */
    function decode($encrypted)
{
    $encrypted = strtr($encrypted, '._-', '+/=');
    $data = base64_decode($encrypted);
    if (strlen($data) < 48) return false; // iv(16) + hmac(32)

    $key = hash('sha256', FILE_ENCRYPTION_KEY, true); // Same secret key as in encode
    $iv = substr($data, 0, 16);
    $hmac = substr($data, 16, 32);
    $ciphertext = substr($data, 48);

    $calculatedHmac = hash_hmac('sha256', $ciphertext, $key, true);
    if (!hash_equals($hmac, $calculatedHmac)) {
        return false; // HMAC verification failed
    }

    return openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
}

// Example usage
// $originalText = "Hello, World!";
// $encryptedText = encode($originalText);
// echo "Encrypted: " . $encryptedText . "\n";
// $decryptedText = decode($encryptedText);
// echo "Decrypted: " . $decryptedText . "\n";

?>