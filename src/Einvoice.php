<?php



namespace Rashadpoovannur\Mastergst;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class EInvoice
{
    protected $client;
    protected $config;
    protected $tokenExpiry;
    protected $authToken;
    protected $ipAddress;

    public function __construct()
    {
        $this->config = config('mastergst');
        $this->client = new Client([
            'base_uri' => $this->config['base_url'],
        ]);
    }

    public function authenticate($ipAddress = null)
    {


        $this->ipAddress = $ipAddress ? $ipAddress : $this->ipAddress;
        $email = $this->config['authentication']['email'];

        $response = $this->client->get('einvoice/authenticate', [
            'query' => [
                'email' => $email,
            ],
            'headers' => [
                'accept' => '*/*',
                'username' => $this->config['authentication']['username'],
                'password' => $this->config['authentication']['password'],
                'ip_address' => $ipAddress,
                'client_id' => $this->config['authentication']['client_id'],
                'client_secret' => $this->config['authentication']['client_secret'],
                'gstin' => $this->config['authentication']['gst_in'],
            ],
        ]);

        $response = json_decode($response->getBody(), true);

        $data = isset($response['data']) ? $response['data'] : [];

        if (isset($data, $data['TokenExpiry'], $data['AuthToken'])) {
            // Store the TokenExpiry and AuthToken for subsequent API calls
            $this->tokenExpiry = $data['TokenExpiry'];
            $this->authToken = $data['AuthToken'];
        }


        return $data;
    }



    public function gstdetails($param1)
    {
        if (!$this->authToken || !$this->tokenExpiry) {
            throw new \Exception('Authentication token is missing or expired.');
        }

        $email = $this->config['authentication']['email'];

        $response = $this->client->get("einvoice/type/GSTNDETAILS/version/V1_03?param1=$param1&email=$email", [
            'headers' => [
                'accept' => '*/*',
                'ip_address' => $this->config['authentication']['ip_address'],
                'client_id' => $this->config['authentication']['client_id'],
                'client_secret' => $this->config['authentication']['client_secret'],
                'username' => $this->config['authentication']['username'],
                'auth-token' => $this->authToken,
                'gstin' => $this->config['authentication']['gst_in'],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }



    public function generateIRn($invoiceData)
    {
        if (!$this->authToken || !$this->tokenExpiry) {
            // If authToken is missing or expired, re-authenticate
            $this->authenticate();
        }

        try {
            $response = $this->client->post("einvoice/type/GENERATE/version/V1_03?email={$this->config['authentication']['email']}", [
                'headers' => [
                    'accept' => '*/*',
                    'ip_address' => $this->ipAddress,
                    'client_id' => $this->config['authentication']['client_id'],
                    'client_secret' => $this->config['authentication']['client_secret'],
                    'username' => $this->config['authentication']['username'],
                    'auth-token' => $this->authToken,
                    'gstin' => $this->config['authentication']['gst_in'],
                    'Content-Type' => 'application/json',
                ],
                'json' => $invoiceData, // JSON-encoded invoice data
            ]);

            // Handle the API response here
            return json_decode($response->getBody(), true);
        } catch (ConnectException $e) {
            // Handle the ConnectException here

            return ['error' => 'Failed to connect to the API. Please try again later.'];
        }
    }
}
