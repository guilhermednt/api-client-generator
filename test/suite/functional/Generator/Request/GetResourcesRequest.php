<?php declare(strict_types=1);

/*
 * This file was generated by docler-labs/api-client-generator.
 *
 * Do not edit it manually.
 */

namespace Test\Request;

use Test\Request\SerializableRequestBodyInterface;

class GetResourcesRequest implements RequestInterface
{
    /** @var int|null */
    private $filterById;

    /** @var string|null */
    private $filterByName;

    /** @var int[]|null */
    private $filterByIds;

    /**
     * @param int $filterById
     *
     * @return self
     */
    public function setFilterById(int $filterById): self
    {
        $this->filterById = $filterById;

        return $this;
    }

    /**
     * @param string $filterByName
     *
     * @return self
     */
    public function setFilterByName(string $filterByName): self
    {
        $this->filterByName = $filterByName;

        return $this;
    }

    /**
     * @param int[] $filterByIds
     *
     * @return self
     */
    public function setFilterByIds(array $filterByIds): self
    {
        $this->filterByIds = $filterByIds;

        return $this;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return 'v1/resources';
    }

    /**
     * @return array
     */
    public function getQueryParameters(): array
    {
        return \array_map(static function ($value) {
            return $value instanceof SerializableRequestBody ? $value->toArray() : $value;
        }, \array_filter(['filterById' => $this->filterById, 'filterByName' => $this->filterByName, 'filterByIds' => $this->filterByIds], static function ($value) {
            return null !== $value;
        }));
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [];
    }

    public function getBody(): void
    {
    }
}
