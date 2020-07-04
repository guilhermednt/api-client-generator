<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientGenerator\Input\Factory;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use DoclerLabs\ApiClientGenerator\Entity\OperationCollection;
use DoclerLabs\ApiClientGenerator\Entity\Request;
use DoclerLabs\ApiClientGenerator\Input\InvalidSpecificationException;
use ReflectionClass;

class OperationCollectionFactory
{
    private OperationFactory $operationFactory;

    public function __construct(OperationFactory $operationFactory)
    {
        $this->operationFactory = $operationFactory;
    }

    public function create(OpenApi $specification): OperationCollection
    {
        $collection = new OperationCollection();
        if (count($specification->paths) === 0) {
            throw new InvalidSpecificationException('No paths found in the specification.');
        }

        foreach ($specification->paths as $path => $pathItem) {
            foreach ($this->getOperations($pathItem) as $method => $operation) {
                if (!in_array($method, Request::ALLOWED_METHODS, true)) {
                    throw new InvalidSpecificationException(
                        sprintf('Unsupported request method `%s` in `%s`.', $method, $path)
                    );
                }

                $collection->add(
                    $this->operationFactory->create($operation, $path, $method, $pathItem->parameters ?? [])
                );
            }
        }

        return $collection;
    }

    private function getOperations(PathItem $pathItem): array
    {
        $r  = new ReflectionClass($pathItem);
        $pr = $r->getParentClass()->getProperty('_properties');
        $pr->setAccessible(true);

        return array_change_key_case($pr->getValue($pathItem), CASE_UPPER);
    }
}
