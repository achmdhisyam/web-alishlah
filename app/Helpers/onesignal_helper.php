<?php

if (!function_exists('send_push_notification')) {
    /**
     * Send push notification using OneSignal API.
     *
     * @param array  $externalUserIds Array of external user IDs (e.g. ['admin_1', 'siswa_5'])
     * @param string $message          Message content
     * @param string $heading          Heading/Title of the notification
     * @param string $url              Optional target URL when clicked
     * @return bool
     */
    function send_push_notification(array $externalUserIds, string $message, string $heading = '', string $url = '')
    {
        $appId = getenv('ONESIGNAL_APP_ID');
        $apiKey = getenv('ONESIGNAL_REST_API_KEY');

        if (empty($appId) || empty($apiKey) || empty($externalUserIds)) {
            return false;
        }

        $payload = [
            'app_id' => $appId,
            'contents' => [
                'en' => $message,
                'id' => $message
            ],
            'include_aliases' => [
                'external_id' => $externalUserIds
            ],
            'target_channel' => 'push'
        ];

        if (!empty($heading)) {
            $payload['headings'] = [
                'en' => $heading,
                'id' => $heading
            ];
        }

        if (!empty($url)) {
            $payload['url'] = $url;
        }

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->post('https://onesignal.com/api/v1/notifications', [
                'headers' => [
                    'Content-Type'  => 'application/json; charset=utf-8',
                    'Authorization' => 'Basic ' . $apiKey,
                ],
                'json' => $payload,
                'http_errors' => false,
                'verify' => false // Disable SSL verification for local testing CA stability
            ]);

            $status = $response->getStatusCode();
            $body = $response->getBody();
            file_put_contents(WRITEPATH . 'onesignal_debug.log', date('Y-m-d H:i:s') . " - Target: " . json_encode($externalUserIds) . " - Status: $status - Body: $body\n", FILE_APPEND);

            return $status === 200;
        } catch (\Exception $e) {
            file_put_contents(WRITEPATH . 'onesignal_debug.log', date('Y-m-d H:i:s') . " - Target: " . json_encode($externalUserIds) . " - Exception: " . $e->getMessage() . "\n", FILE_APPEND);
            log_message('error', 'OneSignal Push Error: ' . $e->getMessage());
            return false;
        }
    }
}
