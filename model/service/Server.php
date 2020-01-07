<?php declare (strict_types = 1);
#coding: utf-8
# +-------------------------------------------------------------------
# | 模型服务类
# +-------------------------------------------------------------------
# | Copyright (c) 2017-2019 Sower rights reserved.
# +-------------------------------------------------------------------
# +-------------------------------------------------------------------
namespace sower\driver\model\service;
use sower\Model;
use sower\Service;
class Server extends Service
{
    public function boot()
    {
        Model::maker(function (Model $model) {
            $db = $this->app->db;
            $model->setDb($db);
            $model->setEvent($this->app->event);

            $isAutoWriteTimestamp = $model->getAutoWriteTimestamp();

            if (is_null($isAutoWriteTimestamp)) {
                // 自动写入时间戳
                $model->isAutoWriteTimestamp($db->getConfig('auto_timestamp'));
            }

            $dateFormat = $model->getDateFormat();

            if (is_null($dateFormat)) {
                // 设置时间戳格式
                $model->setDateFormat($db->getConfig('datetime_format'));
            }

            $connection = $model->getConnection();

            if (!empty($connection) && is_array($connection)) {
                // 设置模型的数据库连接
                $model->setConnection(array_merge($db->getConfig(), $connection));
            }

        });
    }
}
