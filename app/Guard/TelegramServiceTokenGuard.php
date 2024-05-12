<?php

declare(strict_types=1);

namespace App\Guard;


use App\Models\TelegramUser;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

/**
 * @property ?Authenticatable $user
 */
class TelegramServiceTokenGuard implements Guard
{
    use GuardHelpers;

    public final const INIT_DATA_HEADER_FIELD     = 'initData';

    public function __construct(private readonly Request $request)
    {
    }


    public function user(): ?Authenticatable
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $botToken = env('TELEGRAM_BOT_TOKEN');
        $initDataFromRequest = $this->request->header(self::INIT_DATA_HEADER_FIELD);

        if (empty($initDataFromRequest)) return null;

        try {
            $parsedData = $this->parse($initDataFromRequest);
            $user = json_decode($parsedData['user'], true);
        } catch (\Exception)  {
            return null;
        }

        $givenHash = $parsedData['hash'] ?? '';
        unset($parsedData['hash']);

        $preparedData = $this->prepare($parsedData);

        sort($preparedData);
        $dataCheckString = implode("\n", $preparedData);

        if ($this->checkHashValidation($dataCheckString, $botToken, $givenHash)) {
            return $this->user = TelegramUser::firstOrCreate([
                'chat_id' => $user['id'],
                'first_name' => $user['first_name'] ?? null,
                'last_name' => $user['last_name'] ?? null,
                'username' => $user['username'] ?? null,
            ]);
        }

        return null;
    }

    /**
     * @param array{} $credentials
     */
    public function validate(array $credentials = []): bool
    {
        return true;
    }

    private function parse(string $initData): array
    {
        return array_merge(...array_map(
            function ($item) {
                [$prop, $value] = explode('=', $item);
                return [$prop => $value];
            },
            explode('&', rawurldecode($initData))
        ));
    }

    private function prepare(array $parsedData): array
    {
        return array_map(
            fn($value, $key) => $key . '=' . $value,
            $parsedData,
            array_keys($parsedData)
        );
    }

    private function checkHashValidation(string $dataCheckString, string $botToken, string $givenHash): bool
    {
        $secretKey = hash_hmac('sha256', $botToken, 'WebAppData', true);
        $correctHash = bin2hex(hash_hmac('sha256', $dataCheckString, $secretKey, true));

        return $correctHash === $givenHash;
    }
}
