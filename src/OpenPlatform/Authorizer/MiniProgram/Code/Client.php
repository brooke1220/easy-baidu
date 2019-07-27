<?php

namespace EasyBaidu\OpenPlatform\Authorizer\MiniProgram\Code;

use EasyWeChat\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * @return \EasyWeChat\Kernel\Http\Response
     */
    public function gettrial()
    {
        return $this->httpGet('rest/2.0/smartapp/package/gettrial');
    }

    /**
     * @return \EasyWeChat\Kernel\Http\Response
     */
    public function list()
    {
        return $this->httpGet('rest/2.0/smartapp/package/get');
    }
    /**
     * @param int    $templateId
     * @param string $extJson
     * @param string $version
     * @param string $description
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function commit(int $templateId, string $extJson, string $version, string $description)
    {
        return $this->httpPost('rest/2.0/smartapp/package/upload', [
            'template_id' => $templateId,
            'ext_json' => $extJson,
            'user_version' => $version,
            'user_desc' => $description,
        ]);
    }

    /**
     * @return \EasyWeChat\Kernel\Http\Response
     */
    public function getQrCode(string $package_id, string $path, int $width = 200)
    {
        $params = array_filter(compact('package_id', 'path', 'width'));

        return $this->requestRaw('rest/2.0/smartapp/app/qrcode', 'GET', ['query' => $params]);
    }

    /**
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getCategory()
    {
        return $this->httpGet('rest/2.0/smartapp/app/category/list', ['category_type' => 2]);
    }

    /**
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getPage()
    {
        return $this->httpGet('wxa/get_page');
    }

    /**
     * @param array $itemList
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function submitAudit(int $package_id, string $content, string $remark)
    {
        return $this->httpPost('rest/2.0/smartapp/package/submitaudit', compact('package_id', 'content', 'remark'));
    }

    /**
     * @param int $auditId
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getAuditStatus(int $auditId)
    {
        return $this->httpPostJson('wxa/get_auditstatus', [
            'auditid' => $auditId,
        ]);
    }

    /**
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getLatestAuditStatus()
    {
        return $this->httpGet('wxa/get_latest_auditstatus');
    }

    /**
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function release(string $package_id)
    {
        return $this->httpPost('rest/2.0/smartapp/package/release', compact('package_id'));
    }

    /**
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function withdrawAudit()
    {
        return $this->httpGet('wxa/undocodeaudit');
    }

    /**
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function rollbackRelease()
    {
        return $this->httpGet('wxa/revertcoderelease');
    }

    /**
     * @param string $action
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function changeVisitStatus(string $action)
    {
        return $this->httpPostJson('wxa/change_visitstatus', [
            'action' => $action,
        ]);
    }
}
