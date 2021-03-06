<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 16:35
 */
namespace app\common\exception;

use Exception;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;

class Http extends Handle
{

    /**
     * 异常捕获处理
     *
     * 200: OK。一切正常。
     * 201: 响应 POST 请求时成功创建一个资源。Location header 包含的URL指向新创建的资源。
     * 204: 该请求被成功处理，响应不包含正文内容 (类似 DELETE 请求)。
     * 304: 资源没有被修改。可以使用缓存的版本。
     * 400: 错误的请求。可能通过用户方面的多种原因引起的，例如在请求体内有无效的JSON 数据，无效的操作参数，等等。
     * 401: 验证失败。
     * 403: 已经经过身份验证的用户不允许访问指定的 API 末端。
     * 404: 所请求的资源不存在。
     * 405: 不被允许的方法。 请检查 Allow header 允许的HTTP方法。
     * 415: 不支持的媒体类型。 所请求的内容类型或版本号是无效的。
     * 422: 数据验证失败 (例如，响应一个 POST 请求)。 请检查响应体内详细的错误消息。
     * 429: 请求过多。 由于限速请求被拒绝。
     * 500: 内部服务器错误。 这可能是由于内部程序错误引起的。
     * @param Exception $e
     * @return \think\Response
     */
    public function render(Exception $e)
    {
        // 请求异常
        if ($e instanceof HttpException) {
            return Response::create($e->getMessage(), $e->getStatusCode());
        }

        // 参数验证错误
        if ($e instanceof ValidateException) {
            return Response::create($e->getError(), 422);
        }

        // 资源不存在
        if ($e instanceof ModelNotFoundException) {
            return Response::create('请求的数据不存在', 404);
        }

        //可以在此交由系统处理
        return parent::render($e);
    }

}