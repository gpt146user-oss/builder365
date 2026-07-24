<?php

namespace App\Http\Requests\Collaboration;

use App\Models\WorkTask;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkTaskAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('workTask');

        return $task instanceof WorkTask && ($this->user()?->can('updateDetails', $task) ?? false);
    }

    public function rules(): array
    {
        return [
            'attachment' => [
                'required', 'file', 'max:25600',
                'mimetypes:image/jpeg,image/png,image/webp,image/gif,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/plain,text/csv,application/zip,application/x-zip-compressed',
            ],
        ];
    }
}
