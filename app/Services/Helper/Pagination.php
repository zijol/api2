<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/28
 * Time: 10:24
 */

namespace App\Services\Helper;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;

/**
 * @property $page
 * @property $per_page
 * @property $total
 * @property $total_page
 */
class Pagination implements Arrayable
{
    private $data = [
        'page' => 1,
        'per_page' => 10,
        'total' => 100,
        'total_page' => 5
    ];

    public function __construct($config, $total = 100)
    {
        if ($config instanceof Request) {
            $this->data['page'] = $config->input('page', 1);
            $this->data['per_page'] = $config->input('per_page', 10);
        } else if (is_array($config)) {
            $this->data['page'] = $config['page'] ?? 1;
            $this->data['per_page'] = $config['per_page'] ?? 10;
        } else {
            $this->data['page'] = intval($config);
        }

        $this->data['total'] = intval($total);
        $this->data['total_page'] = ceil($this->data['total'] / $this->data['per_page']);
    }

    public function toArray()
    {
        return $this->data;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'page':
                return $this->data['page'];
            case 'per_page':
                return $this->data['per_page'];
            case 'total_page':
                return $this->data['total_page'];
            case 'total':
                return $this->data['total'];

            default:
                return null;
        }
    }
}
