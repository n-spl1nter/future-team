<?php

namespace App\Http\Controllers\Admin;

use App\Entities\MailSubscribe;
use App\Helpers\Export;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function index(Request $request)
    {
        $paginator = MailSubscribe::orderByDesc('created_at')
            ->paginate(20)
            ->appends($request->all());

        return view('admin.subscribers.index', compact('paginator'));
    }

    public function export()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM
            fputcsv($file, ['ID', 'Email', 'Status', 'Crated At']);
            /** @var MailSubscribe $mailSubscriber */
            foreach (MailSubscribe::all() as $mailSubscriber) {
                $fields = [
                    $mailSubscriber->id,
                    $mailSubscriber->email,
                    $mailSubscriber->status,
                    $mailSubscriber->created_at,
                ];
                fputcsv($file, $fields);
            }
            fclose($file);
        };

        return Export::getExportStream($callback, 'subscribers');
    }
}
