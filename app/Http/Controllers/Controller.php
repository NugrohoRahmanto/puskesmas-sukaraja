<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function resolvePerPage(Request $request, array $options = [10, 25, 50, 'all'], int $default = 10): array
    {
        $value = $request->input('per_page', $default);

        if ($value === 'all' && in_array('all', $options, true)) {
            return [
                'perPage' => 'all',
                'options' => $options,
            ];
        }

        $numericOptions = array_filter($options, fn ($option) => $option !== 'all');

        $value = is_numeric($value) ? (int) $value : $default;
        if (!in_array($value, $numericOptions, true)) {
            $value = $default;
        }

        return [
            'perPage' => $value,
            'options' => $options,
        ];
    }
}
