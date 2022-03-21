<?php

namespace Cryptows\Classes;

use Cryptows\Classes\Config;

class Api
{

    public function runCurl(string $url, array $data)
    {
        $config = new Config();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.coingecko.com/api/v3' . $url . '?' . http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
       // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $config->getConfig()->use_ssl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $config->getConfig()->use_ssl);

        $headers = array();
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }

    public function Helper(string $chapter, string $apiFuncName, bool $all)
    {
        $data = [
            'ping' => [
                'ping' => [
                    'description' => 'Check API server status',
                    'url' => '/ping',
                    'params' => false,
                ],
            ], //end ping chapter

            'simple' => [
                'simplePrice' => [
                    'description' => 'Get the current price of any cryptocurrencies in any other supported currencies that you need.',
                    'url' => '/simple/price',
                    'params' => [
                        'ids' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'id of coins, comma-separated if querying more than 1 coin. *refers to coins/list',
                        ],

                        'vs_currencies' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'vs_currency of coins, comma-separated if querying more than 1 vs_currency. *refers to simple/supported_vs_currencies',
                        ],
                        'include_market_cap' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'true/false to include market_cap, default: false',
                        ],

                        'include_24hr_vol' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'true/false to include 24hr_vol, default: false',
                        ],
                        'include_24hr_change' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'true/false to include 24hr_change, default: false',
                        ],
                        'include_last_updated_at' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'true/false to include last_updated_at of price, default: false',
                        ],
                    ],
                ],

                'simpleTokenPriceId' => [
                    'description' => 'Get current price of tokens (using contract addresses) for a given platform in any other currency that you need.',
                    'url' => '/simple/token_price/{id}',
                    'params' => [
                        'id ' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The id of the platform issuing tokens (See asset_platforms endpoint for list of options)',
                        ],
                        'contract_addresses' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The contract address of tokens, comma separated',
                        ],
                        'vs_currencies' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'vs_currency of coins, comma-separated if querying more than 1 vs_currency. *refers to simple/supported_vs_currencies',
                        ],
                        'include_market_cap' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'true/false to include market_cap, default: false',
                        ],

                        'include_24hr_vol' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'true/false to include 24hr_vol, default: false',
                        ],
                        'include_24hr_change' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'true/false to include 24hr_change, default: false',
                        ],
                        'include_last_updated_at' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'true/false to include last_updated_at of price, default: false',
                        ],
                    ],
                ],

                'simpleSupportedVsCurrencies' => [
                    'description' => 'Get list of supported_vs_currencies.',
                    'url' => '/simple/supported_vs_currencies',
                    'params' => false,
                ],
            ], //end simple chapter

            'coins' => [

                'coinsList' => [
                    'description' => 'List all supported coins id, name and symbol (no pagination required). Use this to obtain all the coins id in order to make API calls',
                    'url' => '/coins/list',
                    'params' => [
                        'include_platform' => (object) [
                            'type' => 'boolean',
                            'required' => '',
                            'descr' => 'flag to include platform contract addresses (eg. 0x.... for Ethereum based tokens). valid values: true, false',
                        ],
                    ],
                ],

                'coinsMarkets' => [
                    'description' => 'List all supported coins price, market cap, volume, and market related data. Use this to obtain all the coins market data (price, market cap, volume)',
                    'url' => '/coins/markets',
                    'params' => [
                        'vs_currency' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The target currency of market data (usd, eur, jpy, etc.)',
                        ],
                        'ids' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'The ids of the coin, comma separated crytocurrency symbols (base). refers to /coins/list. When left empty, returns numbers the coins observing the params limit and start',
                        ],
                        'category' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'filter by coin category. Refer to /coin/categories/list',
                        ],
                        'order' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'valid values: market_cap_desc, gecko_desc, gecko_asc, market_cap_asc, market_cap_desc, volume_asc, volume_desc, id_asc, id_desc. sort results by
                         field. Default value : market_cap_desc',
                        ],
                        'per_page' => (object) [
                            'type' => 'int',
                            'required' => 'required',
                            'descr' => 'valid values: 1..250. Total results per page. Default value : 100',
                        ],
                        'page' => (object) [
                            'type' => 'int',
                            'required' => '',
                            'descr' => 'Page through results. Default value : 1',
                        ],
                        'sparkline' => (object) [
                            'type' => 'boolean',
                            'required' => '',
                            'descr' => 'Include sparkline 7 days data (eg. true, false). Default value : false',
                        ],
                        'price_change_percentage' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'Include price change percentage in 1h, 24h, 7d, 14d, 30d, 200d, 1y (eg. \'1h,24h,7d\' comma-separated, invalid values will be discarded)',
                        ],
                    ],

                ],

                'coinsId' => [
                    'description' => 'Get current data (name, price, market, ... including exchange tickers) for a coin. Get current data (name, price, market, ... including exchange tickers) for a coin. 
<br><b>IMPORTANT:</b><br>
Ticker object is limited to 100 items, to get more tickers, use /coins/{id}/tickers<br>
Ticker is_stale is true when ticker that has not been updated/unchanged from the exchange for a while.<br>
Ticker is_anomaly is true if ticker\'s price is outliered by our system.<br>
You are responsible for managing how you want to display these information (e.g. footnote, different background, change opacity, hide)',
                    'url' => '/coins/{id}',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the coin id (can be obtained from /coins) eg. bitcoin',
                        ],
                        'localization' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'Include all localized languages in response (true/false) [default: true]',
                        ],
                        'tickers' => (object) [
                            'type' => 'boolean',
                            'required' => '',
                            'descr' => 'Include tickers data (true/false) [default: true]',
                        ],
                        'market_data' => (object) [
                            'type' => 'boolean',
                            'required' => '',
                            'descr' => 'Include market_data (true/false) [default: true]',
                        ],
                        'community_data' => (object) [
                            'type' => 'boolean',
                            'required' => '',
                            'descr' => 'Include community_data data (true/false) [default: true]',
                        ],
                        'developer_data' => (object) [
                            'type' => 'boolean',
                            'required' => '',
                            'descr' => 'Include developer_data data (true/false) [default: true]',
                        ],
                        'sparkline' => (object) [
                            'type' => 'boolean',
                            'required' => '',
                            'descr' => 'Include sparkline 7 days data (eg. true, false) [default: false]',
                        ],
                    ],
                ],

                'coinsIdTickers' => [
                    'description' => 'Get coin tickers (paginated to 100 items). <br><b>IMPORTANT:</b><br>
Ticker <b>is_stale</b> is true when ticker that has not been updated/unchanged from the exchange for a while.<br>
Ticker <b>is_anomaly</b> is true if ticker\'s price is outliered by our system.<br>
You are responsible for managing how you want to display these information (e.g. footnote, different background, change opacity, hide)',
                    'url' => '/coins/{id}/tickers',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the coin id (can be obtained from /coins/list) eg. bitcoin',
                        ],
                        'exchange_ids' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'filter results by exchange_ids (ref: v3/exchanges/list)',
                        ],

                        'include_exchange_logo' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'flag to show exchange_logo',
                        ],

                        'page' => (object) [
                            'type' => 'int',
                            'required' => '',
                            'descr' => 'Page through results',
                        ],

                        'order' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'valid values: trust_score_desc (default), trust_score_asc and volume_desc',
                        ],

                        'depth' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'flag to show 2% orderbook depth. valid values: true, false',
                        ],

                    ],
                ],

                'coinsIdHistory' => [
                    'description' => 'Get historical data (name, price, market, stats) at a given date for a coin',
                    'url' => '/coins/{id}/history',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the coin id (can be obtained from /coins/list) eg. bitcoin',
                        ],

                        'date ' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The date of data snapshot in dd-mm-yyyy eg. 30-12-2017',
                        ],

                        'localization' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'Set to false to exclude localized languages in response',
                        ],

                    ],
                ],

                'coinsIdMarketChart' => [
                    'description' => 'Get historical market data include price, market cap, and 24h volume (granularity auto). Minutely data will be used for duration within 1 day, Hourly data will be used for duration between 1 day and 90 days, Daily data will be used for duration above 90 days.',
                    'url' => '/coins/{id}/market_chart',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the coin id (can be obtained from /coins/list) eg. bitcoin',
                        ],

                        'vs_currency ' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The target currency of market data (usd, eur, jpy, etc.)',
                        ],

                        'days ' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'Data up to number of days ago (eg. 1,14,30,max)',
                        ],

                        'interval' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'Data interval. Possible value: daily',
                        ],

                    ],
                ],

                'coinsIdMarketChartRange' => [
                    'description' => 'Get historical market data include price, market cap, and 24h volume within a range of timestamp (granularity auto).<br>
<ul>
<li>Data granularity is automatic (cannot be adjusted)</li>
<li>1 day from query time = 5 minute interval data</li>
<li>1 - 90 days from query time = hourly data</li>
<li>above 90 days from query time = daily data (00:00 UTC)</li>
</ul>',
                    'url' => '/coins/{id}/market_chart/range',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the coin id (can be obtained from /coins/list) eg. bitcoin',
                        ],

                        'vs_currency ' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The target currency of market data (usd, eur, jpy, etc.)',
                        ],

                        'from' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'From date in UNIX Timestamp (eg. 1392577232)',
                        ],

                        'to' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'To date in UNIX Timestamp (eg. 1422577232)',
                        ],

                    ],
                ],

                'coinsIdOhlc' => [
                    'description' => 'Get coin\'s OHLC.<br>
Candle\'s body:<br>

1 - 2 days: 30 minutes<br>
3 - 30 days: 4 hours<br>
31 and before: 4 days<br>
',
                    'url' => '/coins/{id}/ohlc',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the coin id (can be obtained from /coins/list) eg. bitcoin',
                        ],

                        'vs_currency ' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The target currency of market data (usd, eur, jpy, etc.)',
                        ],

                        'days' => (object) [
                            'type' => 'int',
                            'required' => 'required',
                            'descr' => 'Data up to number of days ago (1/7/14/30/90/180/365/max)',
                        ],

                    ],
                ],

            ], //end coins chapter

            'contract' => [

                'coinsIdContractContractAddress' => [
                    'description' => 'Get coin info from contract address',
                    'url' => '/coins/{id}/contract/{contract_address}',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'Asset platform (See asset_platforms endpoint for list of options)',
                        ],

                        'contract_address' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'Token\'s contract address',
                        ],
                    ],
                ],

                'coinsIdContractContractAddressMarketChart' => [
                    'description' => 'Get historical market data include price, market cap, and 24h volume (granularity auto) from a contract address ',
                    'url' => '/coins/{id}/contract/{contract_address}/market_chart',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The id of the platform issuing tokens (See asset_platforms endpoint for list of options)',
                        ],

                        'contract_address' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'Token\'s contract address',
                        ],

                        'vs_currency' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The target currency of market data (usd, eur, jpy, etc.)',
                        ],

                        'days' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'Data up to number of days ago (eg. 1,14,30,max)',
                        ],
                    ],
                ],

                'coinsIdContractContractAddressMarketChartRange' => [
                    'description' => 'Get historical market data include price, market cap, and 24h volume within a range of timestamp (granularity auto) from a contract address',
                    'url' => '/coins/{id}/contract/{contract_address}/market_chart/range',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The id of the platform issuing tokens (See asset_platforms endpoint for list of options)',
                        ],

                        'contract_address' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'Token\'s contract address',
                        ],

                        'vs_currency' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'The target currency of market data (usd, eur, jpy, etc.)',
                        ],

                        'from' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'From date in UNIX Timestamp (eg. 1392577232)',
                        ],

                        'to' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'To date in UNIX Timestamp (eg. 1422577232)',
                        ],
                    ],
                ],

            ], //end contract chapter

            'assetPlatforms' => [

                'assetPlatforms' => [
                    'description' => 'List all asset platforms (Blockchain networks)',
                    'url' => '/asset_platforms',
                    'params' => false,
                ],

            ], //end asset_platforms chapter

            'categories' => [

                'coinsCategoriesList' => [
                    'description' => 'List all categories',
                    'url' => '/coins/categories/list',
                    'params' => false,
                ],

                'coinsCategories' => [
                    'description' => 'List all categories with market data',
                    'url' => '/coins/categories',
                    'params' => [
                        'order' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'valid values: market_cap_desc (default), market_cap_asc, name_desc, name_asc, market_cap_change_24h_desc and market_cap_change_24h_asc',
                        ],
                    ],
                ],

            ], //end categories chapter

            'exchanges' => [

                'exchanges' => [
                    'description' => 'List all exchanges',
                    'url' => '/exchanges',
                    'params' => [
                        'per_page' => (object) [
                            'type' => 'int',
                            'required' => '',
                            'descr' => 'Valid values: 1...250 <br> Total results per page <br> Default value:: 100',
                        ],

                        'page' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'page through results',
                        ],
                    ],
                ],

                'exchangesList' => [
                    'description' => 'List all supported markets id and name (no pagination required)',
                    'url' => '/exchanges/list',
                    'params' => false,
                ],

                'exchangesId' => [
                    'description' => 'Get exchange volume in BTC and top 100 tickers only. IMPORTANT: <br> 
Ticker object is limited to 100 items, to get more tickers, use <b>/exchanges/{id}/tickers</b><br>
Ticker <b>is_stale</b> is true when ticker that has not been updated/unchanged from the exchange for a while.<br>
Ticker <b>is_anomaly</b> is true if ticker\'s price is outliered by our system.<br>
You are responsible for managing how you want to display these information (e.g. footnote, different background, change opacity, hide)',
                    'url' => '/exchanges/{id}',
                    'params' => [
                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the exchange id (can be obtained from /exchanges/list) eg. binance',
                        ],
                    ],
                ],

                'exchangesIdTickers' => [
                    'description' => 'Get exchange tickers (paginated, 100 tickers per page). IMPORTANT:<br>
Ticker <b>is_stale</b> is true when ticker that has not been updated/unchanged from the exchange for a while.<br>
Ticker <b>is_anomaly</b> is true if ticker\'s price is outliered by our system.<br>
You are responsible for managing how you want to display these information (e.g. footnote, different background, change opacity, hide)',
                    'url' => '/exchanges/{id}/tickers',
                    'params' => [

                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the exchange id (can be obtained from /exchanges/list) eg. binance',
                        ],

                        'coin_ids' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'filter tickers by coin_ids (ref: v3/coins/list)',
                        ],

                        'include_exchange_logo' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'flag to show exchange_logo',
                        ],

                        'page' => (object) [
                            'type' => 'int',
                            'required' => '',
                            'descr' => 'Page through results',
                        ],

                        'depth' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'flag to show 2% orderbook depth i.e., cost_to_move_up_usd and cost_to_move_down_usd',
                        ],

                        'order' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'valid values: trust_score_desc (default), trust_score_asc and volume_desc',
                        ],

                    ],
                ],

                'exchangesIdVolumeChart' => [
                    'description' => 'Get volume_chart data for a given exchange',
                    'url' => '',
                    'params' => [

                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the exchange id (can be obtained from /exchanges/list) eg. binance',
                        ],

                        'days' => (object) [
                            'type' => 'int',
                            'required' => 'required',
                            'descr' => 'Data up to number of days ago (eg. 1,14,30)',
                        ],
                    ],
                ],

            ], //end exchanges chapter

            'indexes' => [

                'indexes' => [
                    'description' => 'List all market indexes',
                    'url' => '/indexes',
                    'params' => [

                        'per_page' => (object) [
                            'type' => 'int',
                            'required' => '',
                            'descr' => 'Total results per page',
                        ],

                        'page' => (object) [
                            'type' => 'int',
                            'required' => '',
                            'descr' => 'Page through results',
                        ],

                    ],
                ],

                'indexesMarketIdId' => [
                    'description' => 'get market index by market id and index id',
                    'url' => '/indexes/{market_id}/{id}',
                    'params' => [

                        'market_id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the market id (can be obtained from /exchanges/list)',
                        ],

                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the index id (can be obtained from /indexes/list)',
                        ],
                    ],
                ],

                'indexesList' => [
                    'description' => 'list market indexes id and name',
                    'url' => '/indexes/list',
                    'params' => false,
                ],

            ], //end indexes chapter

            'derivatives' => [

                'derivatives' => [
                    'description' => 'List all derivative tickers',
                    'url' => '/derivatives',
                    'params' => [

                        'include_tickers' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => '[\'all\', \'unexpired\'] - expired to show unexpired tickers, all to list all tickers, defaults to unexpired',
                        ],
                    ],
                ],

                'derivativesExchanges' => [
                    'description' => 'List all derivative exchanges',
                    'url' => '/derivatives/exchanges',
                    'params' => [

                        'order' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'order results using following params name_asc，name_desc，open_interest_btc_asc，open_interest_btc_desc，trade_volume_24h_btc_asc，trade_volume_24h_btc_desc',
                        ],


                        'per_page' => (object) [
                            'type' => 'int',
                            'required' => '',
                            'descr' => 'Total results per page',
                        ],


                        'page' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'Page through results',
                        ],
                    ],
                ],

                'derivativesExchangesId' => [
                    'description' => 'show derivative exchange data',
                    'url' => '/derivatives/exchanges/{id}',
                    'params' => [

                        'id' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'pass the exchange id (can be obtained from derivatives/exchanges/list) eg. bitmex',
                        ],

                        '' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => '[\'all\', \'unexpired\'] - expired to show unexpired tickers, all to list all tickers, leave blank to omit tickers data in response',
                        ],
                    ],
                ],

                'derivativesExchangesList' => [
                    'description' => 'List all derivative exchanges name and identifier',
                    'url' => '/derivatives/exchanges/list',
                    'params' => false,
                ],

            ], //end derivatives chapter

            'exchangeRates' => [

                'exchangeRates' => [
                    'description' => 'Get BTC-to-Currency exchange rates',
                    'url' => '/exchange_rates',
                    'params' => false,
                ],

            ], // end exchangeRates chapter

            'search' => [

                'search' => [
                    'description' => 'Search for coins, categories and markets on CoinGecko',
                    'url' => '/search',
                    'params' => [

                        'query' => (object) [
                            'type' => 'string',
                            'required' => 'required',
                            'descr' => 'Search string',
                        ],
                    ],
                ],

            ], // end search chapter

            'trending' => [

                'searchTrending' => [
                    'description' => 'Get trending search coins (Top-7) on CoinGecko in the last 24 hours',
                    'url' => '/search/trending',
                    'params' => false,
                ],

            ], //end trending chapter

            'global' => [

                'global' => [
                    'description' => 'Get cryptocurrency global data',
                    'url' => '/global',
                    'params' => false,
                ],

                'globalDecentralizedFinanceDefi' => [
                    'description' => 'Get Top 100 Cryptocurrency Global Eecentralized Finance(defi) data',
                    'url' => '/global/decentralized_finance_defi',
                    'params' => false,
                ],

            ], //end global chapter

            'companies' => [

                'companiesPublicTreasuryCoinId' => [
                    'description' => '<h2>BETA!</h2><br>Get public companies bitcoin or ethereum holdings (Ordered by total holdings descending)',
                    'url' => '/companies/public_treasury/{coin_id}',
                    'params' => [

                        'coin_id' => (object) [
                            'type' => 'string',
                            'required' => '',
                            'descr' => 'bitcoin or ethereum',
                        ],
                    ],
                ],

            ], // end companies chapter

        ];

        if($all === true) {

            return $data;

        } else {
            if((!empty($chapter)) && (empty($apiFuncName))) {

                if(!empty($data[$chapter])) {

                    return $data[$chapter];

                } else {

                    return strval('Incorrect parameters');

                }


            } else if((!empty($chapter)) && (!empty($apiFuncName))) {

                if(!empty($data[$chapter][$apiFuncName])) {

                    return $data[$chapter][$apiFuncName];

                } else {

                    return strval('Incorrect parameters');

                }

            } else {
                return strval('Incorrect parameters');
            }
        }
    }

    public function callApi(string $chapter, string $funcName, array $request)
    {

        $getParams = $this->Helper($chapter, $funcName, false);
        $params = $getParams['params'];
        $url = $getParams['url'];

        if(!$params ) {

            return $this->runCurl($url, []);

        } else {

            $filtered = array_keys($params);
            $new = [];

            foreach($request as $item => $value) {
                foreach ($filtered as $filter => $val) {
                    if((trim($val) == trim($item)) && ($value != false)) {
                        $new[trim($val)] = str_replace(' ', '', $value);
                    }

                }
            }

            return $this->runCurl($url, $new);
        }

    }

}