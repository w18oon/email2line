<?php

namespace App\Http\Controllers;

use App\Lookup;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $client;
    protected $service;
    protected $rest_resource;

    const LINE_NOTIFY_URI = 'https://notify-api.line.me/api/notify';

    public function __construct()
    {
        // Get the API client and construct the service object.
        $this->client = new \Google_Client();
        $this->client->setApplicationName('Email2Line');
        $this->client->setScopes(\Google_Service_Gmail::MAIL_GOOGLE_COM);
        $this->client->setAuthConfigFile(storage_path('app/public/client_secrets.json'));
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, 
        // and is created automatically when the authorization flow completes for the first time.

        $token_path = storage_path('app/public/token.json');
        if (file_exists($token_path)) {
            $accessToken = json_decode(file_get_contents($token_path), true);
            $this->client->setAccessToken($accessToken);
        }
    
        // If there is no previous token or it's expired.
        if ($this->client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            } else {
                // Request authorization from the user.
                // header('Location: ' . filter_var($client->createAuthUrl(), FILTER_SANITIZE_URL));
                return redirect()->to(filter_var($this->client->createAuthUrl(), FILTER_SANITIZE_URL));
            }
        }
        $this->service = new \Google_Service_Gmail($this->client);
        $this->rest_resource = $this->service->users_messages;
    }

    function index()
    {
        // Lists the messages in the user's mailbox.
        $user_id = 'me';
        $params = ['q' => "subject:Alarm is:unread"];
        $results = $this->rest_resource->listUsersMessages($user_id, $params);
        foreach ($results->messages as $message) {
            // echo $message->id . "\n";
            // Get subject from Resource Message
            $payload = $this->rest_resource->get($user_id, $message->id)->payload;
            foreach ($payload->headers as $header) {
                if ($header['name'] === 'Subject') {
                    $subject = $header['value'];
                }
            }
            // Get body from Resource Message
            foreach ($payload->parts as $part) {
                if ($part['mimeType'] === 'text/html') {
                    $body = base64_decode(str_replace(['-', '_'], ['+', '/'], $part->body->data), true);
                }
            }

            // Get plain text 
            libxml_use_internal_errors(true);
            $doc = new \DOMDocument();
            $doc->preserveWhiteSpace = true;
            $doc->loadHTML($body);
            $line_message = '';
            $trs = $doc->getElementsByTagName('tr');
            foreach ($trs as $tr) {
                $line_message .= "\n" . $tr->childNodes[0]->nodeValue . " : " . $tr->childNodes[1]->nodeValue;
            }

            // Get access_token from lookups table
            $lookups = Lookup::where('subject', $subject)->where('status', true)->get();
            foreach ($lookups as $lookup) {
                $count_notification = Notification::where('lookup_id', $lookup->id)->whereDate('created_at', Carbon::today())->count();
                echo "count_notification => $count_notification";
                if ($count_notification == 0) {
                    // Call LINE Notify API
                    $line_response = $this->line_notify($lookup->token, $line_message);

                    // if response == 200 then set message to unread
                    if ($line_response->getStatusCode() == 200) {
                        $this->set_unread('me', $message->id);
                    }

                    // Store data to notifications table
                    $this->store_notification($lookup, $message->id, $line_response->getStatusCode());
                }
            }   
        }
    }

    function line_notify($token, $message) {
        $line_client = new \GuzzleHttp\Client();
        $response = $line_client->request('POST', self::LINE_NOTIFY_URI, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => "Bearer $token"
            ],
            'form_params' => [
                'message' => $message
            ]
        ]);

        return $response;
    }

    public function set_unread($user_id, $message_id)
    {
        // Modifies the labels on the specified message.
        $post_body = new \Google_Service_Gmail_ModifyMessageRequest();
        $post_body->setRemoveLabelIds('UNREAD');
        $gmail_response = $this->rest_resource->modify($user_id, $message_id, $post_body);
        echo '<pre>';
        var_dump($gmail_response->labelIds);
        echo '</pre>';
        if (!in_array('UNREAD', $gmail_response->labelIds)) {
            echo "$message_id => UNREAD";
        }
    }

    public function store_notification(Lookup $lookup, $message_id, $status_code)
    {
        $lookup->notifications()->create([
            'gmail_message_id' => $message_id,
            'status' => $status_code
        ]);
    }

    public function test_one_to_many()
    {
        $lookups = Lookup::where('status', true)->get();
        foreach ($lookups as $lookup) {
            $lookup->notifications()->create([
                'gmail_message_id' => 'test',
                'status' => 200
            ]);
        }
    }
}
