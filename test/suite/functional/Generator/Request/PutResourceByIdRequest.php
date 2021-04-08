<?php declare(strict_types=1);

/*
 * This file was generated by docler-labs/api-client-generator.
 *
 * Do not edit it manually.
 */

namespace Test\Request;

use DateTimeInterface;
use DoclerLabs\ApiClientException\RequestValidationException;
use Test\Schema\EmbeddedObject;
use Test\Schema\PutResourceByIdRequestBody;
use Test\Schema\SerializableInterface;

class PutResourceByIdRequest implements RequestInterface
{
    public const ENUM_PARAMETER_ONE_VALUE = 'one value';

    public const ENUM_PARAMETER_ANOTHER_VALUE = 'another value';

    public const ENUM_PARAMETER_THIRD_VALUE = 'third value';

    public const ALLOWED_ENUM_PARAMETER_LIST = [self::ENUM_PARAMETER_ONE_VALUE, self::ENUM_PARAMETER_ANOTHER_VALUE, self::ENUM_PARAMETER_THIRD_VALUE];

    public const MANDATORY_ENUM_PARAMETER_ONE_VALUE = 'one value';

    public const MANDATORY_ENUM_PARAMETER_ANOTHER_VALUE = 'another value';

    public const MANDATORY_ENUM_PARAMETER_THIRD_VALUE = 'third value';

    public const ALLOWED_MANDATORY_ENUM_PARAMETER_LIST = [self::MANDATORY_ENUM_PARAMETER_ONE_VALUE, self::MANDATORY_ENUM_PARAMETER_ANOTHER_VALUE, self::MANDATORY_ENUM_PARAMETER_THIRD_VALUE];

    private int $resourceId;

    private ?int $integerParameter = null;

    private ?string $stringParameter = null;

    private ?string $enumParameter = null;

    private ?DateTimeInterface $dateParameter = null;

    private ?float $floatParameter = null;

    private ?bool $booleanParameter = null;

    private ?array $arrayParameter = null;

    private ?EmbeddedObject $objectParameter = null;

    private int $mandatoryIntegerParameter;

    private string $mandatoryStringParameter;

    private string $mandatoryEnumParameter;

    private DateTimeInterface $mandatoryDateParameter;

    private float $mandatoryFloatParameter;

    private bool $mandatoryBooleanParameter;

    private array $mandatoryArrayParameter;

    private EmbeddedObject $mandatoryObjectParameter;

    private string $xRequestId;

    private ?string $csrfToken = null;

    private PutResourceByIdRequestBody $putResourceByIdRequestBody;

    private string $contentType = 'application/json';

    public function __construct(int $resourceId, int $mandatoryIntegerParameter, string $mandatoryStringParameter, string $mandatoryEnumParameter, DateTimeInterface $mandatoryDateParameter, float $mandatoryFloatParameter, bool $mandatoryBooleanParameter, array $mandatoryArrayParameter, EmbeddedObject $mandatoryObjectParameter, string $xRequestId, PutResourceByIdRequestBody $putResourceByIdRequestBody)
    {
        if ($resourceId < 0) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s`. Cannot be less than 0.', 'resourceId', $resourceId));
        }
        $this->resourceId                = $resourceId;
        $this->mandatoryIntegerParameter = $mandatoryIntegerParameter;
        $this->mandatoryStringParameter  = $mandatoryStringParameter;
        if (! \in_array($mandatoryEnumParameter, self::ALLOWED_MANDATORY_ENUM_PARAMETER_LIST, true)) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s` Allowed: %s', 'mandatoryEnumParameter', $mandatoryEnumParameter, \json_encode(self::ALLOWED_MANDATORY_ENUM_PARAMETER_LIST)));
        }
        $this->mandatoryEnumParameter     = $mandatoryEnumParameter;
        $this->mandatoryDateParameter     = $mandatoryDateParameter;
        $this->mandatoryFloatParameter    = $mandatoryFloatParameter;
        $this->mandatoryBooleanParameter  = $mandatoryBooleanParameter;
        $this->mandatoryArrayParameter    = $mandatoryArrayParameter;
        $this->mandatoryObjectParameter   = $mandatoryObjectParameter;
        $this->xRequestId                 = $xRequestId;
        $this->putResourceByIdRequestBody = $putResourceByIdRequestBody;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function setIntegerParameter(int $integerParameter): self
    {
        $this->integerParameter = $integerParameter;

        return $this;
    }

    public function setStringParameter(string $stringParameter): self
    {
        $this->stringParameter = $stringParameter;

        return $this;
    }

    /**
     * @throws RequestValidationException
     */
    public function setEnumParameter(string $enumParameter): self
    {
        if (! \in_array($enumParameter, self::ALLOWED_ENUM_PARAMETER_LIST, true)) {
            throw new RequestValidationException(\sprintf('Invalid %s value. Given: `%s` Allowed: %s', 'enumParameter', $enumParameter, \json_encode(self::ALLOWED_ENUM_PARAMETER_LIST)));
        }
        $this->enumParameter = $enumParameter;

        return $this;
    }

    public function setDateParameter(DateTimeInterface $dateParameter): self
    {
        $this->dateParameter = $dateParameter;

        return $this;
    }

    public function setFloatParameter(float $floatParameter): self
    {
        $this->floatParameter = $floatParameter;

        return $this;
    }

    public function setBooleanParameter(bool $booleanParameter): self
    {
        $this->booleanParameter = $booleanParameter;

        return $this;
    }

    /**
     * @param int[] $arrayParameter
     */
    public function setArrayParameter(array $arrayParameter): self
    {
        $this->arrayParameter = $arrayParameter;

        return $this;
    }

    public function setObjectParameter(EmbeddedObject $objectParameter): self
    {
        $this->objectParameter = $objectParameter;

        return $this;
    }

    public function setCsrfToken(string $csrfToken): self
    {
        $this->csrfToken = $csrfToken;

        return $this;
    }

    public function getMethod(): string
    {
        return 'PUT';
    }

    public function getRoute(): string
    {
        return \strtr('v1/resources/{resourceId}', ['{resourceId}' => $this->resourceId]);
    }

    public function getQueryParameters(): array
    {
        return \array_map(static function ($value) {
            return $value instanceof SerializableInterface ? $value->toArray() : $value;
        }, \array_filter(['integerParameter' => $this->integerParameter, 'stringParameter' => $this->stringParameter, 'enumParameter' => $this->enumParameter, 'dateParameter' => $this->dateParameter, 'floatParameter' => $this->floatParameter, 'booleanParameter' => $this->booleanParameter, 'arrayParameter' => $this->arrayParameter, 'objectParameter' => $this->objectParameter, 'mandatoryIntegerParameter' => $this->mandatoryIntegerParameter, 'mandatoryStringParameter' => $this->mandatoryStringParameter, 'mandatoryEnumParameter' => $this->mandatoryEnumParameter, 'mandatoryDateParameter' => $this->mandatoryDateParameter, 'mandatoryFloatParameter' => $this->mandatoryFloatParameter, 'mandatoryBooleanParameter' => $this->mandatoryBooleanParameter, 'mandatoryArrayParameter' => $this->mandatoryArrayParameter, 'mandatoryObjectParameter' => $this->mandatoryObjectParameter], static function ($value) {
            return null !== $value;
        }));
    }

    public function getRawQueryParameters(): array
    {
        return ['integerParameter' => $this->integerParameter, 'stringParameter' => $this->stringParameter, 'enumParameter' => $this->enumParameter, 'dateParameter' => $this->dateParameter, 'floatParameter' => $this->floatParameter, 'booleanParameter' => $this->booleanParameter, 'arrayParameter' => $this->arrayParameter, 'objectParameter' => $this->objectParameter, 'mandatoryIntegerParameter' => $this->mandatoryIntegerParameter, 'mandatoryStringParameter' => $this->mandatoryStringParameter, 'mandatoryEnumParameter' => $this->mandatoryEnumParameter, 'mandatoryDateParameter' => $this->mandatoryDateParameter, 'mandatoryFloatParameter' => $this->mandatoryFloatParameter, 'mandatoryBooleanParameter' => $this->mandatoryBooleanParameter, 'mandatoryArrayParameter' => $this->mandatoryArrayParameter, 'mandatoryObjectParameter' => $this->mandatoryObjectParameter];
    }

    public function getCookies(): array
    {
        return \array_map(static function ($value) {
            return $value instanceof SerializableInterface ? $value->toArray() : $value;
        }, \array_filter(['csrf_token' => $this->csrfToken], static function ($value) {
            return null !== $value;
        }));
    }

    public function getHeaders(): array
    {
        return \array_merge(['Content-Type' => $this->contentType], \array_map(static function ($value) {
            return $value instanceof SerializableInterface ? $value->toArray() : $value;
        }, \array_filter(['X-Request-ID' => $this->xRequestId], static function ($value) {
            return null !== $value;
        })));
    }

    /**
     * @return PutResourceByIdRequestBody
     */
    public function getBody()
    {
        return $this->putResourceByIdRequestBody;
    }
}
