<?php declare(strict_types=1);

namespace App\Bot;

use App\Curl\Curl;
use Symfony\Component\HttpFoundation\Request;

final class FacebookBot implements Bot
{
    /**
     * @var string
     */
    private const URL = 'https://graph.facebook.com/v2.6/me/messages';

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Curl
     */
    private $curl;

    public function __construct(Request $request, Curl $curl)
    {
        $this->request = $request;
        $this->curl = $curl;
        $this->verify();
    }

    public function message(): ?string
    {
        return $this->content()['entry'][0]['messaging'][0]['message']['text'];
    }

    /**
     * @inheritdoc
     */
    public function nlp(): ?array
    {
        return $this->content()['entry'][0]['messaging'][0]['message']['nlp'];
    }

    public function send(string $reply): void
    {
        $this->curl->post(
            self::URL,
            [
                'recipient' => ['id' => $this->senderId()],
                'message' => ['text' => $reply],
            ],
            ['access_token' => getenv('ACCESS_TOKEN')],
            ['Content-Type: application/json']
        );
    }

    private function senderId(): string
    {
        return $this->content()['entry'][0]['messaging'][0]['sender']['id'];
    }

    /**
     * @return mixed[]
     */
    private function content(): array
    {
        if (! $this->request->getContent()) {
            return [];
        }

        return json_decode($this->request->getContent(), true);
    }

    private function verify(): void
    {
        if ($this->request->isMethod('GET') &&
            $this->request->query->get('hub_mode') === 'subscribe' &&
            $this->request->query->get('hub_verify_token') === getenv('VERIFY_TOKEN')) {
            echo $this->request->query->get('hub_challenge');
            exit;
        }
    }
}
