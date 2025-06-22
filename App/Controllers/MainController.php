<?php

namespace App\Controllers;

use App\Helpers\Functions;

class MainController{

    /***
     *
     * Funciones para las siguientes versiones del sistema
     * 
     */

    // public function Main(){
        
    //     $config = __DIR__."/../Config/Router.php";

    //     if(file_exists($config)){
    //         header('Location: /app/dashboard');
    //     }else{
    //         header('Location: /app/install');
    //     }
    // }

    // public function Install(){
    //     /**
    //      * vista para instalar las config del router;
    //      */

    //      Functions::view('Install', 'Install');
    // }

    // public function Dashboard(){
    //     /**
    //      * vista para el dashboard
    //      */

    //      Functions::redirect('/app/install', ["message"=>"sessio"]);
    // }

    /**
     * 
     * Termina la funciones pendientes
     * 
     */

    public function ajust(){
        Functions::redirect('/app/dashboard');
    }

    public function Dashboard(){
        Functions::view('Dashboard');
    }

    public function createVoucher(){
        Functions::view('CreateVoucher');
    }

    public function Vouchers(){
        Functions::view('Vouchers');
    }

    public function VouchersCreate(){
        // print_r($_POST);
        include_once __DIR__."/../../Views/printVouchers.view.php";
        // Functions::_addVoucher('');
    }

    public function listProfiles(){

        // print_r($var);
        // print_r($_SERVER);
        // print_r(Functions::_table(Functions::_getUsers()));

        Functions::view('Profiles');
    }

    public function listServers(){
        Functions::view('Servers');
    }

}