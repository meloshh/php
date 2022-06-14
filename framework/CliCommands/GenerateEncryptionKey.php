<?php

namespace Framework\CliCommands;

class GenerateEncryptionKey implements ICliCommand
{
    public function run()
    {
        $raw = sodium_crypto_secretbox_keygen();
        $hex =  bin2hex($raw);
        echo $hex.PHP_EOL;
        echo 'valid: '. (string)($raw === hex2bin($hex));
    }
}