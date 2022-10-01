<?php

namespace App\Modules\Refill\Payments\WestWallet;

use WestWallet\WestWallet\Client;
use WestWallet\WestWallet\CurrencyNotFoundException;

class Gateway {
    public static $currencies = [
        'BTC' => [
            'status' => true,
            'key' => 'BTC',
            'type' => 'crypto',
            'title' => 'Bitcoin',
            'network' => 'Bitcoin',
            'abbr' => 'BTC',
            'icon' => 'assets/media/icons/cryptocurrency/btc.svg',
            'min_confirmations' => 3,
            'min_amount' => 0.0005,
            'processing_comission' => 0,
            'network_comission' => null,
            'order' => 2,
        ],
        'ETH' => [
            'status' => true,
            'key' => 'ETH',
            'type' => 'crypto',
            'title' => 'Ethereum',
            'abbr' => 'ETH',
            'network' => 'Ethereum',
            'icon' => 'assets/media/icons/cryptocurrency/eth.svg',
            'min_confirmations' => 10,
            'min_amount' => 19,
            'processing_comission' => 10,
            'network_comission' => null,
            'order' => 3,
        ],
        'USDT' => [
            'status' => true,
            'key' => 'USDT',
            'type' => 'crypto',
            'title' => 'USDT ERC-20',
            'abbr' => 'USDT',
            'network' => 'Ethereum',
            'icon' => 'assets/media/icons/cryptocurrency/usdt.svg',
            'min_confirmations' => 19,
            'min_amount' => 10,
            'processing_comission' => 1,
            'network_comission' => null,
            'order' => 1,
        ],
        'USDTTRC' => [
            'status' => true,
            'key' => 'USDTTRC',
            'type' => 'crypto',
            'title' => 'USDT TRC-20',
            'abbr' => 'USDT',
            'network' => 'TRON',
            'icon' => 'assets/media/icons/cryptocurrency/usdt.svg',
            'min_confirmations' => 19,
            'min_amount' => 10,
            'processing_comission' => 0,
            'network_comission' => null,
            'order' => 0,
        ]
    ];

    public $type = 'crypto';

    public function __construct($currency)
    {
        $this->currency = $currency;
        $this->data = self::$currencies[$currency];
        $this->client = new Client(config('wallet.public_key'), config('wallet.private_key'));
    }

    public function generateAddress($label)
    {
        $result = null;

        try {
            $result = $this->client->generateAddress($this->currency, route('refill.ipn', ['uuid' => $label]), $label);
        } catch(CurrencyNotFoundException $e) {
            $result = [
                'status' => 0,
                'text' => 'Криптовалюта не найдена.'
            ];
        }

        return $result;
    }
}