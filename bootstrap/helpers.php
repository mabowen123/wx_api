<?php

use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

/**
 * @param int $code 返回码
 * @param string $message 返回说明
 * @param array $data 成功时返回数据
 * @param array $errors 失败时返回数据
 * @return ResponseFactory|Response
 */
function responseApi(int $code, string $message, array $data = [], array $errors = [])
{
    return response(compact('code', 'message', 'data', 'errors'));
}

/**
 * @param array $data 返回数据
 * @param string $msg
 * @param int $code 返回码
 * @return ResponseFactory|Response
 */
function success(array $data, string $msg = 'OK', int $code = 1)
{
    return responseApi($code, $msg, $data);
}

/**
 * @param string $msg
 * @param int $code 返回码
 * @param array $errorsData
 * @return ResponseFactory|Response
 */
function failed(string $msg = 'Failed', int $code = 0, array $errorsData = [])
{
    return responseApi($code, $msg, [], $errorsData);
}
