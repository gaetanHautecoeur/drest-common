<?php
namespace DrestCommon\Error\Response;


/**
 * Error Document (Xml)
 * @author Lee
 */
class Xml implements ResponseInterface
{
    /**
     * The error message
     * @var string $message
     */
    public $message;

    /**
     * @see Drest\Error\Response.ResponseInterface::setMessage()
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @see \Drest\Error\Response\ResponseInterface::render()
     */
    public function render()
    {
        $xml = new \DomDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $root = $xml->createElement('error');
        $xml->appendChild($root);

        $node = $xml->createElement('message', $this->getMessage());
        $root->appendChild($node);

        return $xml->saveXML();
    }

    /**
     * @see \Drest\Error\Response\ResponseInterface::getContentType()
     */
    public static function getContentType()
    {
        return 'application/xml';
    }

    /**
     * recreate this error document from a generated string
     * @param string $string
     * @throws \Exception
     * @return Xml $errorResponse
     */
    public static function createFromString($string)
    {
        $instance = new self();
        $xml = new \DomDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        if (!$xml->loadXML($string)) {
            throw new \Exception('Unable to load XML document from string');
        }

        $instance->setMessage($xml->documentElement->textContent);
        return $instance;
    }
}