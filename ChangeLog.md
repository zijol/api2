## Change Log

---

### Date: 2019-01-10, Version 1.0.2
- 搭建项目主题框架
- 添加Log基础类
- 添加签名验证中间件
- 添加Make类用于生成规范结果
- 添加NsqClient包
- 添加Api文档自动生成模块
- 添加数据库密码加密解密接口
- 添加数据库密码加密解密命令
    - DbPasswordEncrypt:run {password}
    - DbPasswordDecrypt:run {pwd_enc}
- 数据库密码进行加密
- Api、Ajax调用异常的特殊处理
- ErrorCode的统一规范管理
- 添加 php artisan change-log:update 命令，用户更新change log 页面
- 添加 php artisan deploy:create 命令，用于生成上线文档
