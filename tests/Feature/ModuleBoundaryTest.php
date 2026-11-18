<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Arsitektur: Contracts, Events, dan Exceptions adalah API publik sebuah modul.
 * Modul lain tidak boleh memakai Models, Services, Http, atau Database-nya.
 */
class ModuleBoundaryTest extends TestCase
{
    public function test_modules_do_not_touch_other_modules_internals(): void
    {
        $modules = array_map('basename', File::directories(app_path('Modules')));
        $violations = [];

        foreach ($modules as $module) {
            foreach (File::allFiles(app_path("Modules/{$module}")) as $file) {
                $code = $file->getContents();
                foreach (array_diff($modules, [$module]) as $other) {
                    if (preg_match("/App\\\\Modules\\\\{$other}\\\\(Models|Services|Http|Database)\\\\/", $code)) {
                        $violations[] = "{$module}: {$file->getRelativePathname()} -> {$other}";
                    }
                }
            }
        }

        $this->assertGreaterThanOrEqual(3, count($modules));
        $this->assertSame([], $violations);
    }
}
