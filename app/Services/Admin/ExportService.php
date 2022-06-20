<?php

namespace App\Services\Admin;

use App\Events\Export;
use Illuminate\Support\Facades\Auth;

class ExportService
{
    /**
     * Create a new event instance.
     *
     * @param mixed $data
     * @param mixed $templete
     * @param mixed $orientation
     * @param mixed $filter
     * @param mixed $fields
     * @param mixed $type
     * @param mixed $module
     * @return mixed
     */
    public function export($data, $templete, $orientation = '', $filter = '', $fields = '', $type = '', $module = [])
    {
        $module['toEmail'] = Auth::user()->email ?? config('apg.pdf_email.to_email');

        event(new Export($data, $templete, $orientation, $filter, $fields, $type, $module));

        return back()->with(['success' => 'Attachment send to your email successfully.']);
    }
}
