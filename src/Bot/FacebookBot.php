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
        return $this->messaging()['message']['text'];
    }

    /**
     * @inheritdoc
     */
    public function entities(): array
    {
        return $this->messaging()['message']['nlp']['entities'];
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

    private function verify(): void
    {
        if ($this->request->isMethod('GET') &&
            $this->request->query->get('hub_mode') === 'subscribe' &&
            $this->request->query->get('hub_verify_token') === getenv('VERIFY_TOKEN')) {
            echo $this->request->query->get('hub_challenge');
            exit;
        }
    }

    private function senderId(): string
    {
        return $this->messaging()['sender']['id'];
    }

    /**
     * @return string[]
     */
    private function content(): array
    {
        if (! $this->request->getContent()) {
            return [];
        }

        return json_decode($this->request->getContent(), true);
    }

    /**
     * @return string[]
     */
    private function entry(): array
    {
        return $this->content()['entry'][0];
    }

    /**
     * @return string[]
     */
    private function messaging(): array
    {
        return $this->entry()['messaging'][0];
    }
}
