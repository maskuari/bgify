<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Process\Process;

class BackgroundRemovalService
{
    public function remove(UploadedFile $image): array
    {
        $jobId = (string) Str::uuid();
        $workDirectory = storage_path("app/bgify/{$jobId}");
        $publicDirectory = "bgify/{$jobId}";

        File::ensureDirectoryExists($workDirectory);
        Storage::disk('public')->makeDirectory($publicDirectory);

        $inputPath = $image->move($workDirectory, 'original.'.$image->getClientOriginalExtension())->getPathname();
        $outputPath = storage_path("app/public/{$publicDirectory}/bgify-transparent.png");

        $process = new Process([
            config('bgify.python_binary'),
            config('bgify.script_path'),
            $inputPath,
            $outputPath,
        ]);

        $process->setEnv($this->pythonEnvironment());
        $process->setTimeout(config('bgify.timeout'));
        $process->run();

        if (! $process->isSuccessful() || ! File::exists($outputPath)) {
            $processMessage = trim($process->getErrorOutput()) ?: trim($process->getOutput()) ?: 'Background removal failed without process output.';

            report(new RuntimeException($processMessage));

            throw new RuntimeException('AI gagal memproses gambar. Pastikan Python, rembg, dan pillow sudah terpasang.');
        }

        return [
            'job_id' => $jobId,
            'result_url' => route('bgify.result', ['jobId' => $jobId]),
            'download_url' => route('bgify.download', ['jobId' => $jobId, 'quality' => 'standard']),
            'hd_download_url' => route('bgify.download', ['jobId' => $jobId, 'quality' => 'hd']),
        ];
    }

    private function pythonEnvironment(): array
    {
        $environment = [
            'SystemRoot' => getenv('SystemRoot') ?: 'C:\\Windows',
            'SYSTEMROOT' => getenv('SYSTEMROOT') ?: getenv('SystemRoot') ?: 'C:\\Windows',
            'WINDIR' => getenv('WINDIR') ?: getenv('SystemRoot') ?: 'C:\\Windows',
            'COMSPEC' => getenv('COMSPEC') ?: 'C:\\Windows\\System32\\cmd.exe',
            'PATH' => getenv('PATH') ?: getenv('Path') ?: '',
            'Path' => getenv('Path') ?: getenv('PATH') ?: '',
            'PATHEXT' => getenv('PATHEXT') ?: '.COM;.EXE;.BAT;.CMD',
            'TEMP' => getenv('TEMP') ?: sys_get_temp_dir(),
            'TMP' => getenv('TMP') ?: sys_get_temp_dir(),
            'USERPROFILE' => getenv('USERPROFILE') ?: '',
            'LOCALAPPDATA' => getenv('LOCALAPPDATA') ?: '',
            'PYTHONIOENCODING' => 'utf-8',
        ];

        return array_filter($environment, static fn ($value) => $value !== null && $value !== '');
    }
}
