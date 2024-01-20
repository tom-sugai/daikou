<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class MathComponent extends Component
{

    public function doComplexOperation($amount1, $amount2)
    {
        function plus($a, $b){
            return $a * $b;
        }
        echo "This is MathComponent" . "<br>";
        $val = plus($amount1, $amount2);
        return $val;
    }
}
