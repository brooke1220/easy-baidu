<?php

namespace EasyBaidu\OpenPlatform\CodeTemplate;

use EasyWeChat\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author caikeal <caiyuezhang@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * 获取草稿箱内的所有临时代码草稿
     *
     * @return mixed
     */
    public function getDrafts(int $page = 1, int $pageSize = 10)
    {
        $params = [
            'page' => 1,
            'page_size' => $pageSize
        ];

        return $this->httpGet('rest/2.0/smartapp/template/gettemplatedraftlist', $params);
    }

    /**
     * 将草稿箱的草稿选为小程序代码模版.
     *
     * @param int $draftId
     *
     * @return mixed
     */
    public function createFromDraft(int $draftId, string $userDesc)
    {
        $params = [
            'draft_id' => $draftId,
            'user_desc' => $userDesc
        ];

        return $this->httpPost('rest/2.0/smartapp/template/addtotemplate', $params);
    }

    /**
     * 获取代码模版库中的所有小程序代码模版.
     *
     * @return mixed
     */
    public function list(int $page = 1, int $pageSize = 10)
    {
        $params = [
            'page' => 1,
            'page_size' => $pageSize
        ];

        return $this->httpGet('rest/2.0/smartapp/template/gettemplatelist', $params);
    }

    /**
     * 删除指定小程序代码模版.
     *
     * @param $templateId
     *
     * @return mixed
     */
    public function delete($templateId)
    {
        $params = [
            'template_id' => $templateId,
        ];

        return $this->httpPost('rest/2.0/smartapp/template/deltemplate', $params);
    }
}
