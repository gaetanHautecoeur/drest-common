<?php
namespace DrestCommon\Request\Adapter;

use \Zend\Http,
    \Zend\Stdlib\Parameters,
    DrestCommon\Request\RequestException;

class ZendFramework2 extends AdapterAbstract
{

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::getAdpatedClassName()
     */
    public static function getAdaptedClassName()
    {
        return 'Zend\Http\Request';
    }

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::getHttpMethod()
     */
    public function getHttpMethod()
    {
        $const = 'METHOD_' . $this->getRequest()->getMethod();
        if (!defined('Drest\Request::' . $const)) {
            throw RequestException::unknownHttpVerb(get_class($this));
        }
        return constant('Drest\Request::' . $const);
    }

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::getBody()
     */
    public function getBody()
    {
        return $this->getRequest()->getContent();
    }

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::getCookie()
     */
    public function getCookie($name = null)
    {
        if ($name === null) {
            $cookieHeader = $this->getRequest()->getCookie();
            if (!empty($cookieHeader)) {
                return $cookieHeader->getArrayCopy();
            }
            return array();
        }
        if ($this->getRequest()->getCookie()->offsetExists($name)) {
            return $this->getRequest()->getCookie()->offsetGet($name);
        }
        return '';
    }

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::getHeaders()
     */
    public function getHeaders($name = null)
    {
        if ($name === null) {
            return $this->getRequest()->getHeaders()->toArray();
        }
        if ($this->getRequest()->getHeaders()->has($name)) {
            return $this->getRequest()->getHeaders()->get($name)->getFieldValue();
        }
        return '';
    }

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::getPost()
     */
    public function getPost($name = null)
    {
        if ($name === null) {
            return $this->getRequest()->getPost()->toArray();
        }
        if ($name !== null && $this->getRequest()->getPost()->offsetExists($name)) {
            return $this->getRequest()->getPost($name);
        }
        return '';
    }

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::setPost()
     */
    public function setPost($name, $value = null)
    {
        if (is_array($name)) {
            $this->getRequest()->setPost(new Parameters($name));
        } else {
            $this->getRequest()->getPost()->$name = $value;
        }
    }

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::getQuery()
     */
    public function getQuery($name = null)
    {
        if ($name === null) {
            return $this->getRequest()->getQuery()->toArray();
        }
        if ($name !== null && $this->getRequest()->getQuery()->offsetExists($name)) {
            return $this->getRequest()->getQuery($name);
        }
        return '';
    }

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::setQuery()
     */
    public function setQuery($name, $value = null)
    {
        if (is_array($name)) {
            $this->getRequest()->setQuery(new Parameters($name));
        } else {
            $this->getRequest()->getQuery()->$name = $value;
        }
    }

    /**
     * @see \DrestCommon\Request\Adapter\AdapterInterface::getUri()
     */
    public function getUri()
    {
        return $this->getRequest()->getUri()->toString();
    }

    /**
     * ZendFramework 2 Request object
     * @return \Zend\Http\Request $request
     */
    public function getRequest()
    {
        return $this->request;
    }
}