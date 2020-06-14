<?php

namespace App\Http\Controllers;

class RestController extends Controller
{
    public $metaData = [];
    public $errorData = null;
    
    private $codes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Invalid Credentials.',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        1104 => "Auth Failed",

        //extra codes
        102 => 'Processing',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        308 => 'Permanent Redirect',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required'
    ];

    protected function sendResponse($data = null, $message = null, $statusCode = 200)
    {
        $message = $message ?: $this->getStatusCodeMessage($statusCode);

        return [
            'meta' => $this->getMetaResponse($statusCode,$message),
            'data' => $data
        ];
    }
    
    protected function sendError($message = null, $statusCode = 409)
    {
        $statusCode = key_exists($statusCode, $this->codes) ? $statusCode : 409;
        $message = $message ?: $this->getStatusCodeMessage($statusCode);
        
         $response = [
            'meta' => ['code' => $statusCode, 'message' => $message]
        ];
        if($this->errorData !== null){
            $response['data'] = $this->errorData;
        }
        return $response;
    }

    protected function getStatusCodeMessage($status)
    {
        return (isset($this->codes[$status])) ? $this->codes[$status] : 409;
    }
    
    protected function getMetaResponse($statusCode, $message){
        $metaResponse = ['code' => $statusCode, 'message' => $message];

        if($this->metaData && is_array($this->metaData) && !empty($this->metaData)){
            foreach ($this->metaData as $metaKey => $metaData){
                $metaResponse[$metaKey]= $metaData;
            }
        }
        return $metaResponse;
    }
}