## 关于用户等级

模块主要负责用户等级的管理

## 开发规范说明
- 业务错误，不使用异常进行跑出，可以使用一下的方法进行返回。不采用抛出异常的方式进行
    - Make::ApiFail()，进行Api的controller或者router中进行错误返回
    - Make::LogicFail()，在Logic代码中进行错误返回
    - Make::MiddlewareFail()，在中间键中进行错误返回
- 错误信息，在App\Services\Helper\ErrorCode下的各种ErrorCode类中进行管理，因为这样可以支持多语言
- controller、logic、router、validator的职能划分
    - validator，定义验证规则，条件，错误信息等
    - controller，只做请求数据验证，路由转发
    - logic，做具体的业务功能
    - router，只做路由管理，不做数据校验，不做业务功能
- 日志记录
    - laravel 框架自带日志保留
    - 添加更具业务性质的Log，在App\Services\Helper\Log中有各种类型的日志类。
        - 日志文件，按照Log类型进行分文件存储
        - 日志格式，Json
        - 日志三要素，重要信息、来龙去脉、监控

### 命名规范
- 常量，所有字符大写，单词间使用 _ 间隔
- 类，大驼峰命名
- 方法，小驼峰命名
- 参数，小驼峰命名
- 类属性，小驼峰命名
- 变量，小驼峰命名

### 代码设计规范

### 代码注释规范

## 常用公共类和对象使用说明

### Services

#### Helper

#### Http

#### Log

## 注释规范

### Tag 说明

Tag | 说明 | 支持选项 | 示例
--- | --- | --- | ---
@group | 用于接口的分组，会在doc页面左侧栏区分 | 选项1 分组名字 | @group api
@bodyParam | 参数说明 | 选项1 参数名，选项2 参数类型，选项3 状态（可、必选等），选项 4描述 | @bodyParam app string required 应用ID
@queryParam | 参数说明 | 选项1 参数名，选项2 参数类型，选项3 描述 | @queryParam user string 用户ID
@response | 响应说明 | 选项1 Http状态，选项2 结果Json | @response 404 {"id":4, "name":"read"}
@responseFile | 响应说明文件 | 选项1 响应文件 | @response responses/users.get.json
@transformer | - | - | -
@transformerModel | - | - | -
@transformerCollection | - | - | -
