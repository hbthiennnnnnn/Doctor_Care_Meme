<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MedicineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'medicine_code' => 'required|string|max:100',
            'medicine_categories' => 'required|exists:medicine_categories,id',
            'ingredient' => 'nullable|string|max:255',
            'dosage_strength' => 'nullable|string|max:100',
            'unit' => 'required|string|max:50',
            'packaging' => 'required|string|max:100',
            'base_unit' => 'required|string|max:50',
            'quantity_per_unit' => 'required|integer|min:1',
            'sale_price' => 'required|numeric|min:0',
            'status' => 'required|in:1,0',
            'manufacturer' => 'required|string',
            'production_address' => 'required|string',
            'manufacture_date' => 'required|date|before_or_equal:today',
            'expiry_date' => 'required|date|after:manufacture_date',
            'quantity_received' => 'required|integer|min:1',
            'purchase_price' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên thuốc không được để trống.',
            'name.string' => 'Tên thuốc phải là một chuỗi ký tự.',

            'medicine_code.required' => 'Mã thuốc không được để trống.',
            'medicine_code.string' => 'Mã thuốc phải là một chuỗi ký tự.',
            'medicine_code.max' => 'Mã thuốc không được vượt quá 100 ký tự.',

            'medicine_categories.required' => 'Vui lòng chọn loại thuốc',
            'medicine_categories.exists' => 'Loại thuốc không tồn tại',

            'ingredient.string' => 'Thành phần phải là một chuỗi ký tự.',
            'ingredient.max' => 'Thành phần không được vượt quá 255 ký tự.',

            'dosage_strength.string' => 'Hàm lượng phải là một chuỗi ký tự.',
            'dosage_strength.max' => 'Hàm lượng không được vượt quá 100 ký tự.',

            'unit.required' => 'Đơn vị không được để trống.',
            'unit.string' => 'Đơn vị phải là một chuỗi ký tự.',
            'unit.max' => 'Đơn vị không được vượt quá 50 ký tự.',

            'packaging.required' => 'Quy cách đóng gói không được để trống.',
            'packaging.string' => 'Quy cách đóng gói phải là một chuỗi ký tự.',
            'packaging.max' => 'Quy cách đóng gói không được vượt quá 100 ký tự.',

            'base_unit.required' => 'Đơn vị cơ sở không được để trống.',
            'base_unit.string' => 'Đơn vị cơ sở phải là một chuỗi ký tự.',
            'base_unit.max' => 'Đơn vị cơ sở không được vượt quá 50 ký tự.',

            'quantity_per_unit.required' => 'Số lượng trên mỗi đơn vị không được để trống.',
            'quantity_per_unit.integer' => 'Số lượng trên mỗi đơn vị phải là số nguyên.',
            'quantity_per_unit.min' => 'Số lượng trên mỗi đơn vị phải lớn hơn 0.',

            'sale_price.required' => 'Giá bán không được để trống.',
            'sale_price.numeric' => 'Giá bán phải là số.',
            'sale_price.min' => 'Giá bán phải lớn hơn hoặc bằng 0.',

            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ. (1: Hoạt động, 0: Tạm ngưng)',

            'manufacturer.required' => 'Nhà sản xuất không được để trống.',
            'manufacturer.string' => 'Nhà sản xuất phải là chuỗi ký tự.',

            'production_address.required' => 'Nơi sản xuất không được để trống.',
            'production_address.string' => 'Nơi sản xuất phải là chuỗi ký tự.',

            'manufacture_date.required' => 'Ngày sản xuất không được để trống.',
            'manufacture_date.date' => 'Ngày sản xuất phải đúng định dạng ngày.',
            'manufacture_date.before_or_equal' => 'Ngày sản xuất không được lớn hơn ngày hiện tại.',

            'expiry_date.required' => 'Ngày hết hạn không được để trống.',
            'expiry_date.date' => 'Ngày hết hạn phải đúng định dạng ngày.',
            'expiry_date.after' => 'Ngày hết hạn phải sau ngày sản xuất.',

            'quantity_received.required' => 'Số lượng nhập không được để trống.',
            'quantity_received.integer' => 'Số lượng nhập phải là số nguyên.',
            'quantity_received.min' => 'Số lượng nhập phải lớn hơn 0.',

            'purchase_price.required' => 'Giá nhập không được để trống.',
            'purchase_price.integer' => 'Giá nhập phải là số nguyên.',
            'purchase_price.min' => 'Giá nhập phải lớn hơn 0.',
        ];
    }
}
