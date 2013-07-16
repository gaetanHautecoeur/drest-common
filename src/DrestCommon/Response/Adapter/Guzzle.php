<?php
namespace DrestCommon\Response\Adapter;

use DrestCommon\Response\ResponseException;

class Guzzle extends AdapterAbstract
{
    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::__toString()
     */
    public function toString()
    {
        return $this->getResponse()->__toString();
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::getAdpatedClassName()
     */
    public static function getAdaptedClassName()
    {
        return 'Guzzle\Http\Message\Response';
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::getHttpHeader()
     */
    public function getHttpHeader($name = null)
    {
        if ($name !== null) {
            if ($this->getResponse()->hasHeader($name)) {
                return $this->getResponse()->getHeader($name)->__toString();
            }
            return null;
        }

        if (($this->getResponse()->getHeaders()->count() === 0)) {
            return array();
        } else {
            return array_map(function ($item) {
                /* @var \Guzzle\Http\Message\Header\HeaderInterface $item */
                return implode(', ', $item->toArray());
            }, $this->getResponse()->getHeaders()->getAll());
        }
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::setHttpHeader()
     */
    public function setHttpHeader($name, $value = null)
    {
        $value = (array)$value;
        if (is_array($name)) {
            foreach ($this->getResponse()->getHeaders(false) as $key => $value) {
                $this->getResponse()->removeHeader($key);
            }
            $this->getResponse()->addHeaders($name);
        } else {
            $this->getResponse()->addHeader($name, $value);
        }
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::getBody()
     */
    public function getBody()
    {
        return $this->getResponse()->getBody(true);
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::setBody()
     */
    public function setBody($body)
    {
        $this->getResponse()->setBody($body);
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::getStatusCode()
     */
    public function getStatusCode()
    {
        return $this->getResponse()->getStatusCode();
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::setStatusCode()
     */
    public function setStatusCode($code, $text)
    {
        $this->getResponse()->setStatus($code, $text);
    }

    /**
     * Guzzle Response object
     * @return \Guzzle\Http\Message\Response $response
     */
    public function getResponse()
    {
        return $this->response;
    }
}