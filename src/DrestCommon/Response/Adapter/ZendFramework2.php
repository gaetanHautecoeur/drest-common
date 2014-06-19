<?php
namespace DrestCommon\Response\Adapter;

class ZendFramework2 extends AdapterAbstract
{

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::__toString()
     */
    public function toString()
    {
        $this->getResponse()->sendHeaders();
        return $this->getResponse()->getBody();
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::getAdpatedClassName()
     */
    public static function getAdaptedClassName()
    {
        return 'Zend\Http\PhpEnvironment\Response';
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::getHttpHeader()
     */
    public function getHttpHeader($name = null)
    {
        if ($name !== null) {
            return ($this->getResponse()->getHeaders()->has($name)) ? $this->getResponse()->getHeaders()->get(
                $name
            )->getFieldValue() : null;
        }
        return $this->getResponse()->getHeaders()->toArray();
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::setHttpHeader()
     */
    public function setHttpHeader($name, $value = null)
    {
        if (is_array($name)) {
            $this->getResponse()->getHeaders()->clearHeaders();
            $this->getResponse()->getHeaders()->addHeaders($name);
        } else {
            $this->getResponse()->getHeaders()->addHeaders(array($name => $value));
        }
    }

    /**
     * @see \DrestCommon\Response\Adapter\AdapterInterface::getBody()
     */
    public function getBody()
    {
        return $this->getResponse()->getBody();
    }

    /**
     * @see \DrestCommon\Response\Adapter.AdapterInterface::setBody()
     */
    public function setBody($body)
    {
        $this->getResponse()->setContent($body);
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
        $this->getResponse()->setStatusCode($code);
        $this->getResponse()->setReasonPhrase($text);
    }

    /**
     * ZendFramework 2 Response object
     * @return \Zend\Http\PhpEnvironment\Response $response
     */
    public function getResponse()
    {
        return $this->response;
    }
}