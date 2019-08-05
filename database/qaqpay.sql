

-- 以下字段含义
-- 平台 -> 码商
-- 商户 -> 游戏平台


-- 用户平台表
create table if not exists `platform`(
    `platform_id` int unsigned auto_increment primary key,
    `name` varchar(50) not null comment '平台名称',
    `phone` varchar(20) not null comment '平台手机号 | 账号',
    `password` varchar(64) not null default "" comment '密码',
    `account_balance` decimal(10,2) not null default 0.00 comment '平台余额 , 不可提现',
    `income_balance`  decimal(10,2) not null default 0.00 comment '收益余额, 可提现',
    `income_percentage`  decimal(10,2) not null default 0.00 comment '收益余额, 提成百分比',
    `wechat_appid` varchar(255) not null default "" comment '微信appid',
    `wechatpay_secret` varchar(255) not null default "" comment '微信支付秘钥',
    `alipay_appid` varchar(255) not null default "" comment '支付宝appid',
    `alipay_secret` varchar(255) not null default "" comment '支付宝支付秘钥',
    `use_time` int  not null  default 0 comment '上次使用此平台支付时间',
    `created_at` int not null default 0 comment '创建时间',
    `updated_at` int not null default 0 comment '更新时间',
    UNIQUE KEY `phone` (`phone`)
)engine=innodb default charset=utf8 comment '平台表';

-- 平台流水表
create table if not exists `platform_trade_bills`(
    `total_bill_id` int unsigned auto_increment primary key,
    `platform_id` int not null comment '平台账号',
    `bill_type` char(20) not null comment '账单类型, enter-充值, exit-提现, income-收益',
    `status` tinyint(1) not null default 1 comment '状态 0-成功, 1-等待, 2-失败',
    `amount` decimal(10,2) not null default 0.00 comment '金额',
    `created_at` int not null default 0 comment '创建时间',
    `updated_at` int not null default 0 comment '更新时间'
)engine=innodb default charset=utf8 comment '平台(充值|提现)表';

-- 商户表
create table if not exists `merchant`(
    `merchant_id` int unsigned auto_increment primary key,
    `account` varchar(50) not null comment '商户账号',
    `password` varchar(64) not null default '' comment '密码',
    `secret_key` varchar(255) not null comment '商户秘钥',
    `name` varchar(50) not null comment '商户名称',
    `phone` varchar(20) not null default '' comment '商户手机号',
    `email` varchar(50) not null default '' comment '邮箱',
    `total_server_income` decimal(10,2) not null default 0.00 comment '系统获取总收益',
    `total_trade_amount` decimal(10,2) not null default 0.00 comment '商户总交易金额',
    `charges_percentage` decimal(5,2) not null default 3.00 comment '商户交易手续费百分比',
    `created_at` int not null default 0 comment '创建时间',
    `updated_at` int not null default 0 comment '更新时间'
)engine=innodb default charset=utf8 comment '商户表';

-- 商户流水账单表
create table if not exists `merchant_trade_bills`(
    `total_bill_id` int unsigned auto_increment primary key,
    `merchant_id` int not null comment '商户ID',
    `bill_type` char(20) not null comment '账单类型, enter-支付, exit-提现',
    `status` tinyint(1) not null default 1 comment '状态 0-成功, 2-失败',
    `amount` decimal(10,2) not null default 0.00 comment '金额',
    `charges_amount` decimal(10,2) not null default 0.00 comment '商户交易手续费',
    `created_at` int not null default 0 comment '创建时间',
    `updated_at` int not null default 0 comment '更新时间'
)engine=innodb default charset=utf8 comment '商户流水账单表';

-- 商户支付表
create table if not exists `merchant_trade_pay`(
    `pay_id` int unsigned auto_increment primary key,
    `merchant_id` int not null comment '商户ID',
    `trade_no` varchar(255) not null comment '系统流水号',
    `out_pay_status` tinyint(1) not null default 1 comment '第三方系统支付状态 0-成功, 1-等待, 2-失败',
    `out_trade_no` varchar(255) not null default '' comment '第三方系统(支付宝|微信)流水号',

    -- 商户信息
    `merchant_trade_no` varchar(64) not null comment '商户订单号',
    `total_amount` decimal(10,2) not null comment '订单总金额，单位为元',
    `subject` varchar(256) not null comment '订单标题',
    `body` varchar(128) not null default '' comment '对交易或商品的描述',
    `timeout_express` char(6) not null default '1d' comment '该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 该参数数值不接受小数点， 如 1.5h，可转换为 90m。',
    `passback_params` varchar(255) not null default '' comment '商家自定义参数',
    `notify_url` varchar(255) not null default '' comment '商户通知回调地址',
    `choose_pay_type` varchar(10) not null comment '付款方式, alipayh5,wechath5',

    `created_at` int not null default 0 comment '创建时间',
    `updated_at` int not null default 0 comment '更新时间',
    KEY `merchant_id` (`merchant_id`),
    KEY `trade_no` (`trade_no`),
    KEY `out_trade_no` (`out_trade_no`),
    KEY `merchant_trade_no` (`merchant_trade_no`)
)engine=innodb default charset=utf8 comment '商户支付表';

-- 商户提现表

-- 商户支付回调通知表

-- 第三方支付平台支付回调通知表
create table if not exists `out_trade_pay`(
    `out_trade_pay_id` int unsigned auto_increment primary key,
    `status` tinyint(1) not null default 1 comment '支付状态 0-成功, 1-失败',
    `out_trade_no` varchar(255) not null '第三方系统(支付宝|微信)流水号',
    `out_body` varchar(500) not null comment '回调通知原始数据',
    `created_at` int not null default 0 comment '创建时间'
)engine=innodb default charset=utf8 comment '第三方支付平台支付回调通知表';

-- 商户接口调用日志
