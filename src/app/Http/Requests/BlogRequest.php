<?php

namespace App\Http\Requests;

use App\Models\Tag;
use Illuminate\Cache\TagSet;
use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tags' => 'required|array|max:5',
            'tags.*' => 'required|string|max:12',
            'title' => 'required|string|max:20',
            'textSections' => 'required|array|max:5',
            'textSections.*' => 'array',
            'textSections.*.text' => 'required|string',
            'textSections.*.header' => 'required|string',
            'textSections.*.id' => 'required|integer',
            'files' => 'required|array',
            'files.*' => 'array|max:5',
            'files.*.id' => 'required|integer',
            'files.*.file' => 'required|file|image|max:8192'
        ];
    }
}
