---
title: API文档

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- Fission-User-Level Documents.
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.

<!-- END_INFO -->

#Helper
<!-- START_89d7df66b9c17fd511183d9750ee2f7e -->
## 获取签名

> Example request:

```bash
curl -X GET -G "http://api.zijol.com/signature" 
```

```javascript
const url = new URL("http://api.zijol.com/signature");

    let params = {
            "key": "api",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "code": "0",
    "msg": "",
    "result": "15c50873f03c4aed0542aa4cef159bfb387f5c8f"
}
```

### HTTP Request
`GET signature`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    key |  required  | 模块键

<!-- END_89d7df66b9c17fd511183d9750ee2f7e -->

<!-- START_5164cb1814ca2db4e2bd44e681529c98 -->
## 密码加密

> Example request:

```bash
curl -X GET -G "http://localhost/encrypt" 
```

```javascript
const url = new URL("http://localhost/encrypt");

    let params = {
            "words": "LUaS0pJuqt3AAAtN",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "code": "0",
    "msg": "",
    "result": "ev2:H+orqPjMZkOIiqNuD1ye9S+rmGvscs2NM+C12kx5p39QtLNza\/6Y+LVyF3DfTKeB"
}
```

### HTTP Request
`GET encrypt`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    words |  required  | 需要加密的明文内容

<!-- END_5164cb1814ca2db4e2bd44e681529c98 -->
<!-- START_32b065004d7ec955cf329e5533e8f3a7 -->
## decrypt
> Example request:

```bash
curl -X GET -G "http://localhost/decrypt" 
```

```javascript
const url = new URL("http://localhost/decrypt");

    let params = {
            "words": "pzffhlLAgc793zR7",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "code": "0",
    "msg": "",
    "result": null
}
```

### HTTP Request
`GET decrypt`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    words |  required  | 加密的内容

<!-- END_32b065004d7ec955cf329e5533e8f3a7 -->
