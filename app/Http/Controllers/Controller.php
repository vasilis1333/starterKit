<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function editButtonToHtml($route){
        return '<a href="'.$route.'" class="btn btn-info bg-soft btn-sm waves-effect btn-label waves-light">
                        <i class="bx bx bx-edit-alt label-icon"></i> Edit
                   </a>&nbsp;';
    }

    public function showButtonToHtml($route){
        return '<a href="'.$route.'" class="btn bg-soft btn-primary btn-sm waves-effect btn-label waves-light">
                        <i class="bx  bx bx-list-ol label-icon"></i> Show
                   </a>&nbsp;';
    }

    public function activeInactiveButtonToHtml($model,$route){
        if($model->is_active == 0){
            return '   <form style="display: inline-block"
                                   action="' . $route . '"
                                   method="POST">
                                   <input type="hidden" name="_token" value="' . csrf_token() . '">
                                   <button type="submit"
                                           class="btn btn-success bg-soft btn-sm waves-effect btn-label waves-light"
                                           onclick="return confirm(\'Είστε σίγουρος(η) για την ενεργοποίηση του χρήστη?\')">

                                         <i class="bx  bx bx-lock-open-alt label-icon"></i> Activate
                                   </button>
                                 </form> &nbsp;';
        }else{
            return  '   <form style="display: inline-block"
                                   action="' . $route . '"
                                   method="POST">
                                   <input type="hidden" name="_token" value="' . csrf_token() . '">
                                   <button type="submit"

                                             class="btn btn-danger bg-soft btn-sm waves-effect btn-label waves-light"
                                           onclick="return confirm(\'Είστε σίγουρος(η) για τη απενεργοποίηση του χρήστη?\')">

                                         <i class="bx   bx-lock-alt label-icon"></i> Lock
                                   </button>
                                 </form> &nbsp;';
        }
    }
}
