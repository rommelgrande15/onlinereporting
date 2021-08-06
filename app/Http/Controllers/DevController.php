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
use App\FctoryContact;
use App\Attachment;
use App\PSIProduct;
use App\InspectorAddress;
use App\Supplier;
use App\SupplierContact;
use App\ClientCost;
use App\InspectorCost;
use App\SavedProductCategories;
use App\SavedProductSubCategories;

use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Array_;
use Session;
use Mail;
use Symfony\Component\DomCrawler\Crawler;


class DevController extends Controller
{
    public function getCountInspectionDev($id){
        /* $wordlist = Wordlist::where('id', '<=', $correctedComparisons)->get();
        $wordCount = $wordlist->count(); */
        $Inspection = Inspection::where('client_id',$id)->whereMonth('created_at', date('m'))->whereYear('created_at', '=', date('Y'))->get();
        $count = $Inspection->count();
        return response()->json([
            'count' => $count
        ]);
    }
}
