<?php

namespace App\Traits\Providers;

use App\Helpers\Core as Helper;
use App\Models\Game;
use App\Models\GamesKey;
use App\Models\GgrGamesWorldSlot;
use App\Models\Order;
use App\Models\Provider;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Traits\Missions\MissionTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

trait NexosPlayTrait
{
    use MissionTrait;

    /**
     * @var string
     */
    protected static $agentCode;
    protected static $agentToken;
    protected static $agentSecretKey;
    protected static $apiEndpoint;

    /**
     * @return bool
     */
    public static function getCredentialsNexosPlay(): bool
    {
        $setting = GamesKey::first();

        self::$agentCode        = $setting->getAttributes()['games2_agent_code'];
        self::$agentToken       = $setting->getAttributes()['games2_agent_token'];
        self::$agentSecretKey   = $setting->getAttributes()['games2_agent_secret_key'];
        self::$apiEndpoint      = $setting->getAttributes()['games2_api_endpoint'];

        if (empty(self::$apiEndpoint)) {
            return false;
        }

        // if(substr(self::$apiEndpoint, -1) !== '/') {
        //     self::$apiEndpoint .= '/';
        // }

        return true;
    }

    /**
     * @param $rtp
     * @param $provider
     * @return void
     */
    public static function LoadingGamesNexosPlay()
    {
        if(self::getCredentialsNexosPlay()) {
            $postArray = [
                "agent_code" => "",
                "agent_token" => "",
                "user_code" => "test",
                "game_type" => "slot",
                "provider_code" => "PRAGMATIC",
                "game_code" => "vs20doghouse",
                "lang" => "en",
                "user_balance" => 1000
            ];

            $response = Http::withoutVerifying()->post(self::$apiEndpoint.'game_launch', $postArray);

            if($response->successful()) {
                $games = $response->json();

                dd($games);
            }
        }
    }

    /**
     * @param $rtp
     * @param $provider
     * @return void
     */
    public static function UpdateRTPNexosPlay($rtp, $provider)
    {
        if(self::getCredentialsNexosPlay()) {
            $postArray = [
                "method"        => "control_rtp",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
                "provider_code" => $provider,
                "user_code"     => auth('api')->id() . '',
                "rtp"           => $rtp
            ];

            $response = Http::withoutVerifying()->post(self::$apiEndpoint, $postArray);

            if($response->successful()) {

            }
        }
    }

    /**
     * Create User
     * Metodo para criar novo usuário
     *
     * @return bool
     */
    public static function createUserNexosPlay()
    {
        if(self::getCredentialsNexosPlay()) {
            $postArray = [
                "method"        => "user_create",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
                "user_code"     => auth('api')->id() . '',
            ];

            $response = Http::withoutVerifying()->post(self::$apiEndpoint, $postArray);

            if($response->successful()) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Iniciar Jogo
     * Metodo responsavel para iniciar o jogo
     *
     */
    public static function GameLaunchNexosPlay($provider_code, $game_code, $lang, $userId)
    {
        if(self::getCredentialsNexosPlay()) {
            $wallet = Wallet::where('user_id', $userId)->first();

            $postArray = [
                "method"        => "game_launch",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
                "agent_secret"  => self::$agentSecretKey,
                "user_code"     => $userId.'',
                "provider_code" => $provider_code,
                "game_code"     => $game_code,
                'user_balance'  => $wallet->total_balance,
                'game_type'     => 'slot',
                "lang"          => $lang
            ];

            //\DB::table('debug')->insert(['text' => json_encode($postArray)]);
            $response = Http::withoutVerifying()->post(self::$apiEndpoint, $postArray);

            if($response->successful()) {
                $data = $response->json();

                if($data['status'] == 0) {
                    if($data['msg'] == 'Invalid User') {
                        if(self::createUserNexosPlay()) {
                            return self::GameLaunchNexosPlay($provider_code, $game_code, $lang, $userId);
                        }
                    }
                }else{
                    return $data;
                }
            }else{
                return false;
            }
        }

    }

    /**
     * Get NexosPlay Balance
     * @return false|void
     */
    public static function getNexosPlayUserDetail()
    {
        if(self::getCredentialsNexosPlay()) {
            $dataArray = [
                "method"        => "call_players",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
            ];

            $response = Http::withoutVerifying()->post(self::$apiEndpoint, $dataArray);

            if($response->successful()) {
                $data = $response->json();

                dd($data);
            }else{
                return false;
            }
        }

    }

    /**
     * Get NexosPlay Balance
     * @param $provider_code
     * @param $game_code
     * @param $lang
     * @param $userId
     * @return false|void
     */
    public static function getNexosPlayBalance()
    {
        if(self::getCredentialsNexosPlay()) {
            $dataArray = [
                "method"        => "money_info",
                "agent_code"    => self::$agentCode,
                "agent_token"   => self::$agentToken,
            ];

            $response = Http::withoutVerifying()->post(self::$apiEndpoint, $dataArray);

            if($response->successful()) {
                $data = $response->json();

                return $data['agent']['balance'] ?? 0;
            }else{
                return false;
            }
        }

    }

    /**
     * Prepare Transaction
     * Metodo responsavel por preparar a transação
     *
     * @param $wallet
     * @param $userCode
     * @param $txnId
     * @param $betMoney
     * @param $winMoney
     * @param $gameCode
     * @return \Illuminate\Http\JsonResponse|void
     */
    private static function PrepareTransactionsNexosPlay($walletId, $userCode, $txnId, $betMoney, $winMoney, $gameCode, $providerCode)
    {
        $wallet = Wallet::find($walletId);
        $user = User::find($wallet->user_id);

        $typeAction  = 'bet';
        $changeBonus = 'balance';
        $bet = floatval($betMoney);


        /// deduz o saldo apostado
        if($wallet->balance_bonus > $bet) {
            $wallet->decrement('balance_bonus', $bet); /// retira do bonus
            $changeBonus = 'balance_bonus'; /// define o tipo de transação

        }elseif($wallet->balance > $bet) {
            $wallet->decrement('balance', $bet); /// retira do saldo depositado
            $changeBonus = 'balance'; /// define o tipo de transação

        }elseif($wallet->balance_withdrawal > $bet) {
            $wallet->decrement('balance_withdrawal', $bet); /// retira do saldo liberado pra saque
            $changeBonus = 'balance_withdrawal'; /// define o tipo de transação
        }else{
            return false;
        }


        /// criar uma transação
        $transaction = self::CreateTransactionsNexosPlay($userCode, time(), $txnId, $typeAction, $changeBonus, $bet, $gameCode, $gameCode);

        if($transaction) {
            /// salvar transação GGR
            GgrGamesWorldSlot::create([
                'user_id' => $userCode,
                'provider' => $providerCode,
                'game' => $gameCode,
                'balance_bet' => $bet,
                'balance_win' => 0,
                'currency' => $wallet->currency
            ]);

            return $transaction;
        }

        return false;
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public static function WebhooksNexosPlay($request)
    {
        switch ($request->method) {
            case "user_balance":
                return self::GetUserBalanceNexosPlay($request);
            case "game_callback":
                return self::GameCallbackNexosPlay($request);
            case "money_callback":
                return self::MoneyCallbackNexosPlay($request);
            default:
                return response()->json(['status' => 0]);
        }
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private static function GetUserBalanceNexosPlay($request)
    {
        $wallet = Wallet::where('user_id', $request->user_code)->where('active', 1)->first();
        if(!empty($wallet) && $wallet->total_balance > 0) {
            return response()->json([
                'status' => 1,
                'user_balance' => $wallet->total_balance
            ]);
        }

        return response()->json([
            'status' => 0,
            'msg' => "INVALID_USER"
        ]);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse|void|null
     */
    private static function GameCallbackNexosPlay($request)
    {
        $data = $request->all();
        try {
            if($data['game_type'] == 'slot' && isset($data['slot'])) {
                return self::ProcessPlayNexosPlay($data, $request->user_code,'slot');
            }

            if($data['game_type'] == 'live' && isset($data['live'])) {
                return self::ProcessPlayNexosPlay($data, $request->user_code, 'live');
            }

            return response()->json([
                'status' => 0,
                'msg' => 'INVALID_USER	'
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param $data
     * @param $userId
     * @param $type
     * @return \Illuminate\Http\JsonResponse|void
     */
    private static function ProcessPlayNexosPlay($data, $userId, $type)
    {
        $wallet = Wallet::where('user_id', $userId)->where('active', 1)->first();
        if(!empty($wallet)) {
            $game = Game::where('game_code', $data[$type]['game_code'])->first();

            /// verificar se é transação de vitoria duplicada
            $transactionWin = Order::where('transaction_id', $data[$type]['txn_id'])->where('type', 'win')->first();
            if(!empty($transactionWin)) {
                return response()->json([
                    'status' => 0,
                    'user_balance' => $wallet->total_balance,
                    'msg' => 'DUPLICATED_REQUEST'
                ]);
            }

            $transaction = Order::where('transaction_id', $data[$type]['txn_id'])->where('type', 'bet')->first();
            if(!empty($transaction)) {
                if(floatval($data[$type]['win']) > 0) {
                    GgrGamesWorldSlot::create([
                        'user_id' => $userId,
                        'provider' => $data[$type]['provider_code'],
                        'game' => $data[$type]['game_code'],
                        'balance_bet' => $transaction->amount,
                        'balance_win' => $data[$type]['win'],
                        'currency' => $wallet->currency
                    ]);

                    Helper::generateGameHistory(
                        $wallet->user_id,
                        'win',
                        $data[$type]['win'],
                        $transaction->amount,
                        $transaction->getAttributes()['type_money'],
                        $transaction->transaction_id
                    );

                    $wallet = Wallet::where('user_id', $userId)->where('active', 1)->first();
                    return response()->json([
                        'status' => 1,
                        'user_balance' => $wallet->total_balance,
                    ]);
                }else{
                    return response()->json([
                        'status' => 0,
                        'user_balance' => $wallet->total_balance,
                        'msg' => 'DUPLICATED_REQUEST'
                    ]);
                }
            }


            /// verificar se tem saldo
            if(floatval($wallet->total_balance) >= $data[$type]['bet']) {

                /// verificar se usuário tem desafio ativo
                self::CheckMissionExist($userId, $game, 'nexosplay');
                $transaction = self::PrepareTransactionsNexosPlay(
                    $wallet->id, $userId,
                    $data[$type]['txn_id'],
                    $data[$type]['bet'],
                    $data[$type]['win'],
                    $data[$type]['game_code'],
                    $data[$type]['provider_code']);

                if($transaction) {
                    /// verificar se é transação de vitoria duplicada
                    $transactionWin2 = Order::where('transaction_id', $data[$type]['txn_id'])->where('type', 'win')->first();
                    if(!empty($transactionWin2)) {
                        $wallet = Wallet::where('user_id', $userId)->where('active', 1)->first();
                        return response()->json([
                            'status' => 0,
                            'user_balance' => $wallet->total_balance,
                            'msg' => 'DUPLICATED_REQUEST'
                        ]);
                    }

                    $transaction = Order::where('transaction_id', $data[$type]['txn_id'])->where('type', 'bet')->first();
                    if(!empty($transaction)) {
                        if(floatval($data[$type]['win']) > 0) {
                            Helper::generateGameHistory(
                                $wallet->user_id,
                                'win',
                                $data[$type]['win'],
                                $transaction->amount,
                                $transaction->getAttributes()['type_money'],
                                $transaction->transaction_id
                            );

                            $wallet = Wallet::where('user_id', $userId)->where('active', 1)->first();
                            return response()->json([
                                'status' => 1,
                                'user_balance' => $wallet->total_balance,
                            ]);
                        }
                    }

                    Helper::generateGameHistory(
                        $wallet->user_id,
                        'loss',
                        $data[$type]['win'],
                        $transaction->amount,
                        $transaction->getAttributes()['type_money'],
                        $transaction->transaction_id
                    );


                    $wallet = Wallet::where('user_id', $userId)->where('active', 1)->first();
                    return response()->json([
                        'status' => 1,
                        'user_balance' => $wallet->total_balance,
                    ]);
                }else{
                    return response()->json([
                        'status' => 0,
                        'msg' => 'INSUFFICIENT_USER_FUNDS'
                    ]);
                }
            }
        }
    }

    /**
     * Money Callback NexosPlay
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private static function MoneyCallbackNexosPlay($request)
    {
        $data = $request->all();

        $transaction = Order::where('transaction_id', $data['txn_id'])->first();
        $wallet = Wallet::where('user_id', $transaction->user_id)->first();

        if(!empty($transaction) && !empty($wallet)) {

        }

        return response()->json([
            'status' => 1,
            'user_balance' => $wallet->total_balance
        ]);
    }


    /**
     * Create Transactions
     * Metodo para criar uma transação
     *
     * @return false
     */
    private static function CreateTransactionsNexosPlay($playerId, $betReferenceNum, $transactionID, $type, $changeBonus, $amount, $game, $pn)
    {

        $order = Order::create([
            'user_id'       => $playerId,
            'session_id'    => $betReferenceNum,
            'transaction_id'=> $transactionID,
            'type'          => $type,
            'type_money'    => $changeBonus,
            'amount'        => $amount,
            'providers'     => 'nexosplay',
            'game'          => $game,
            'game_uuid'     => $pn,
            'round_id'      => 1,
        ]);

        if($order) {
            return $order;
        }

        return false;
    }

    /**
     * Create User
     * Metodo para criar novo usuário
     *
     * @return bool
     */
    public static function getProviderNexosPlay($param)
    {
        if(self::getCredentialsNexosPlay()) {
            $response = Http::withoutVerifying()->post(self::$apiEndpoint, [
                'method' => 'provider_list',
                'agent_code' => self::$agentCode,
                'agent_token' => self::$agentToken,
                'game_type' => $param, ///  [slot, casino, pachinko]
            ]);

            if($response->successful()) {
                $data = $response->json();
                if(isset($data['status']) && $data['status'] == 1 && isset($data['providers'])) {
                    foreach ($data['providers'] as $provider) {
                        $checkProvider = Provider::where('code', $provider['code'])->where('distribution', 'nexosplay')->first();
                        if(empty($checkProvider)) {

                            $dataProvider = [
                                'code' => $provider['code'],
                                'name' => $provider['name'],
                                'rtp' => 90,
                                'status' => 1,
                                'distribution' => 'nexosplay',
                            ];

                            Provider::create($dataProvider);
                        }
                    }
                }
            }
        }
    }


    /**
     * Create User
     * Metodo para criar novo usuário
     *
     * @return bool
     */
    public static function getGamesNexosPlay()
    {
        if(self::getCredentialsNexosPlay()) {
            $providers = Provider::where('distribution', 'nexosplay')->get();
            foreach($providers as $provider) {
                $response = Http::withoutVerifying()->post(self::$apiEndpoint, [
                    'method' => 'game_list',
                    'agent_code' => self::$agentCode,
                    'agent_token' => self::$agentToken,
                    'provider_code' => $provider->code
                ]);

                if($response->successful()) {
                    $data = $response->json();

                    if(isset($data['games'])) {
                        foreach ($data['games'] as $game) {
                            $checkGame = Game::where('provider_id', $provider->id)->where('game_code', $game['game_code'])->first();
                            if(empty($checkGame)) {
                                if(!empty($game['img_url'])) {
                                    $image = self::uploadFromUrlNexosPlay($game['img_url'], $game['game_code']);
                                }else{
                                    $image = null;
                                }

                                if(!empty($game['game_code']) && !empty($game['game_name'])) {
                                    $data = [
                                        'provider_id'   => $provider->id,
                                        'game_id'       => $game['game_code'] . '-' . $provider->code,
                                        'game_code'     => $game['game_code'],
                                        'game_name'     => $game['game_name'],
                                        'technology'    => 'html5',
                                        'distribution'  => 'nexosplay',
                                        'rtp'           => 90,
                                        'cover'         => $image,
                                        'status'        => 1,
                                    ];

                                    Game::create($data);
                                }
                            } else {
                                // Update existing game
                                if(!empty($game['img_url']) && empty($checkGame->cover)) {
                                     $image = self::uploadFromUrlNexosPlay($game['img_url'], $game['game_code']);
                                     $checkGame->update(['cover' => $image]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    /**
     * @param $url
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private static function uploadFromUrlNexosPlay($url, $name = null)
    {
        try {
            $client = new \GuzzleHttp\Client(['verify' => false]);
            $response = $client->get($url);

            if ($response->getStatusCode() === 200) {
                $fileContent = $response->getBody();

                // Extrai o nome do arquivo e a extensão da URL
                $parsedUrl = parse_url($url);
                $pathInfo = pathinfo($parsedUrl['path']);
                //$fileName = $pathInfo['filename'] ?? 'file_' . time(); // Nome do arquivo
                $fileName  = $name ?? $pathInfo['filename'] ;
                $extension = $pathInfo['extension'] ?? 'png'; // Extensão do arquivo

                // Monta o nome do arquivo com o prefixo e a extensão
                $fileName = 'fivers/'.$fileName . '.' . $extension;

                // Salva o arquivo usando o nome extraído da URL
                Storage::disk('public')->put($fileName, $fileContent);

                return $fileName;
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

}

