<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

const FREQUENCY = "apg.frequency_interval.";
if (! function_exists('customDateFormat')) {
    function customDateFormat($date, $onlyDate = true, $format = "m-d-Y")
    {
       return $onlyDate ? now()->parse($date)->format($format) : now()->parse($date)->format('m-d-Y h:i a');
    }
}

if (! function_exists('send_mail')) {
    function send_mail($toEmail, $subject, $body, $fromEmail = '', $attachment = '', $type = '', $fileName = '')
    {
        $csvFormat = '.csv';
        $pdfFormat = '.pdf';
        return Mail::html(
            $body,
            function ($message) use (
                $toEmail,
                $subject,
                $fromEmail,
                $attachment,
                $type,
                $fileName,
                $pdfFormat,
                $csvFormat,
            ) {
            $message->to($toEmail);
            $message->subject($subject);
            if ($type == config('apg.export_format.csv')) {
                $fileName = (!empty($fileName)) ? Str::slug($fileName) . $csvFormat : now() . $csvFormat;
                $message->attachData($attachment, $fileName);
            } else {
                $fileName = (!empty($fileName)) ? Str::slug($fileName) . $pdfFormat : now() . $pdfFormat;
                $message->attachData($attachment, $fileName);
            }
            if (! empty($fromEmail)) {
                $message->from($fromEmail);
            }
        });
    }
}

if (! function_exists('parseRangeDate')) {
    function parseRangeDate($date)
    {
        $date = explode('to', $date);
        $start_date = preg_replace("/\s+/", "",  current($date));
        $end_date = preg_replace("/\s+/", "",  next($date));

        try {
            return [
                'start_date' => !empty($start_date) ? Carbon::createFromFormat('m-d-Y', $start_date)->format('Y-m-d') : '',
                'end_date' => !empty($end_date) ? Carbon::createFromFormat('m-d-Y', $end_date)->format('Y-m-d') : '',
            ];
        } catch (\Throwable $th) {
            return ['start_date' => '', 'end_date' => ''];
        }
    }
}
if (! function_exists('createDateFormat')) {
    function createDateFormat($date)
    {
        try {
            return !empty($date) ? Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d') : '';
        } catch (\Throwable $th) {
            return '';
        }
    }
}

if (! function_exists('remainingDays')) {
    function remainingDays($date)
    {
        $days = now()->parse($date)->diff();
        return remainingFormat($days);
    }
}

if (! function_exists('remainingWarrantyDays')) {
    function remainingWarrantyDays($installationDate, $expiryDate)
    {
        if ($installationDate && $expiryDate && $installationDate <= $expiryDate) {
            $from = Carbon::parse($expiryDate);
            $to = Carbon::parse($installationDate);
            $days = $to->diff($from);
            return remainingFormat($days);
        }

        return '';
    }
}

if (! function_exists('remainingFormat')) {
    function remainingFormat($days)
    {
        $string = $days->y ? $days->y . " Year, " : '';
        $string .= $days->m ? $days->m . " Months, " : '';
        $string .= $days->d ? $days->d . " Days" : '';

        return $string ? rtrim($string, ', ') : 0;
    }
}

if (! function_exists('totalUseFulLife')) {
    function totalUseFulLife($total_useful_life)
    {
        $totalUseFul = isset($total_useful_life['year']) && !empty($total_useful_life['year'])
        ? $total_useful_life['year'] . " Years, " : '';
        $totalUseFul .= isset($total_useful_life['month']) && !empty($total_useful_life['month'])
        ? $total_useful_life['month'] . " Months, " : '';
        $totalUseFul .= isset($total_useful_life['day']) && !empty($total_useful_life['day'])
        ? $total_useful_life['day'] . " Days, " : '';

        return rtrim($totalUseFul, ', ');
    }
}

if (! function_exists('calculateTotalUseFulLife')) {
    function calculateTotalUseFulLife($installation_date, $data)
    {
        $year = $data['year'] ?? null;
        $month = $data['month'] ?? null;
        $day = $data['day'] ?? null;
        if ($year || $month || $day) {
            $useFulLifeDate = !empty($year)
            ? now()->parse($installation_date)->addYears($year) : $installation_date;
            $useFulLifeDate = !empty($month) ? now()->parse($useFulLifeDate)->addMonths($month) : $useFulLifeDate;
            $useFulLifeDate = !empty($day) ? now()->parse($useFulLifeDate)->addDays($day) : $useFulLifeDate;

            return $useFulLifeDate;
        }

        return null;
    }
}

if (! function_exists('currency')) {
    function currency($amount = 0)
    {
        return '$' . number_format($amount, 2);
    }
}

if (! function_exists('formatedId')) {
    function formatedId($id)
    {
        return str_pad((string) $id, 5, '0', STR_PAD_LEFT);
    }
}

if (! function_exists('getWorkOrderFrequencyDays')) {
    function getWorkOrderFrequencyDays($dueDate, $installationDate, $frequency)
    {
        $totalRemainingDays = $installationDate && $installationDate > now() ? now()->parse($dueDate)->diff($installationDate) : 0;

        return is_object($totalRemainingDays) && getFrequencyInterval($frequency) ?
        intdiv($totalRemainingDays->days, getFrequencyInterval($frequency)) : 0;
    }
}

if (! function_exists('getWorkOrderFrequencyDate')) {
    function getWorkOrderFrequencyDate($date, $frequency)
    {
        return now()->parse($date)->addDays(getFrequencyInterval($frequency));
    }
}

if (! function_exists('getFrequencyInterval')) {
    function getFrequencyInterval($frequency)
    {
        return config('apg.frequency_interval.' . strtolower($frequency));
    }
}
