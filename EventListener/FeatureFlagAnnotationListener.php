<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\EventListener;

use Shopping\FeatureFlagBundle\Annotation\IsActive;
use Shopping\FeatureFlagBundle\Provider\FeatureFlagInterface;
use Doctrine\Common\Annotations\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class FeatureFlagAnnotationListener.
 */
class FeatureFlagAnnotationListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Reader
     */
    private $reader;
    /**
     * @var FeatureFlagInterface
     */
    private $featureFlag;

    /**
     * AllowedFilterAnnotationListener constructor.
     *
     * @param Reader               $reader
     * @param RequestStack         $requestStack
     * @param FeatureFlagInterface $featureFlag
     */
    public function __construct(Reader $reader, RequestStack $requestStack, FeatureFlagInterface $featureFlag)
    {
        $this->requestStack = $requestStack;
        $this->reader = $reader;
        $this->featureFlag = $featureFlag;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($event->getController())) {
            return;
        }

        /** @var Controller $controllerObject */
        list($controllerObject, $methodName) = $event->getController();

        $controllerReflectionObject = new \ReflectionObject($controllerObject);
        $reflectionMethod = $controllerReflectionObject->getMethod($methodName);

        /** @var IsActive|null $annotation */
        $annotation = $this->reader->getMethodAnnotation($reflectionMethod, IsActive::class);
        if ($annotation === null) {
            return;
        }

        if (!$this->featureFlag->isActive($annotation->getValue())) {
            throw new AccessDeniedHttpException(sprintf('FeatureFlag "%s" is not active.', $annotation->getValue()));
        }
    }
}
