<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerJNxsioV\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerJNxsioV/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerJNxsioV.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerJNxsioV\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerJNxsioV\App_KernelDevDebugContainer([
    'container.build_hash' => 'JNxsioV',
    'container.build_id' => '2db361f4',
    'container.build_time' => 1716131190,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerJNxsioV');