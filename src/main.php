<?php
require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use TelegramBot\Api\BotApi;


$envPath = realpath(__DIR__ . '/../');
if (!$envPath) {
    die('.env file not found');    
}
// Load env variables
(Dotenv\Dotenv::createImmutable($envPath))->load(); // Create a new immutable dotenv instance with default repository

$token = $_ENV['TOKEN'];
$adminId = $_ENV['ADMIN_ID'];

$bot = new BotApi($token);

try {
    $bot->on(function (\TelegramBot\Api\Types\Update $update) use ($bot) {
        $message = $update->getMessage();
        $id = $message->getChat()->getId();
        $bot->sendMessage($id, $message->getText());
    }, function () {
        return true;
    });

    $bot->run();
} catch (\Exception $e) {
    throw new \Exception($e->getMessage());
}
