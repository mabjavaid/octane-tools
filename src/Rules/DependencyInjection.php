<?php

namespace Mabjavaid\OctaneTools\Rules;

use Illuminate\Support\Str;
use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Rule\ClassAware;
use PHPMD\Rule\FunctionAware;
use PHPMD\Rule\MethodAware;

class DependencyInjection extends AbstractRule implements MethodAware, ClassAware, FunctionAware
{
    public function apply(AbstractNode $node)
    {
        if (!$this->isProvider($node)) {
            return;
        }

        $nodes = $node->findChildrenOfType('Literal');

        foreach ($nodes as $methodCall) {
            if (Str::contains(json_encode($methodCall), 'singelton')) {
                $this->addViolation($methodCall);
            }
        }
    }

    private function isProvider(AbstractNode $node): bool
    {
        return preg_match("#app/Providers#", $node->getFileName());
    }
}
