<?php
namespace DrestCommon\Representation;

/**
 * Base exception class for all Drest exceptions.
 *
 * @author Lee
 */
class RepresentationException extends \Exception
{

    public static function unknownRepresentationClass($class_name)
    {
        return new self('Unknown representation class "' . $class_name . '". Defined representation class must be an instance of DrestCommon\\Representation\\AbstractRepresentation');
    }

    public static function needRepresentationToUse()
    {
        return new self('Need to provide a valid representation class to interact with when constructing a Drest\\Client instance');
    }

    public static function representationMustBeObjectOrString()
    {
        return new self('Representation must be an object of DrestCommon\\Representation\\InterfaceRepresentation or a string representing the class name');
    }

    public static function representationMustBeInstanceOfDrestRepresentation()
    {
        return new self('Representation must be an instance of DrestCommon\\Representation\\InterfaceRepresentation, please ensure any custom built classes implement this');
    }

    public static function unableToDetermineARepresentation()
    {
        return new self('Unable to determine a representation class using both global and service configurations');
    }

    public static function unableToMatchARepresentation()
    {
        return new self('Unable to match a representation instance using Configuration::DETECT_CONTENT_* methods set');
    }

    public static function noRepresentationsSetForRoute($name, $className)
    {
        return new self('No representations have been set for the service "' . $name . '" for the Entity "' . $className . "'");
    }
}