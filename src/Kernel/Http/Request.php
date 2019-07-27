<?php

namespace EasyBaidu\Kernel\Http;

use Symfony\Component\HttpFoundation\Request as BaseRequest;
use EasyWeChat\Kernel\Exceptions\BadRequestException;
use EasyWeChat\Kernel\Support\Str;

class Request extends BaseRequest
{
    public function get($key, $default = null)
    {
        $result = parent::get($key, $default);

        if($result != $default){
            return $result;
        }

        if ($this !== $result = $this->post($key, $this)) {
            return $result;
        }

        return $default;
    }

    public function post($key, $default = null)
    {
        $message = $this->parseMessage($this->getContent(false));

        foreach($message as $mKey => $mValue){
            if(
                $mKey == $key ||
                Str::snake($mKey) == $key ||
                strtolower($mKey) == $key
            ){
                return $mValue;
            }
        }

        return $message[$key] ?? $default;
    }

    protected function parseMessage($content)
    {
        try {
            if (0 === stripos($content, '<')) {
                $content = XML::parse($content);
            } else {
                // Handle JSON format.
                $dataSet = json_decode($content, true);
                if ($dataSet && (JSON_ERROR_NONE === json_last_error())) {
                    $content = $dataSet;
                }
            }

            return (array) $content;
        } catch (\Exception $e) {
            throw new BadRequestException(sprintf('Invalid message content:(%s) %s', $e->getCode(), $e->getMessage()), $e->getCode());
        }
    }
}