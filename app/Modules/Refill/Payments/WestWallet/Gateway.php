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
        'TRX' => [
            'status' => true,
            'key' => 'TRX',
            'type' => 'crypto',
            'title' => 'Tron',
            'abbr' => 'TRX',
            'network' => 'TRON',
            'icon' => 'assets/media/icons/cryptocurrency/trx.svg',
            'min_confirmations' => 19,
            'min_amount' => 10,
            'processing_comission' => 0,
            'network_comission' => null,
            'order' => 4,
        ],
        'XRP' => [
            'status' => true,
            'key' => 'XRP',
            'type' => 'crypto',
            'title' => 'Ripple',
            'abbr' => 'XRP',
            'network' => 'Ripple',
            'icon' => 'assets/media/icons/cryptocurrency/xrp.svg',
            'min_confirmations' => 19,
            'min_amount' => 10,
            'processing_comission' => 0,
            'network_comission' => null,
            'order' => 5,
        ],
        'LTC' => [
            'status' => true,
            'key' => 'LTC',
            'type' => 'crypto',
            'title' => 'Litecoin',
            'abbr' => 'LTC',
            'network' => 'Litecoin',
            'icon' => 'assets/media/icons/cryptocurrency/ltc.svg',
            'min_confirmations' => 19,
            'min_amount' => 10,
            'processing_comission' => 0,
            'network_comission' => null,
            'order' => 6,
        ],
        'DOGE' => [
            'status' => true,
            'key' => 'DOGE',
            'type' => 'crypto',
            'title' => 'Doge Coin',
            'abbr' => 'DOGE',
            'network' => 'Dogecoin',
            'icon' => 'assets/media/icons/cryptocurrency/doge.svg',
            'min_confirmations' => 19,
            'min_amount' => 10,
            'processing_comission' => 0,
            'network_comission' => null,
            'order' => 7,
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
            'icon' => 'assets/media/icons/cryptocurrency/usdttrc.svg',
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