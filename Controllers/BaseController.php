<?php

declare(strict_types=1);

namespace CarClub\Controllers;

use CarClub\Helpers\Input;
use JetBrains\PhpStorm\Pure;

/**
 * Class BaseController
 * @package CarClub\Controllers
 */
class BaseController
{
    /**
     * @var Input
     */
    protected Input $input;

    /**
     * BaseController constructor.
     */
    #[Pure] public function __construct()
    {
        $this->input = new Input();
    }
}
