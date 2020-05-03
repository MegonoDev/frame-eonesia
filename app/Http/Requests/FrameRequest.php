<?php

namespace App\Http\Requests;

use App\Models\Background;
use Illuminate\Foundation\Http\FormRequest;

class FrameRequest extends FormRequest
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
            'nama_frame' => 'required',
            'type_frame' => 'required|in:square,portrait,landscape,story',
            'link_frame' => 'nullable|unique:frames',
            'frame'      => 'image|required',
            'id_bg'      => ['required',Rule::in(Background::pluck('id'))]
        ];
    }
}
