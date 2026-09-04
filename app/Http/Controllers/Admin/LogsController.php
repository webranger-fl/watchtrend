<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SiteRequest;
use App\Models\NotFoundHit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    private const LOG_FILES = [
        'laravel' => [
            'title' => 'Laravel log',
            'path' => 'laravel.log',
        ],
        'worker' => [
            'title' => 'Worker log',
            'path' => 'worker.log',
        ],
    ];

    public function logsNotFound()
    {
      
      $items = NotFoundHit::latest()->paginate(50);

      return view('admin.logs.notFound', compact('items'));
    }

    public function show(string $log)
    {
        $logFile = $this->getLogFile($log);
        $path = storage_path('logs/' . $logFile['path']);
        $content = $this->readLog($path);

        return view('admin.logs.file', [
            'log' => $log,
            'logFile' => $logFile,
            'content' => $content,
            'path' => $path,
        ]);
    }

    public function clear(string $log)
    {
        $logFile = $this->getLogFile($log);
        $path = storage_path('logs/' . $logFile['path']);

        if (file_exists($path) && !is_writable($path)) {
            return redirect()->route('admin.logs.file', $log)
                ->with('msg', 'Нет прав на очистку файла лога');
        }

        if (@file_put_contents($path, '') === false) {
            return redirect()->route('admin.logs.file', $log)
                ->with('msg', 'Не удалось очистить файл лога');
        }

        return redirect()->route('admin.logs.file', $log)
            ->with('msg', 'Лог очищен');
    }

    private function getLogFile(string $log): array
    {
        abort_unless(isset(self::LOG_FILES[$log]), 404);

        return self::LOG_FILES[$log];
    }

    private function readLog(string $path): string
    {
        if (!file_exists($path)) {
            return 'Файл лога пока не создан.';
        }

        $size = filesize($path);
        $maxBytes = 200 * 1024;
        $offset = max(0, $size - $maxBytes);
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            return 'Не удалось прочитать файл лога.';
        }

        fseek($handle, $offset);
        $content = stream_get_contents($handle);
        fclose($handle);

        if ($offset > 0) {
            $content = "[Показаны последние 200 КБ файла]\n\n" . $content;
        }

        return $content ?: 'Файл лога пуст.';
    }

}
