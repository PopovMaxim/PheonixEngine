<?php

namespace App\Modules\Refill\Payments\WestWallet;

use Illuminate\Http\Request;
use App\Modules\Refill\Entities\Refill;
use App\Modules\Refill\Payments\WestWallet\Client;
use App\Modules\Refill\Payments\WestWallet\CurrencyNotFoundException;

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
            'min_amount' => 0.0006,
            'processing_comission' => 0,
            'network_comission' => null,
            'rate' => null,
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
            'min_amount' => 0.015,
            'processing_comission' => 0.001,
            'network_comission' => null,
            'rate' => null,
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
            'min_amount' => 15,
            'processing_comission' => 0,
            'network_comission' => null,
            'rate' => null,
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
            'min_confirmations' => 1,
            'min_amount' => 15,
            'processing_comission' => 0,
            'network_comission' => null,
            'rate' => null,
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
            'min_confirmations' => 3,
            'min_amount' => 0.06,
            'processing_comission' => 0,
            'network_comission' => null,
            'rate' => null,
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
            'min_confirmations' => 3,
            'min_amount' => 70,
            'processing_comission' => 0,
            'network_comission' => null,
            'rate' => null,
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
            'min_confirmations' => 10,
            'min_amount' => 100,
            'processing_comission' => 5,
            'network_comission' => null,
            'rate' => 1,
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
            'min_amount' => 15,
            'processing_comission' => 0,
            'network_comission' => null,
            'rate' => 1,
            'order' => 0,
        ]
    ];

    public $type = 'crypto';

    public $client;

    public function __construct($currency = null)
    {
        $this->currency = $currency;

        if (!is_null($currency)) {
            $this->data = self::$currencies[$currency];
        }

        $this->client = new Client(config('wallet.public_key'), config('wallet.private_key'));
    }

    public function generateAddress($data = [])
    {
        $result = null;

        try {
            $result = $this->client->generateAddress($this->currency, route('refill.ipn', ['uuid' => $data['id'], 'type' => $data['type']]), $data['id']);
        } catch(CurrencyNotFoundException $e) {
            $result = [
                'status' => 0,
                'text' => 'Криптовалюта не найдена.'
            ];
        }

        return $result;
    }

    public function ipn($data) {
        if (!isset($data['label'])) {
            return 0;
        }

        $uuid = $data['label'];

        $tx = Refill::query()
            ->whereType('refill')
            //->whereStatus('pending')
            ->whereId($uuid)
            ->first();

        if (is_null($tx)) {
            return 0;
        }

        if ($tx['status'] == 'completed' || $tx['status'] == 'canceled') {
            return 0;
        }

        $details = $tx['details'];

        $details['gateway']['id'] = $data['id'];
        $details['gateway']['dest_tag'] = $data['dest_tag'];
        $details['gateway']['label'] = $data['label'];
        $details['gateway']['amount'] = $data['amount'];
        $details['gateway']['currency'] = $data['currency'];
        $details['gateway']['status'] = $data['status'];
        $details['gateway']['blockchain_confirmations'] = $data['blockchain_confirmations'];
        $details['gateway']['fee'] = $data['fee'];
        $details['gateway']['blockchain_hash'] = $data['blockchain_hash'];

        $amount = 0;

        $rate = self::$currencies[$data['currency']]['rate'];

        if ($data['status'] == 'completed') {
            $abbr = self::$currencies[$data['currency']]['abbr'];

            if (is_null($rate)) {
                $rate_query = json_decode(file_get_contents("https://api.binance.com/api/v3/ticker/price?symbol={$abbr}USDT"), true);
                $rate = $rate_query['price'];
            }
        }

        $details['gateway']['rate'] = $rate;

        $amount = $data['amount'] * $rate;
        $amount = sprintf("%01.2f", $amount);
        $amount = number_format($amount, 2, '', '');

        $tx->update([
            'amount' => $amount,
            'status' => $data['status'],
            'details' => $details,
        ]);
    }
}