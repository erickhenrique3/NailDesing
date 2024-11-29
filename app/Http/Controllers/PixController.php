<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Pix\PixPayload;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Validator;

class PixController extends Controller
{
    public function generatePix(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pix_key' => 'required|string',
            'merchant_name' => 'required|string|max:25',
            'merchant_city' => 'required|string|max:15',
            'amount' => 'required|numeric|min:0.01',
            'transaction_id' => 'required|string|max:25',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ],422);
        }

        $pixKey = $request->input('pix_key');
        $merchantName = $request->input('merchant_name');
        $merchantCity = $request->input('merchant_city');
        $amount = $request->input('amount');
        $transactionId = $request->input('transaction_id');
        $description = $request->input('description', '');

        // Gera o payload do Pix
        $pixPayload = new PixPayload(
            $pixKey,
            $merchantName,
            $merchantCity,
            $amount,
            $transactionId,
            $description
        );

        $pixCode = $pixPayload->getPayload();

        // Cria o QR Code
        $qrCode = new QrCode($pixCode);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode);

        return response()->json([
            'qrcode' => 'data:image/png;base64,' . base64_encode($qrCodeImage->getString()),
            'pix_code' => $pixCode,
        ]);
    }
}
