<?php

namespace App\Http\Controllers;

use App\Template;
use Dompdf\Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Role;
use App\User;
use App\UserInfo;
use App\Inspection;
use App\Report;
use App\Factory;
use App\Country;
use App\Product;
use App\ClientContact;
use App\FactoryContact;
use App\Attachment;
use App\PSIProduct;
use App\InspectorAddress;

use DB;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\Array_;
use Session;
use Mail;
use Symfony\Component\DomCrawler\Crawler;


class AdminBookingController extends Controller
{


    public function getBookingPanel(){
        $user_info = UserInfo::where('user_id',Auth::id())->first();

        /* return view('pages.admin.dashboard.index',compact('inspections','services','role','user_info'));   */
        
		return view('pages.admin.booking.index',compact('user_info'));    	
    }

}
