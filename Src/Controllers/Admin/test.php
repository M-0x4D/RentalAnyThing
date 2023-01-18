<?
class HttpRequest
{

    private $curl;

    private array $headers;

    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->curl = curl_init();
        $this->baseUrl = $baseUrl;
    }

    public function set_url(string $url): void
    {
        $this->baseUrl .= $url;
        curl_setopt($this->curl, CURLOPT_URL, $this->baseUrl);
    }

    public function set_headers(array $headers): void
    {
        $this->headers = $headers;
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
    }

    public function get(string $authType, $data = []): array
    {
        curl_setopt($this->curl, CURLOPT_HTTPGET, true);
        return $this->send_request($data, $authType);
    }

    public function post(string $authType, $data = []): array
    {
        curl_setopt($this->curl, CURLOPT_POST, true);
        return $this->send_request($data, $authType);
    }


    public function patch(string $authType, $data = []): array
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        return $this->send_request($data, $authType);
    }

    public function put(string $authType, $data = []): array
    {
        curl_setopt($this->curl, CURLOPT_PUT, true);
        return $this->send_request($data, $authType);
    }

    public function delete(string $authType, $data = []): array
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->send_request($data, $authType);
    }

    private function send_request($data, string $authType)
    {
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        if ($authType === 'Bearer') {
            curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($this->curl);
        curl_close($this->curl);

        return [
            'body' => isset($this->headers['Content-Type']) && $this->headers['Content-Type'] === 'application/xml' ? $response : json_decode($response, true),
            'statusCode' => curl_getinfo($this->curl,  CURLINFO_RESPONSE_CODE)
        ];
    }
}
