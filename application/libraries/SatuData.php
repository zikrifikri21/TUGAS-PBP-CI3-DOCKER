<?php


class SatuData
{
    private $api;

    public function __construct()
    {
        $this->api = curl_init();
    }

    public function login($email, $password)
    {
        curl_setopt($this->api, CURLOPT_URL, 'https://satudata.uho.ac.id/api/satu-data/login');
        curl_setopt($this->api, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->api, CURLOPT_POSTFIELDS, json_encode([
            'email'    => $email,
            'password' => $password
        ]));
        curl_setopt($this->api, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($this->api);

        if (curl_getinfo($this->api, CURLINFO_HTTP_CODE) == 200) {
            $data = json_decode($response, true);
            if ($data['status'] != 'success') {
                return false;
            }

            Token::table()->insert([
                'token' => $data['token']
            ]);

            return $data['token'];
        } else {
            return false;
        }
    }

    public function getData($path, $token, $params = [])
    {
        if ($params) {
            curl_setopt($this->api, CURLOPT_URL, 'https://satudata.uho.ac.id/api/satu-data/' . $path . '?' . http_build_query($params));
        } else {
            curl_setopt($this->api, CURLOPT_URL, 'https://satudata.uho.ac.id/api/satu-data/' . $path);
        }
        curl_setopt($this->api, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->api, CURLOPT_HTTPGET, true);
        curl_setopt($this->api, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Accept: application/json'
        ]);

        $response = curl_exec($this->api);
        $data = json_decode($response, true);
        if ($data['status'] === 'error') {
            throw new Exception($data['message']);
        }

        if (curl_getinfo($this->api, CURLINFO_HTTP_CODE) == 200 || curl_getinfo($this->api, CURLINFO_HTTP_CODE) == 201) {
            $data = json_decode($response, true);
            $data = $data['data'];
            return $data;
        } else {
            $token = new Token();
            $last  = $token->last();
            $token->delete($last->id);
            throw new Exception($response);
        }
    }
}
