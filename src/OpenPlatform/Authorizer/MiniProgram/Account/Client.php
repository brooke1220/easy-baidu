<?php

namespace EasyBaidu\OpenPlatform\Authorizer\MiniProgram\Account;

use EasyWeChat\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author ClouderSky <clouder.flow@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * 获取账号基本信息.
     */
    public function getBasicInfo()
    {
        return $this->httpGet('rest/2.0/smartapp/app/info');
    }

    /**
     * 修改头像.
     *
     * @param string $mediaId 头像素材mediaId
     * @param int    $left    剪裁框左上角x坐标（取值范围：[0, 1]）
     * @param int    $top     剪裁框左上角y坐标（取值范围：[0, 1]）
     * @param int    $right   剪裁框右下角x坐标（取值范围：[0, 1]）
     * @param int    $bottom  剪裁框右下角y坐标（取值范围：[0, 1]）
     */
    public function updateAvatar(
        string $mediaId,
        float $left = 0,
        float $top = 0,
        float $right = 1,
        float $bottom = 1
    ) {
        $params = [
            'head_img_media_id' => $mediaId,
            'x1' => $left, 'y1' => $top, 'x2' => $right, 'y2' => $bottom,
        ];

        return $this->httpPostJson('cgi-bin/account/modifyheadimage', $params);
    }

    /**
     * 修改功能介绍.
     *
     * @param string $signature 功能介绍（简介）
     */
    public function updateSignature(string $signature)
    {
        $params = ['signature' => $signature];

        return $this->httpPostJson('cgi-bin/account/modifysignature', $params);
    }
}
