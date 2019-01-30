### 设置、更新等级策略

#### 描述
&emsp;&emsp;设置、更新应用的等级策略。

#### URI
&emsp;&emsp;POST: /api/app/{app}/strategy

#### 请求 - 参数
参数 | 类型 | 必须 | 描述
--- | --- | --- | ---
app | string | required | 应用ID
live_mode | string | optional | live_mode, 支持0,1可选
strategy | list | required | list 的结构，参照请求示例

#### 请求 - 示例
```json
{
	"live_mode":"1",
	"strategy" : [
		{
			
			"role": 1,
			"level": 0,
			"level_name": "分销0001",
			"bring_user": 1,
			"defined_type": 1
		},
		{
			"role": 1,
			"level": 10,
			"level_name": "分销0002",
			"bring_user": 6,
			"defined_type": 1
		}
	]
}
```

#### 响应 - 字段说明
参数 | 类型 | 必须 | 描述
--- | --- | --- | ---
bring_user | integer | required | 带来用户数
consume_order | integer | required | 消费订单数
consume_amount | integer | required | 消费金额
cu_consume_amount | integer | required | 带来的用户消费金额
defined_type | integer | required | 0.自定义 1.带来用户数 2.消费订单数 3.消费总金额 4.下级用户消费金额

#### 响应 - 示例
```json
{
    "code": "0",
    "msg": "",
    "result": [
        {
            "app_id": "app_LibTW1n1SOq9Pin1",
            "level": 1000,
            "level_name": "分销0001",
            "bring_user": 1,
            "consume_order": 0,
            "consume_amount": 0,
            "cu_consume_amount": 0,
            "defined_type": 0
        },
        {
            "app_id": "app_LibTW1n1SOq9Pin1",
            "level": 1001,
            "level_name": "分销0002",
            "bring_user": 6,
            "consume_order": 0,
            "consume_amount": 0,
            "cu_consume_amount": 0,
            "defined_type": 0
        },
        {
            "app_id": "app_LibTW1n1SOq9Pin1",
            "level": 1002,
            "level_name": "分销0003",
            "bring_user": 20,
            "consume_order": 0,
            "consume_amount": 0,
            "cu_consume_amount": 0,
            "defined_type": 0
        },
        {
            "app_id": "app_LibTW1n1SOq9Pin1",
            "level": 1003,
            "level_name": "分销0003",
            "bring_user": 30,
            "consume_order": 0,
            "consume_amount": 0,
            "cu_consume_amount": 0,
            "defined_type": 0
        }
    ]
}
```

