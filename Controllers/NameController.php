<?php

declare(strict_types=1);

namespace CarClub\Controllers;

class NameController extends BaseController
{
    public function echoName(string $firstname, string $lastname = null): bool|string
    {
        $name = implode(' ', [$firstname, $lastname]);

        return view('name.echoName', compact('name'));
    }
}
