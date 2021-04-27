<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Client\Common\HttpMethodsClient as HttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use OneSignal\Config;
use OneSignal\OneSignal;
use OneSignal\Exception\OneSignalException;

class OneSignalHandler extends Controller
{
    private $api = null;

    public function __construct()
    {
        $config = new Config;
        $config->setApplicationAuthKey(setting('onesignal_rest_api_key'));
        $config->setUserAuthKey(setting('onesignal_user_auth_key'));
        $config->setApplicationId(setting('onesignal_app_id'));

        $client = new HttpClient(new GuzzleAdapter(new GuzzleClient), new GuzzleMessageFactory);
        $this->api = new OneSignal($config, $client);
    }

    public function addApp($data)
    {
        return $this->api->apps->add($data);
    }

    public function updateApp($app_id, $data)
    {
        return $this->api->apps->update($app_id, $data);
    }

    public function updateOrAddApp($app_id, $data)
    {
        if(!$app_id) return $this->addApp($data);

        try
        {
            $data = $this->updateApp($app_id, $data);
        }
        catch(OneSignalException $e)
        {
            $data = $this->addApp($data);
        }

        return $data;
    }

    public function addDevice($data)
    {
        return $this->api->devices->add($data);
    }

    public function updateDevice($device_id, $data)
    {
        return $this->api->devices->update($device_id, $data);
    }

    public function updateOrAddDevice($device_id, $data)
    {
        if(!$device_id) return $this->addDevice($data);

        try
        {
            $data = $this->updateDevice($device_id, $data);
        }
        catch(OneSignalException $e)
        {
            $data = $this->addDevice($data);
        }

        return $data;
    }

    public function addNotification($data)
    {
        return $this->api->notifications->add($data);
    }

    public function openNotification($notification_id)
    {
        return $this->api->notifications->open($notification_id);
    }

    public function cancelNotification($notification_id)
    {
        return $this->api->notifications->cancel($notification_id);
    }

    public function getApps($app_id = null)
    {
        return $app_id ? $this->api->apps->getOne($app_id) : $this->api->apps->getAll();
    }

    public function getDevices($device_id = null)
    {
        return $device_id ? $this->api->devices->getOne($device_id) : $this->api->devices->getAll();
    }

    public function getNotifications($notification_id = null)
    {
        return $notification_id ? $this->api->notifications->getOne($notification_id) : $this->api->notifications->getAll();
    }
}
