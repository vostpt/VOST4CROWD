<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'options' => 'required|array',
            'options.*.field_label' => 'required|string',
            'options.*.field_name' => 'required|string',
            'options.*.field_type' => 'required|string|in:boolean,string,integer,decimal',
            'options.*.field_nullable' => 'required|boolean',
            'status' => 'required|integer|in:0,1'
        ];
    }
}
