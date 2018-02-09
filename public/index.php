<?php declare(strict_types=1);

use App\Bot\FacebookBot;
use App\BotMaster;
use App\Curl\Curl;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../vendor/autoload.php';

(new Dotenv())->load(__DIR__.'/../.env');

Debug::enable();

$request = Request::createFromGlobals();
$curl = new Curl();

$botMaster = new BotMaster(new FacebookBot($request, $curl));
$botMaster->addReply('hi', 'Hey, how r u?');
$botMaster->addReply('how much is it?', '1250 $');
$botMaster->tryToAnswer();
