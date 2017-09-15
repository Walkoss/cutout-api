<?php

namespace AppBundle\FCM;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class FCMApi
{
    const FCM_API_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $headers;

    /**
     * FCMApi constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->client = new Client();
        $this->headers = [
            'Authorization' => 'key=' . $this->container->getParameter('fcm_api_key')
        ];
    }

    /**
     * Send a notification push to the deviceId
     *
     * @param $deviceId
     * @param $notificationParams
     * @return mixed|string
     */
    public function sendNotification($deviceId, $notificationParams)
    {
        $options = [
            'headers' => $this->headers,
            'json' => [
                'to' => $deviceId,
                'notification' => $notificationParams
            ]
        ];

        try {
            $response = $this->client->post(FCMApi::FCM_API_URL, $options);

            dump(json_decode($response->getBody(), true));
            return json_decode($response->getBody(), true);
        } catch (BadResponseException $e) {
            dump($e);
            return $e->getMessage();
        }
    }
}