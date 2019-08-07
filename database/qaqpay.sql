

-- 以下字段含义
-- 商户 -> 游戏平台


-- 商户表
create table if not exists `merchant`(
    `merchant_id` int unsigned auto_increment primary key,
    `account` varchar(50) not null comment '商户账号',
    `password` varchar(64) not null default '' comment '密码',
    `secret_key` varchar(255) not null comment '商户秘钥',
    `name` varchar(50) not null comment '商户名称',
    `phone` varchar(20) not null default '' comment '商户手机号',
    `email` varchar(50) not null default '' comment '邮箱',
    `total_server_income` decimal(10,2) not null default 0.00 comment '系统收益总收益',
    `total_trade_amount` decimal(10,2) not null default 0.00 comment '商户总交易金额',
    `account_balances` decimal(10,2) not null default 0.00 comment '商户余额',
    `charges_percentage` decimal(5,2) not null default 3.00 comment '商户交易手续费百分比',
    `access_token` varchar(255) not null default '' comment 'token',
    `created_at` int not null default 0 comment '创建时间',
    `updated_at` int not null default 0 comment '更新时间'
)engine=innodb default charset=utf8 comment '商户表';

-- 商户流水账单表
create table if not exists `merchant_trade_bills`(
    `bills_id` int unsigned auto_increment primary key,
    `merchant_id` int not null comment '商户ID',
    `bill_type` char(20) not null comment '账单类型, openpay-开放支付, withdraw-提现',
    `status` tinyint(1) not null default 1 comment '状态 0-成功, 1-等待中(提现中), 2-失败',
    `amount` decimal(10,2) not null default 0.00 comment '到账金额',
    `charges_amount` decimal(10,2) not null default 0.00 comment '商户交易手续费',
    `out_trade_no` varchar(255) not null default '' comment '第三方系统(支付宝|微信)流水号',
    `created_at` int not null default 0 comment '创建时间',
    `updated_at` int not null default 0 comment '更新时间'
)engine=innodb default charset=utf8 comment '商户流水账单表';

-- 商户支付表
create table if not exists `merchant_trade_pay`(
    `pay_id` int unsigned auto_increment primary key,
    `merchant_id` int not null comment '商户ID',
    `trade_no` varchar(255) not null comment '系统流水号',
    `status` char(20) not null default '' comment 'wait:等待结算, end:已经结算',
    `out_pay_status` tinyint(1) not null default 1 comment '第三方系统支付状态 0-成功, 1-等待, 2-失败',
    `out_trade_no` varchar(255) not null default '' comment '第三方系统(支付宝|微信)流水号',
    `out_gmt_payment` int not null default 0 comment '第三方支付完成时间',

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

-- 商户提现申请表
create table if not exists `merchant_amount_withdraw`(
    `withdraw_id` int unsigned auto_increment primary key,
    `bills_id` int not null comment '商户交易流水表',
    `merchant_id` int not null comment '商户ID',
    `status` char(10) not null default 'wait' comment '状态 成功:success, 等待中(提现中):wait, 失败:failure, 取消:cancel',
    `amount` decimal(10,2) not null default 0.00 comment '提现金额',
    `number` varchar(255) not null default 0.00 comment '提现账号',
    `merchant_remarks` varchar(255) not null default '' comment '提现商户备注',
    `operating_time` int not null default 0 comment '提现管理操作时间',
    `operating_remarks` varchar(255) not null default '' comment '提现管理操作备注',
    `created_at` int not null default 0 comment '创建时间',
    `updated_at` int not null default 0 comment '更新时间'
)engine=innodb default charset=utf8 comment '商户提现申请表';

-- 商户回调通知表
create table if not exists `merchant_trade_notify`(
    `notify_id` int unsigned auto_increment primary key,
    `merchant_id` int not null comment '商户ID',
    `status` char(50) not null default 'wait' comment '状态 success , error , wait',
    `frequency` tinyint(5) not null default 1 comment '通知次数',
    `last_notice_time` int not null comment '上次通知时间',
    `out_trade_no` varchar(255) not null default '' comment '第三方系统(支付宝|微信)流水号',
    `notify_url` varchar(255) not null default '' comment '商户通知回调地址',
    `notice_body` text not null comment '通知原始数据',
    `created_at` int not null default 0 comment '创建时间',
    `updated_at` int not null default 0 comment '创建时间'
)engine=innodb default charset=utf8 comment '商户回调通知表';

-- 第三方支付平台支付回调通知表
create table if not exists `out_trade_pay_log`(
    `log_id` int unsigned auto_increment primary key,
    `status` char(50) not null default '' comment '支付状态',
    `out_trade_no` varchar(255) not null comment '第三方系统(支付宝|微信)流水号',
    `out_body` text not null comment '回调通知原始数据',
    `created_at` int not null default 0 comment '创建时间'
)engine=innodb default charset=utf8 comment '第三方支付平台支付回调通知表';

-- 商户接口调用日志
