<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class ImageUpscallerController extends Controller
{
    public function runPythonScript()
    {
        $process = new Process(['python',]);
        $process->run();
        return $process->getOutput();
    }
}
