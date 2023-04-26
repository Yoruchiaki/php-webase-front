# PHP-WEBASE-FRONT
## 提示
# !!!本项目处于开发中,接口和调用方式仍会发生改变!!!
## 项目

### 本项目提供对 Webase-Front-Node 前置服务的接口调用
### 针对Laravel提供开箱可用的支持
## 安装

```shell
$ composer require yoruchiaki/php-webase-front
```

## 已完成的(已完成E2E测试)

- 合约接口 [Abi](src%2FServices%2FAbi)
- 密钥接口 [PrivateKey](src%2FServices%2FPrivateKey)
- 交易接口 [Trans](src%2FServices%2FTrans)
- 工具接口 [Tool](src%2FServices%2FTool)

## 未完成的(删除代表已完成)

- ~~[AbiInterface.php](src%2FInterfaces%2FAbiInterface.php)~~
- [BaseServiceInterface.php](src%2FInterfaces%2FBaseServiceInterface.php)
- [CertInterface.php](src%2FInterfaces%2FCertInterface.php)
- [ChargingInterface.php](src%2FInterfaces%2FChargingInterface.php)
- [ContractInterface.php](src%2FInterfaces%2FContractInterface.php)
- [ContractStoreInterface.php](src%2FInterfaces%2FContractStoreInterface.php)
- [EncryptInterface.php](src%2FInterfaces%2FEncryptInterface.php)
- [EventInterface.php](src%2FInterfaces%2FEventInterface.php)
- [HttpRequestInterface.php](src%2FInterfaces%2FHttpRequestInterface.php)
- [PerformanceInterface.php](src%2FInterfaces%2FPerformanceInterface.php)
- [PermissionInterface.php](src%2FInterfaces%2FPermissionInterface.php)
- ~~[PrivateKeyInterface.php](src%2FInterfaces%2FPrivateKeyInterface.php)~~
- ~~[ToolInterface.php](src%2FInterfaces%2FToolInterface.php)~~
- ~~[TransInterface.php](src%2FInterfaces%2FTransInterface.php)~~
- [Web3Interface.php](src%2FInterfaces%2FWeb3Interface.php)

# 说明
## 依赖条件
本项目前置依赖：
1.已经正确安装并部署了 Webase 的相关服务：Sign 服务，Node 节点。
2.可以正常访问 Webase 的Node节点前置服务。例如：http://10.0.200.118:5002/WeBASE-Front/#/home

使用本项目可以方便的调用Node前置节点提供的各种服务，可实现的功能与WeBASE-FRONT完全一致，并且使用各种对象封装使接口更加清晰易懂。

> WeBASE-Front是和FISCO-BCOS节点配合使用的一个子系统。此分支支持FISCO-BCOS 2.0以上版本，集成web3sdk，对接口进行了封装，可通过HTTP请求和节点进行通信。另外，具备可视化控制台，可以在控制台上开发智能合约，部署合约和发送交易，并查看交易和区块详情。还可以管理私钥，对节点健康度进行监控和统计。
>

# 安装

本项目使用 Composer 对依赖项目进行管理

**当前项目处于迭代阶段，使用方法尚不稳定，请自行决定是否使用**

1.执行下面的安装命令
```shell
composer require yoruchiaki/php-webase-front=dev-main
```
2.【可选】使用Laravel发布配置文件
```
php artisan vendor:publish --tag="webase-front"
```
3.【可选】在Laravel的 config/webase-front.php 中修改 frontUrl或在环境变量中创建
```env
WEBASE_FRONT_URL=XXX
```

**安装完毕**


#使用
1. 常规PHP项目使用

```php
require_once './vendor/autoload.php';
use  Yoruchiaki\WebaseFront\HttpClient\AppConfig;
use  Yoruchiaki\WebaseFront\HttpClient\HttpRequest;

$httpClient = new HttpRequest(
      new AppConfig(
                "http://10.0.200.118:5002/WeBASE-Front/",
                5
      )
);

$abiClient = new \Yoruchiaki\WebaseFront\Services\Abi\ContractService($httpClient);
//Abi,Bin,Sol都可以使用相同的方法进行初始化.
$abi = new \Yoruchiaki\WebaseFront\ValueObjects\SolidityAbi();
$abi->loadPath('/filePath/demo.abi');// 载入abi文件路径也可以在构造函数中传入文件内容进行初始化
$bin = new \Yoruchiaki\WebaseFront\ValueObjects\SolidityBin();
$bin->loadPath('/filePath/demo.bin');// 载入abi文件路径也可以在构造函数中传入文件内容进行初始化
$sol = new \Yoruchiaki\WebaseFront\ValueObjects\SoliditySol(
    file_get_contents('/filePath/demo.sol')
);

$solidity = new \Yoruchiaki\WebaseFront\ValueObjects\Solidity(
    'demo',
    $abi,
    $bin,
    $sol
);
$contractAddress = '0xabcd....';
$abiClient->abiInfo($solidity,$contractAddress);
$abiClient->addContractPath('path-folder');
$abiClient->compileJava($solidity);
$abiClient->contractCompile('demo',$sol);
$abiClient->contractList(1,10);
...
```
2.如果你使用Laravel的话则可以直接使用Facade进行调用

```php
use Yoruchiaki\WebaseFront\Facade\ContractFacade;

ContractFacade::abiInfo($solidity,$contractAddress);
...
```
3.以此类推

```php
当前版本还有如下方法可以调用
use Yoruchiaki\WebaseFront\Facade\ContractFacade; //合约
use Yoruchiaki\WebaseFront\Facade\ToolFacade; //工具
use Yoruchiaki\WebaseFront\Facade\PrivateKeyFacade; //密钥
use Yoruchiaki\WebaseFront\Facade\TransFacade; //交易
```
