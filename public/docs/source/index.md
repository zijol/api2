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

#Doc
<!-- START_e534f202615339d321e7309b258be05d -->
## 项目详情

获取到项目详情，参数id和name，必须传一个，优先使用id进行查询

> Example request:

```bash
curl -X GET -G "http://west.api.zijol.com/doc/project/detail" 
```

```javascript
const url = new URL("http://west.api.zijol.com/doc/project/detail");

    let params = {
            "id": "pRQlTMBinA5CejDg",
            "name": "tRl9Pd9DYgRePwmY",
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
    "result": []
}
```

### HTTP Request
`GET doc/project/detail`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    id |  optional  | optional 项目ID
    name |  optional  | optional 项目名称

<!-- END_e534f202615339d321e7309b258be05d -->

<!-- START_a168dcf017bc01c28011a43ec3b8244d -->
## 创建项目

新建一个项目

> Example request:

```bash
curl -X POST "http://west.api.zijol.com/doc/project"     -d "project_name"="kxanrQATpl0anLMI" \
    -d "project_description"="yhEFog2jYEMzfRog" 
```

```javascript
const url = new URL("http://west.api.zijol.com/doc/project");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "project_name": "kxanrQATpl0anLMI",
    "project_description": "yhEFog2jYEMzfRog",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST doc/project`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    project_name | string |  required  | 项目名称
    project_description | string |  required  | 项目描述

<!-- END_a168dcf017bc01c28011a43ec3b8244d -->

#Helper
<!-- START_89d7df66b9c17fd511183d9750ee2f7e -->
## 获取签名

> Example request:

```bash
curl -X GET -G "http://west.api.zijol.com/signature" 
```

```javascript
const url = new URL("http://west.api.zijol.com/signature");

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
    "result": "cf989d44b5521c1d2a61387288be97e96a95f8b8"
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

