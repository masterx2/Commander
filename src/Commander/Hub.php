<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 11.07.16
 * Time: 20:50
 */

namespace Commander;


class Hub {

    public $profiles;

    public function __construct() {
        $this->profiles = require DOC_ROOT.'/config/profiles.php';
    }
    
    public function request($api, $command, $arguments) {
        try {
            if (array_search($api, $this->profiles)) throw new \Exception("API Profile: $api, not found in config!");
            $profile = $this->profiles[$api];
            $class = "Commander\\APIs\\".$profile['class'];
            if (!class_exists($class)) throw new \Exception("API Class: ".$class." not found!");

            /** @var Base $api */
            $api = new $class($profile['options']);

            return [
                'success'  => true,
                'response' => \Koda::call([$api, $command], $arguments, [
                    "injector" => function($info) use ($api) {
                        return $api->getParam($info->name);
                    }
                ])
            ];

        } catch (\Exception $e) {
            return [
                'success'  => false,
                'code'     => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
}