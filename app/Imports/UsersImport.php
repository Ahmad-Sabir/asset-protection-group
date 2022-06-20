<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Validators\Failure;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;

    protected array $rows = [];

    /**
     *
     * @return array
     */

    public function rules(): array
    {
        $required = "required|max:255";
        return
            [
                'first_name'      => $required,
                'last_name'       => $required,
                'email'           => 'required|email',
            ];
    }

    /**
     *
     * @return array
     */

    public function customValidationMessages()
    {
        return [
            'email.required'       => 'User Email must not be empty!',
            'email.email'          => 'Incorrect User email address!',
            'first_name.required'  => 'User First Name must not be empty!',
            'first_name.max'       => 'The maximum length of The User First Name must not exceed :max',
            'last_name.required'   => 'User Last Name must not be empty!',
            'last_name.max'        => 'The maximum length of The User Last Name must not exceed :max',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'first_name'    => 'First Name',
            'last_name'     => 'Last Name',
            'email'         => 'Email',
        ];
    }

    /**
     *
     * @param mixed $rows
     * @return mixed
     */

    public function collection($rows)
    {
        $count = 0;
        foreach ($rows as $row) {
            $temporary_password = substr(hash('sha256', (string)time()), 0, 10);
            $password = Hash::make($temporary_password);
            if (User::where('email', $row['email'])->exists()) {
                User::where('email', $row['email'])->update([
                    'first_name' => $row['first_name'],
                    'last_name'  => $row['last_name'],
                    'password'   => $password,
                    'user_status' => config('apg.user_status.admin'),
                ]);
            } else {
                $userImport = User::create([
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['email'],
                    'password' => $password,
                    'user_status' => config('apg.user_status.admin'),
                ]);
                event(new Registered($userImport));
                $count++;
            }
        }
        $this->rows['success_rows'] = $count;
    }

    /**
     * @param Failure $failures
    */
    public function onFailure(Failure ...$failures): void
    {
        $this->rows['failures'] = $failures;
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
