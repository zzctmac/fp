#配置的说明

>目标：
>与代码无关
>支持多节点（线上、开发）
>支持一般类型和数组
>全局可用
>支持多配置文件

###使用示例

配置文件

```ini
[product]
price_trend.host=192.168.1.179
price_trend.port=11904
dp_64.host=192.168.1.179
dp_64.port=11904
dp_32.host=192.168.1.179
dp_32.port=11903
taobao_api[]=23298914,862648c9bb8584ad0539fe41619d8369
taobao_api[]=23246820,fe8d7ff29368c3a22bed0e360ab34a62
[dev:product]
dp_64.host=kgwx
a=1
```
代码
```php
\config\Factory::init('../conf');

\config\Factory::set('env.dev', 1);

$res = \config\Factory::get('tt.dp_64');

$res = \config\Factory::get('tt.taobao_api.1');
```

一些细节
>使用ini格式（语言无关）
>依赖抽象，方便替换