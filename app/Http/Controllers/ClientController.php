<?php

namespace App\Http\Controllers;

use App\Credential;
use App\Mapping;
use App\Group;
use App\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    const GMAIL = 'gmail';
    const GMAIL_USER_ID = 'me';
    const LINE_NOTIFY_URI = 'https://notify-api.line.me/api/notify';

    protected $google_client;
    protected $google_service_gmail;
    protected $google_rest_source;
    protected $redirect_to;

    public function __construct()
    {
        // API client and construct the service object.
        $this->google_client = new \Google_Client();
        $this->google_client->setApplicationName('Email2Line');
        $this->google_client->setScopes(\Google_Service_Gmail::MAIL_GOOGLE_COM);
        $this->google_client->setAuthConfigFile(storage_path('app/public/client_secrets.json'));
        $this->google_client->setAccessType('offline');
        $this->google_client->setPrompt('select_account consent');
    
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, 
        // and is created automatically when the authorization flow completes for the first time.
        $credential = Credential::where('service_name', self::GMAIL)->first();
        if ($credential !== null) {
            $this->google_client->setAccessToken(json_decode($credential->json_token, true));
        }
    
        // If there is no previous token or it's expired.
        if ($this->google_client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($this->google_client->getRefreshToken()) {
                $this->google_client->fetchAccessTokenWithRefreshToken($this->google_client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $this->redirect_to = filter_var($this->google_client->createAuthUrl(), FILTER_SANITIZE_URL);
            }
        }

        $this->google_service_gmail = new \Google_Service_Gmail($this->google_client);
        $this->google_rest_source = $this->google_service_gmail->users_messages;
    }

    public function index()
    {
        return view('client', ['redirect_to' => $this->redirect_to]);
    }

    public function revoke()
    {
        $credential = Credential::where('service_name', self::GMAIL)->first();
        $credential->delete();
        return redirect()->route('gmail-auth.index')->with('success','Credentials have been revoked.');
    }

    public function oauth2_callback(Request $request)
    {
        $access_token = $this->google_client->fetchAccessTokenWithAuthCode($request->code);
        $this->google_client->setAccessToken($access_token);
        Credential::create([
            'service_name' => self::GMAIL,
            'json_token' => json_encode($access_token)
        ]);
        return redirect()->route('gmail-auth.index')->with('success','Credentials have been created.');
    }

    public function push_notify()
    {
        // Lists the messages in the user's mailbox.
        $results = $this->google_rest_source->listUsersMessages(self::GMAIL_USER_ID, ['q' => "subject:Alarm is:unread"]);
        foreach ($results->messages as $message) {
            // Get subject from Resource Message
            $payload = $this->google_rest_source->get(self::GMAIL_USER_ID, $message->id)->payload;
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

            // Get mapping && group table
            $mappings = Mapping::with('group')->where('subject', $subject)->get();
            $results_line_notify = '';
            $line_notify_flag = false;
            foreach ($mappings as $mapping) {
                $log_count = DB::table('logs')->where('mapping_id', $mapping->id)->whereRaw("created_at >= date_format(now(),'%Y-%m-%d %h:00:00')")->count();
                if ($log_count == 0) {
                    // Call LINE Notify API
                    $line_client = new \GuzzleHttp\Client();
                    $results_line_notify = $line_client->request('POST', self::LINE_NOTIFY_URI, [
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                            'Authorization' => 'Bearer ' . $mapping->group->token
                        ],
                        'form_params' => [
                            'message' => $line_message
                        ]
                    ]);

                    if ($results_line_notify->getStatusCode() == 200) {
                        $line_notify_flag = true;
                    }
                }
                // set message to unread
                $post_body = new \Google_Service_Gmail_ModifyMessageRequest();
                $post_body->setRemoveLabelIds('UNREAD');
                $result_gmail_unread = $this->google_rest_source->modify(self::GMAIL_USER_ID, $message->id, $post_body);

                // Store data to logs table
                $mapping->logs()->create([
                    'gmail_message_id' => $message->id,
                    'line_notify_flag' => $line_notify_flag
                ]);
            }   
        }

        // response result
        if (count($results->messages) == 0) {
            echo 'not found new mail';
        } else {
            echo 'get new ' . count($results->messages) . ' mail';
        }
    }
}
