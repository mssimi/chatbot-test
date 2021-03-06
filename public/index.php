<?php declare(strict_types=1);

use App\Answerer\BasicAnswerer;
use App\Answerer\NLPAnswerer;
use App\Bot\FacebookBot;
use App\ReplyManager;
use App\Curl\Curl;
use App\EntityResolver\CostOfGoods\Adapter\JsonCostOfGoodsAdapter;
use App\EntityResolver\CostOfGoods\CostOfGoodsResolver;
use App\EntityResolver\Greetings\Adapter\JsonGreetingsAdapter;
use App\EntityResolver\Greetings\GreetingsResolver;
use App\EntityResolver\Reminder\Adapter\TextReminderAdapter;
use App\EntityResolver\Reminder\ReminderResolver;
use App\Validator\FacebookValidator;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

$projectDir = __DIR__.'/../';

require $projectDir.'vendor/autoload.php';

(new Dotenv())->load($projectDir.'.env');

if($_SERVER['DEBUG']){
    Debug::enable();
}

$request = Request::createFromGlobals();
$curl = new Curl();
$facebookValidator = new FacebookValidator();

$facebookBot = new FacebookBot($request, $curl, $facebookValidator);

$jsonGreetingsAdapter = new JsonGreetingsAdapter(sprintf('%sconfig/greetings.json', $projectDir));
$textReminderAdapter = new TextReminderAdapter(sprintf('%sconfig/reminder.txt', $projectDir));
$jsonCostOfGoodsAdapter = new JsonCostOfGoodsAdapter(sprintf('%sconfig/products.json', $projectDir));

$nlpAnswerer = new NLPAnswerer($facebookBot);
$nlpAnswerer->addEntityResolver('greetings', new GreetingsResolver($jsonGreetingsAdapter, 0.75));
$nlpAnswerer->addEntityResolver('custom_reminder', new ReminderResolver($textReminderAdapter, 0.75));
$nlpAnswerer->addEntityResolver('cost_of_goods', new CostOfGoodsResolver($jsonCostOfGoodsAdapter, 0.75));

$basicAnswerer = new BasicAnswerer($facebookBot);
$basicAnswerer->addReply('Neviděla jste tudy jít děti?', 'Pleju len.');
$basicAnswerer->addReply('Hele vole, kde mám káru?', 'Na orbitě:D');

$replyManager = new ReplyManager();
$replyManager->addAnswerer($nlpAnswerer);
$replyManager->addAnswerer($basicAnswerer);
$replyManager->reply();

