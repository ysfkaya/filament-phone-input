<?php

use Orchestra\Testbench\Dusk\Options;

if (isset($_SERVER['CI'])) {
    Options::withoutUI();
}

Options::windowSize(1920, 1080);
