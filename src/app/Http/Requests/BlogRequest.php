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
        $lastId = Tag::query()->latest('id')->first();

        return [
            'tags' => 'required|array|max:5',
            'tags.*' => 'integer|min:0|max:'.$lastId->id,

        ];
    }
}
