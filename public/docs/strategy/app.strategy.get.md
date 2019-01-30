### 获取等级策略

#### 描述
&emsp;&emsp;获取应用的等级策略。

#### URI
&emsp;&emsp;GET: /api/app/{app}/strategy

#### 请求 - 参数
参数 | 类型 | 必须 | 描述
--- | --- | --- | ---
app | string | required | 应用ID
live_mode | string | optional | live_mode, 支持0,1可选

#### 请求 - 示例
```
    /api/app/{app}/strategy?live_mode=1
```

#### 响应 - 字段说明
参数 | 类型 | 必须 | 描述
--- | --- | --- | ---
level | integer | required | 等级值
expire_at | datetime OR null | required | 等级有效期

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
