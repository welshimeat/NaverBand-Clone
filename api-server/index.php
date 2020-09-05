<?php
require './pdos/BandPdo.php';
require './pdos/DatabasePdo.php';
require './pdos/IndexPdo.php';
require './pdos/UserPdo.php';
require './pdos/SocialPdo.php';

require './vendor/autoload.php';

use \Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler;

date_default_timezone_set('Asia/Seoul');
ini_set('default_charset', 'utf8mb4');

//에러출력하게 하는 코드
error_reporting(E_ALL); ini_set("display_errors", 1);

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    // UserController
    $r->addRoute('GET', '/users', ['UserController', 'getExistUserInfo']);
    $r->addRoute('POST', '/users', ['UserController', 'createUser']);
    //$r->addRoute('POST', '/posts', ['SocialController', 'createPost']);
    $r->addRoute('PATCH', '/users/{userid}', ['UserController', 'updateUser']);
    $r->addRoute('GET', '/autologin', ['MainController', 'getAutoLogin']); //09.03 자동 로그인 만듬(기성).
    $r->addRoute('GET', '/jwt', ['UserController', 'validateJwt']); //09.03 jwt 유효성 검사 만듬(기성).
    $r->addRoute('POST', '/jwt', ['UserController', 'createJwt']); //09.03 jwt 생성 만듬(기성).
    // IndexController
    $r->addRoute('GET', '/ads', ['IndexController', 'getAd']); //09.03 jwt에 맞게 수정함(기성).
    // BandController
    $r->addRoute('GET', '/bands', ['BandController', 'getUserBand']); //09.03 jwt에 맞게 수정함(기성).
    $r->addRoute('POST', '/band', ['BandController', 'createBand']); //09.03 band 생성 만듬(기성).
    $r->addRoute('PATCH', '/bandProfile/{bandid}', ['BandController', 'updateBandProfile']); //09.04 밴드 프로필 수정 만듬(기성).
    $r->addRoute('GET', '/band/{bandid}', ['BandController', 'getBandDetail']); //09.04 밴드 상세 정보 조회 만듬(기성).
    $r->addRoute('POST', '/enterpriseBand/{bandid}', ['BandController', 'createEnterpriseBand']); //09.04 사업자 밴드 생성 만듬(기성).
    $r->addRoute('PATCH', '/bandIntroduction/{bandid}', ['BandController', 'updateBandIntroduction']); //09.04 밴드 소개 수정 만듬(기성).
    $r->addRoute('POST', '/bandEnter', ['BandController', 'createBand']); //09.03 band 생성 만듬(기성).

    // SocialController
    //$r->addRoute('POST', '/band', ['SocialController', 'createPost']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

// 로거 채널 생성
$accessLogs = new Logger('ACCESS_LOGS');
$errorLogs = new Logger('ERROR_LOGS');
// log/your.log 파일에 로그 생성. 로그 레벨은 Info
$accessLogs->pushHandler(new StreamHandler('logs/access.log', Logger::INFO));
$errorLogs->pushHandler(new StreamHandler('logs/errors.log', Logger::ERROR));
// add records to the log
//$log->addInfo('Info log');
// Debug 는 Info 레벨보다 낮으므로 아래 로그는 출력되지 않음
//$log->addDebug('Debug log');
//$log->addError('Error log');

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        switch ($routeInfo[1][0]) {
            case 'IndexController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/IndexController.php';
                break;
            case 'BandController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/BandController.php';
                break;
            case 'UserController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/UserController.php';
                break;
            case 'SocialController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/SocialController.php';
                break;

        }

        break;
}
