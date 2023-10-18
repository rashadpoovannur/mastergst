<?php

namespace Rashadpoovannur\Mastergst;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rashadpoovannur\Mastergst\Skeleton\SkeletonClass
 */
class MastergstFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mastergst';
    }
}
