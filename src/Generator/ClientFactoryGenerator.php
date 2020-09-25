<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientGenerator\Generator;

use DoclerLabs\ApiClientException\Factory\ResponseExceptionFactory;
use DoclerLabs\ApiClientGenerator\Ast\Builder\CodeBuilder;
use DoclerLabs\ApiClientGenerator\Generator\Implementation\ContainerImplementationStrategy;
use DoclerLabs\ApiClientGenerator\Generator\Implementation\HttpClientImplementationStrategy;
use DoclerLabs\ApiClientGenerator\Generator\Implementation\HttpMessageImplementationStrategy;
use DoclerLabs\ApiClientGenerator\Input\Specification;
use DoclerLabs\ApiClientGenerator\Naming\ClientNaming;
use DoclerLabs\ApiClientGenerator\Naming\CopiedNamespace;
use DoclerLabs\ApiClientGenerator\Output\Copy\Request\Mapper\RequestMapperInterface;
use DoclerLabs\ApiClientGenerator\Output\Copy\Response\ErrorHandler;
use DoclerLabs\ApiClientGenerator\Output\Copy\Serializer\BodySerializer;
use DoclerLabs\ApiClientGenerator\Output\Php\PhpFileCollection;
use PhpParser\Node\Stmt\ClassMethod;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;

class ClientFactoryGenerator extends GeneratorAbstract
{
    private HttpClientImplementationStrategy  $clientImplementation;
    private HttpMessageImplementationStrategy $messageImplementation;
    private ContainerImplementationStrategy   $containerImplementation;

    public function __construct(
        string $baseNamespace,
        CodeBuilder $builder,
        HttpClientImplementationStrategy $clientImplementation,
        HttpMessageImplementationStrategy $messageImplementation,
        ContainerImplementationStrategy $containerImplementation
    ) {
        parent::__construct($baseNamespace, $builder);
        $this->clientImplementation    = $clientImplementation;
        $this->messageImplementation   = $messageImplementation;
        $this->containerImplementation = $containerImplementation;
    }

    public function generate(Specification $specification, PhpFileCollection $fileRegistry): void
    {
        $className = ClientNaming::getFactoryClassName($specification);

        $this
            ->addImport(ClientInterface::class)
            ->addImport(ContainerInterface::class)
            ->addImport(ResponseExceptionFactory::class)
            ->addImport(CopiedNamespace::getImport($this->baseNamespace, RequestMapperInterface::class))
            ->addImport(CopiedNamespace::getImport($this->baseNamespace, ErrorHandler::class))
            ->addImport(CopiedNamespace::getImport($this->baseNamespace, BodySerializer::class))
            ->addImport(
                sprintf(
                    '%s%s\\%s',
                    $this->baseNamespace,
                    RequestMapperGenerator::NAMESPACE_SUBPATH,
                    $this->messageImplementation->getRequestMapperClassName()
                )
            );

        foreach ($this->clientImplementation->getInitBaseClientImports() as $import) {
            $this->addImport($import);
        }

        foreach ($this->containerImplementation->getContainerInitImports() as $import) {
            $this->addImport($import);
        }

        $initBaseClientMethodParams   = [];
        $initBaseClientMethodParams[] = $this->builder
            ->param('baseUri')
            ->setType('string')
            ->getNode();
        $initBaseClientMethodParams[] = $this->builder
            ->param('options')
            ->setType('array')
            ->getNode();

        $initBaseClientMethod = $this->clientImplementation
            ->generateInitBaseClientMethod()
            ->makePrivate()
            ->addParams($initBaseClientMethodParams)
            ->setReturnType('ClientInterface')
            ->getNode();

        $initRequestMapperMethod = $this->messageImplementation
            ->generateInitRequestMapperMethod()
            ->makePrivate()
            ->setReturnType('RequestMapperInterface')
            ->getNode();

        $initContainerMethod = $this->containerImplementation
            ->generateInitContainerMethod()
            ->makePrivate()
            ->setReturnType('ContainerInterface')
            ->getNode();

        $classBuilder = $this->builder
            ->class($className)
            ->addStmt($this->generateCreate($specification))
            ->addStmt($initBaseClientMethod)
            ->addStmt($initRequestMapperMethod)
            ->addStmt($initContainerMethod);

        $this->registerFile($fileRegistry, $classBuilder);
    }

    protected function generateCreate(Specification $specification): ClassMethod
    {
        $params   = [];
        $params[] = $this->builder
            ->param('baseUri')
            ->setType('string')
            ->getNode();
        $params[] = $this->builder
            ->param('options')
            ->setType('array')
            ->setDefault($this->builder->val([]))
            ->getNode();

        $clientClassName = ClientNaming::getClassName($specification);
        $statements[]    = $this->builder->return(
            $this->builder->new(
                $clientClassName,
                $this->builder->args(
                    [
                        $this->builder->localMethodCall(
                            'initBaseClient',
                            [$this->builder->var('baseUri'), $this->builder->var('options')]
                        ),
                        $this->builder->localMethodCall('initRequestMapper'),
                        $this->builder->new('ErrorHandler', [$this->builder->new('ResponseExceptionFactory')]),
                        $this->builder->localMethodCall('initContainer'),
                    ]
                )
            )
        );

        return $this->builder
            ->method('create')
            ->addParams($params)
            ->addStmts($statements)
            ->setReturnType($clientClassName)
            ->composeDocBlock($params, $clientClassName)
            ->getNode();
    }
}
