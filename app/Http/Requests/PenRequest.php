<?php

namespace App\Http\Requests;

use App\Models\Pen;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PenRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'content' => ['required'],
            'title' => ['max:255'],
            'description' => [],
            'slug' => [
                'required',
                'alpha_num',
                $this->pen
                    ? Rule::unique('pens')->ignore($this->pen->id)
                    : 'unique:pens',
                'max:25'
            ],
            'visibility' => ['required', 'in:private,public,team'],
        ];
    }
}
