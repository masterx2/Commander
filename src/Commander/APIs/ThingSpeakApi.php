<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 11.07.16
 * Time: 19:48
 */

namespace Commander\APIs;

use Commander\Base;
use Requests;

class ThingSpeakApi extends Base {

    /**
     * Получить ленту канала
     * @param int $channel Номер канала
     * @param int $limit Количество последних записей
     * @return array
     */
    public function getFeed($channel, $limit=null) {
        return $this->request("https://api.thingspeak.com/channels/$channel/feeds.json?results=$limit");
    }

    /**
     * Получить поле из ленты канала
     * @param int $channel Номер канала
     * @param int $field Номер поля
     * @param int $limit Количество последних записей
     * @return array
     */
    public function getFeedField($channel, $field=1, $limit=null) {
        return $this->request("https://api.thingspeak.com/channels/$channel/fields/$field.json?results=$limit");
    }

    /**
     * Добавить запись в канал (Требуется Write API_KEY)
     * @param int $channel
     * @param array $fields
     * @param string $api_key (inject)
     * @return array
     */
    public function updateFeed($channel, $fields, $api_key) {
        return $this->request("https://api.thingspeak.com/channels/$channel.json", Requests::PUT, 
            array_merge(["api_key" => $api_key], $fields));
    }
}