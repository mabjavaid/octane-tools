<?php

namespace Mabjavaid\OctaneTools\Rules;

use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Rule\ClassAware;
use PHPMD\Rule\FunctionAware;
use PHPMD\Rule\MethodAware;

class DependencyInjection extends AbstractRule implements FunctionAware, MethodAware, ClassAware
{
    public function apply(AbstractNode $node)
    {
        if (! $this->isProvider($node)) {
            return;
        }

        $nodes = $node->findChildrenOfType('MethodPostfix');
        foreach ($nodes as $node) {
            $identifier = $node->getFirstChildOfType('Identifier');
            if (! $identifier) {
                continue;
            }
            if ($identifier->getName() === 'singleton') {
                $closure = $node->getFirstChildOfType('Closure');
                $parameter = $closure->getFirstChildOfType('FormalParameters');
                if ($parameter->getFirstChildOfType('VariableDeclarator')) {
                    $this->addViolation($node);
                }
            }
        }
    }

    private function isProvider(AbstractNode $node): bool
    {
        return preg_match('#app/Providers#', $node->getFileName());
    }
}
