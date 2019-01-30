### 获取用户等级
#### 描述
&emsp;&emsp;获取用户的等级信息，同时会得到应用的等级策略（当前用户等级的策略，以及下一级的策略）。

#### URI
&emsp;&emsp;GET: /api/app/{app}/user/{user}/level

#### 请求参数
参数 | 类型 | 必须 | 描述
--- | --- | --- | ---
app | string | required | 应用ID
user | string | required | 用户ID
live_mode | string | optional | live_mode, 支持0,1可选

#### 响应
```json
{
    "code": "0",
    "msg": "",
    "result": {
        "app_id": "app_LibTW1n1SOq9Pin1",
        "user_id": "zhuxiang@pingxx.com",
        "level": 1000,
        "expire_at": null,
        "strategy": [
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
            }
        ]
    }
}
```
