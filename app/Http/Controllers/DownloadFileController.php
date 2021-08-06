<?php

namespace App\Http\Controllers;

use App\Template;
use Dompdf\Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Attachment;

use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Array_;
use Session;
use Mail;
use Symfony\Component\DomCrawler\Crawler;


class DownloadFileController extends Controller
{
    public function downloadFile($file){
        if($file){
            $name = explode("_", $file);   
            $file_name="";
            if(count($name)==4){
                $file_name=$name[3];
            }else{
                for($i=0; $i<count($name); $i++){  
                    if($i==3){
                        $file_name=$name[$i];
                    }         
                    if($i>3){
                        $file_name=$file_name.'_'.$name[$i];
                    }        
                }
                
            }
            //return $file_name;
            $temp=$name[0].'/'.$name[1].'/'.$name[2].'/'.$file_name;
            if(File::exists($temp)){
                return response()->download($temp);
            }
            
        }

        
    }

    public function downloadProductFile($file){
        //$file=htmlspecialchars($file);
        if($file){
            $name = explode("_", $file);   
            $file_name="";
            if(count($name)==6){
                $file_name=$name[5];
            }else{
                for($i=0; $i<count($name); $i++){  
                    if($i==5){
                        $file_name=$name[$i];
                    }         
                    if($i>5){
                        $file_name=$file_name.'_'.$name[$i];
                    }        
                }
                
            }
            //return $file_name;
            $temp=$name[0].'/'.$name[1].'/'.$name[2].'/'.$name[3].'/'.$name[4].'/'.$file_name;
            if(File::exists($temp)){
                return response()->download($temp);
            }
        }

        
    }

}
