<?php

namespace Rezsolt\ApiPlatformMakerBundle\Normalizer;

use Doctrine\Common\Inflector\Inflector;
use Rezsolt\ApiPlatformMakerBundle\Entity\CollectionInterface;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CollectionDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * Sets the owning Denormalizer object.
     *
     * @param DenormalizerInterface $denormalizer
     */
    public function setDenormalizer(DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data Data to restore
     * @param string $class The expected class to instantiate
     * @param string $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     *
     * @return object
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        /** @var \ArrayIterator $collection */
        $collection = new $class();
        $classParts = explode('\\', $class);
        $childClass = $class . '\\' . Inflector::singularize(array_pop($classParts));

        foreach ($data as $id => $itemData) {
            $itemData['id'] = $id;
            $item = $this->denormalizer->denormalize($itemData, $childClass);
            $collection->offsetSet($id, $item);
        }

        return $collection;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed $data Data to denormalize from
     * @param string $type The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
       return is_subclass_of($type, CollectionInterface::class);
    }
}