<?php

declare(strict_types=1);

namespace CarClub\Controllers;

/**
 * Class HomepageController
 * @package CarClub\Controllers
 */
class HomepageController extends BaseController
{
    /**
     * @return bool|string
     */
    public function index(): bool|string
    {
        return view('homepage.index');
    }
}
