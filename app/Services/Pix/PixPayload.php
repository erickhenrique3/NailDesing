<?php

namespace App\Services\Pix;

class PixPayload
{
    private $pixKey;
    private $description;
    private $merchantName;
    private $merchantCity;
    private $amount;
    private $transactionId;

    public function __construct($pixKey, $merchantName, $merchantCity, $amount, $transactionId, $description = '')
    {
        $this->pixKey = $pixKey;
        $this->merchantName = $merchantName;
        $this->merchantCity = $merchantCity;
        $this->amount = $amount;
        $this->transactionId = $transactionId;
        $this->description = $description;
    }

    public function getPayload()
    {
        return $this->buildPayload();
    }

    private function buildPayload()
    {
        $pixCode = [
            '00' => '01', // Identificador do formato do payload
            '26' => [
                '00' => 'BR.GOV.BCB.PIX', // Domínio do Pix
                '01' => $this->pixKey, // Chave Pix
                '02' => $this->description, // Descrição (opcional)
            ],
            '52' => '0000', // Merchant Category Code
            '53' => '986',  // Moeda BRL (ISO 4217)
            '54' => number_format($this->amount, 2, '.', ''), // Valor
            '58' => 'BR',  // País
            '59' => $this->merchantName, // Nome do recebedor
            '60' => $this->merchantCity, // Cidade do recebedor
            '62' => [
                '05' => $this->transactionId, // Identificador da transação
            ],
        ];

        return $this->encodePayload($pixCode);
    }

    private function encodePayload($data)
    {
        $encoded = '';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = $this->encodePayload($value);
            }
            $length = str_pad(strlen($value), 2, '0', STR_PAD_LEFT);
            $encoded .= $key . $length . $value;
        }
        return $encoded . $this->getCRC16($encoded);
    }

    private function getCRC16($payload)
    {
        $polynomial = 0x1021;
        $crc = 0xFFFF;

        for ($i = 0; $i < strlen($payload); $i++) {
            $crc ^= (ord($payload[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ $polynomial;
                } else {
                    $crc = ($crc << 1);
                }
            }
        }

        return '6304' . strtoupper(dechex($crc & 0xFFFF));
    }
}
