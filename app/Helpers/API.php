<?php
function apiBaseUrl(){
    return 'http://47.91.108.23:80';
}

function callApi($url, $type = 'get', $data = [], $headers = []){
    $response = Http::withHeaders($headers)->$type(apiBaseUrl().'/'.$url, $data);

    return [
        'body' => $response->body(),
        'json' => $response->json(),
        'object' => $response->object(),
        'collect' => $response->collect(),
        'status' => $response->status(),
        'ok' => $response->ok(),
        'successful' => $response->successful(),
        'redirect' => $response->redirect(),
        'failed' => $response->failed(),
        'serverError' => $response->serverError(),
        'clientError' => $response->clientError(),
        'headers' => $response->headers(),
    ];
}

function punchStates(){
    return [
        "Check In",
        "Check Out",
    ];
}

function verifyTypes(){
    return [
        "Password",
        "Fingerprint",
        "Face",
        "Password",
    ];
}