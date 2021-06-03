<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Log;

class Banks
{
    const BANK_CODES = [
        '044' => [
            "name"=> "Access Bank",
            "slug"=> "access-bank",
            "code"=> "044",
            "longcode"=> "044150149",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 1,
        ],
        '023' => [
            "name"=> "Citibank Nigeria",
            "slug"=> "citibank-nigeria",
            "code"=> "023",
            "longcode"=> "023150005",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 2,
        ],
        '063' => [
            "name"=> "Diamond Bank",
            "slug"=> "diamond-bank",
            "code"=> "063",
            "longcode"=> "063150162",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 3,
        ],
        '050' => [
            "name"=> "Ecobank Nigeria",
            "slug"=> "ecobank-nigeria",
            "code"=> "050",
            "longcode"=> "050150010",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 4,
        ],
        '084' => [
            "name"=> "Enterprise Bank",
            "slug"=> "enterprise-bank",
            "code"=> "084",
            "longcode"=> "084150015",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 5,
        ],
        '070' => [
            "name"=> "Fidelity Bank",
            "slug"=> "fidelity-bank",
            "code"=> "070",
            "longcode"=> "070150003",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 6,
        ],
        '011' =>  [
            "name"=> "First Bank of Nigeria",
            "slug"=> "first-bank-of-nigeria",
            "code"=> "011",
            "longcode"=> "011151003",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 7,
        ],
        '214' => [
            "name"=> "First City Monument Bank",
            "slug"=> "first-city-monument-bank",
            "code"=> "214",
            "longcode"=> "214150018",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 8,
        ],
        '058' => [
            "name"=> "Guaranty Trust Bank",
            "slug"=> "guaranty-trust-bank",
            "code"=> "058",
            "longcode"=> "058152036",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 9,
        ],
        '030' => [
            "name"=> "Heritage Bank",
            "slug"=> "heritage-bank",
            "code"=> "030",
            "longcode"=> "030159992",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 10,
        ],
        '082' => [
            "name"=> "Keystone Bank",
            "slug"=> "keystone-bank",
            "code"=> "082",
            "longcode"=> "082150017",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 11,
        ],
        '014' => [
            "name"=> "MainStreet Bank",
            "slug"=> "mainstreet-bank",
            "code"=> "014",
            "longcode"=> "014150331",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 12,
        ],
        '076' => [
            "name"=> "Skye Bank",
            "slug"=> "skye-bank",
            "code"=> "076",
            "longcode"=> "076151006",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 13,
        ],
        '221' => [
            "name"=> "Stanbic IBTC Bank",
            "slug"=> "stanbic-ibtc-bank",
            "code"=> "221",
            "longcode"=> "221159522",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 14,
        ],
        '068' => [
            "name"=> "Standard Chartered Bank",
            "slug"=> "standard-chartered-bank",
            "code"=> "068",
            "longcode"=> "068150015",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 15
        ],
        '232' => [
            "name"=> "Sterling Bank",
            "slug"=> "sterling-bank",
            "code"=> "232",
            "longcode"=> "232150016",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 16,
        ],
        '032' => [
            "name"=> "Union Bank of Nigeria",
            "slug"=> "union-bank-of-nigeria",
            "code"=> "032",
            "longcode"=> "032080474",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 17,
        ],
        '033' => [
            "name"=> "United Bank For Africa",
            "slug"=> "united-bank-for-africa",
            "code"=> "033",
            "longcode"=> "033153513",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 18,
        ],
        '215' => [
            "name"=> "Unity Bank",
            "slug"=> "unity-bank",
            "code"=> "215",
            "longcode"=> "215154097",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 19,
        ],
        '035' => [
            "name"=> "Wema Bank",
            "slug"=> "wema-bank",
            "code"=> "035",
            "longcode"=> "035150103",
            "gateway"=> "etz",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 20,
        ],
        '057' => [
            "name"=> "Zenith Bank",
            "slug"=> "zenith-bank",
            "code"=> "057",
            "longcode"=> "057150013",
            "gateway"=> "",
            "active"=> true,
            "is_deleted"=> null,
            "id"=> 21,
        ]
    ];

    /**
     * Resolves account details using the NUBAN and the Bank Code
     * @param $nuban string Bank account number
     * @param $bankCode string Bank Code
     * @return array Matched account details
     * @throws \Exception
     */
    public static function resolveAccountInfo($nuban, $bankCode) {
        $url = "https://api.paystack.co/bank/resolve?account_number=$nuban&bank_code=$bankCode";
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . env('PAYSTACK_SECRET_KEY'),
                "cache-control: no-cache"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            Log::error($err);
            throw new \Exception("failed to communicate with gateway");
        }
        $info = json_decode($response);
        if ($info->status == false) {
            throw new \Exception("Could not find the account details");
        }
        return [
            'account_number' => $info->data->account_number,
            'account_name' => $info->data->account_name,
            'bank_id' => $info->data->bank_id
        ];
    }

    /**
     * Creates a Paystack transfer recipient to create a transfer code per nuban
     * @param $nuban string bank account number
     * @param $name string bank account name
     * @param $bankCode string bank code. @see self::BANK_CODES
     * @return array matched account details including recipient code
     * @throws \Exception
     */
    public static function createTransferRecipient($nuban, $name, string $bankCode) {
        $ch = curl_init();
        $body = http_build_query([
            'type' => 'nuban',
            'name' => $name,
            'account_number' => $nuban,
            'bank_code' => $bankCode,
            'currency' => "NGN"
        ]);
        curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transferrecipient");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "accept: application/json",
            "authorization: Bearer " . env('PAYSTACK_SECRET_KEY'),
            "Cache-Control: no-cache",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        if ($err) {
            Log::error($err);
            throw new \Exception("failed to communicate with gateway");
        }
        $info = json_decode($response);
        if ($info->status == false) {
            throw new \Exception("Could not find the account details");
        }
        Log::info(json_encode($info, JSON_PRETTY_PRINT));
        return [
            'account_number' => $info->data->details->account_number,
            'account_name' => $info->data->details->account_name,
            'recipient_code' => $info->data->recipient_code
        ];
    }
}


