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
    }

    /**
     * @inheritdoc
     */
    public function tryToAnswer(array $replies): void
    {
        if (array_key_exists($this->message(), $replies)) {
            $this->send($replies[$this->message()]);
        }
    }

    private function message(): ?string
    {
        return $this->content()['entry'][0]['messaging'][0]['message']['text'];
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
        return json_decode($this->request->getContent(), true);
    }

    private function send(string $answer): void
    {
        $this->curl->post(
            self::URL,
            [
                'recipient' => ['id' => $this->senderId()],
                'message' => ['text' => $answer],
            ],
            ['access_token' => getenv('ACCESS_TOKEN')],
            ['Content-Type: application/json']
        );
    }
}
