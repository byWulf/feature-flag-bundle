<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Shopping\FeatureFlagBundle\Annotation\IsActive;
use Shopping\FeatureFlagBundle\Provider\FeatureFlagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class FeatureFlagAnnotationListener.
 */
class FeatureFlagAnnotationListener
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var FeatureFlagInterface
     */
    private $featureFlag;

    /**
     * FeatureFlagAnnotationListener constructor.
     *
     * @param Reader               $reader
     * @param FeatureFlagInterface $featureFlag
     */
    public function __construct(Reader $reader, FeatureFlagInterface $featureFlag)
    {
        $this->reader = $reader;
        $this->featureFlag = $featureFlag;
    }

    /**
     * @param ControllerEvent $event
     *
     * @throws \ReflectionException
     */
    public function onKernelController(ControllerEvent $event): void
    {
        if (!is_array($event->getController())) {
            return;
        }

        /** @var AbstractController $controllerObject */
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
