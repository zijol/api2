### 设置用户等级
#### 描述
&emsp;&emsp;设置用户的等级信息。

#### URI
&emsp;&emsp;POST: /api/app/{app}/user/{user}/level

#### 请求参数
参数 | 类型 | 必须 | 描述
--- | --- | --- | ---
app | string | required | 应用ID
user | string | required | 用户ID
live_mode | string | optional | live_mode, 支持0,1可选
role | integer | required | 角色，当前支持0,1
level | integer | required | 等级值，当前支持\[0, 2\]

#### 响应
- level 用户等级
- expire_at 等级有效期

```json
{
    "code": "0",
    "msg": "",
    "result": {
        "app_id": "app_LibTW1n1SOq9Pin1",
        "user_id": "ke-liang.xu@pingxx.com1",
        "level": 1001,
        "expire_at": null
    }
}
```
