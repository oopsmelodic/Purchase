<?php

class View
{
    //public $template_view; // здесь можно указать общий вид по умолчанию.

    public $dropdown = Array(Array('status'=>'','title'=>'Dashboard','name'=>'main','icon'=>'fa-dashboard','power'=>0,'href'=>'/main')
                    ,Array('status'=>'','title'=>'Purchases','name'=>'purchase','icon'=>'fa-table','power'=>0,'href'=>'/purchase')
                    ,Array('status'=>'','title'=>'Administration','name'=>'admin','icon'=>'fa-lock','power'=>100,'href'=>'/admin'),
                    Array('status'=>'','title'=>'Financial','name'=>'financial','icon'=>'fa-lock','power'=>85,'href'=>'/financial'),
                    Array('status'=>'','title'=>'Reports','name'=>'report','icon'=>'fa-lock','power'=>60,'href'=>'/report'));

    function dropdown_active($active){
        $result_str = '';
        foreach ($this->dropdown as $item) {
            if ($item['power']<=$_SESSION['user']['power']) {
                if ($active == strtolower($item['name'])) {
                    $result_str .= '<li class="active"><a href="' . $item['href'] . '"><i class="fa fa-fw ' . $item['icon'] . '"></i> ' . $item['title'] . '</a></li>';
                } else {
                    $result_str .= '<li class="'.$item['status'].'"><a href="' . $item['href'] . '"><i class="fa fa-fw ' . $item['icon'] . '"></i> ' . $item['title'] . '</a></li>';
                }
            }
        }

        return $result_str;
    }

    function generate($content_view, $template_view, $data = null)
    {
        /*
        if(is_array($data)) {
            // преобразуем элементы массива в переменные
            extract($data);
        }
        */


        $data['dropdown_active'] = $this->dropdown_active(array_shift(explode('_',$content_view)));

        include 'application/views/'.$template_view;
    }
}