## easy-baidu (基于 easywechat 实现)
Baidu MiniProgram Sdk（百度小程序SDK）

支持百度小程序第三方 调用 和手动调用

如果此SDK对您有用 请不吝 star 感谢

如有在使用过程中出现问题  可以提交PR 我都会认真的去看 感谢

调用方法如下

```php
use EasyWeChat\Factory;
use EasyBaidu\OpenPlatform\Application as opernPlatform;

$config = [

];

$api = new opernPlatform(
    Factory::openPlatform($config)
);

```
配置跟超哥的 EasyWechat 的一致

如果有什么不懂的 可以加 发送邮件  [邮箱](brooke-p@qq.com)
