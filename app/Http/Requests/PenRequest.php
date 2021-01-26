<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
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
                'alpha_dash',
                Rule::notIn(
                    collect(Route::getRoutes())
                        ->map(fn($route) => explode('/', $route->uri)[0])
                        ->unique()
                ),
                $this->pen
                    ? Rule::unique('pens')->ignore($this->pen->id)
                    : 'unique:pens',
                'max:25'
            ],
            'visibility' => [
                'required',
                Rule::in(['private', 'public', 'team', 'unlisted'])
            ],
        ];
    }
}
