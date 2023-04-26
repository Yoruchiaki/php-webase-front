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

## Usage
1. 使用 Composer 命令进行依赖安装
```shell
composer require yoruchiaki/php-webase-front=dev-main
```
使用-vvv可以打印详细参数
```shell
composer require yoruchiaki/php-webase-front=dev-main -vvv
```
2. 使用 Laravel 进行集成
> TODO 待补充
3. 针对 PHP 引用
> TODO 待补充
## License

MIT