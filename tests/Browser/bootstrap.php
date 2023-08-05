<?php

if (isset($_SERVER['CI'])) {
    \Orchestra\Testbench\Dusk\Options::withoutUI();
}

\Orchestra\Testbench\Dusk\Options::windowSize(1920, 1080);
