<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserInfo;
use App\Country;
use App\Language;
use App\Page;
use App\Section;
use App\Content;
use Session;
use DB;

class CMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex($id){
    	$role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $sections = Section::where('page',$id)->get();
        $sect = DB::table('sections')
        ->join('languages','sections.lang', '=','languages.id')
        ->join('pages','pages.id', '=', 'sections.page')
        ->select('sections.section_name','sections.id','languages.short_name','pages.name as pageName')
        ->where('sections.page',$id)
        ->get();
    	return view('pages.admin.cms.index',compact('role','user_info','sections','id','sect'));
    }

    public function getNewEntry($id){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $page = Page::find($id);
        $pages = Page::all();
        $langs = Language::where('used',1)->get();
        return view('pages.admin.cms.new',compact('role','user_info','page','langs','pages'));
    }

    public function updateContent($id){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $langs = Language::where('used',1)->get();
        $section = Section::find($id);
        $page = Page::find($section->page);
        $pages = Page::all();
        return view('pages.admin.cms.updatesection',compact('role','user_info','page','langs','section','pages'));
    }

    public function getPagesList(){
    	$role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $pages = Page::all();
    	return view('pages.admin.cms.pages',compact('role','user_info','pages'));
    }

    public function getLanguages(){
    	$role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $languages = Language::where('used',1)->get();
        $language = Language::where('used',0)->get();
    	return view('pages.admin.cms.languages',compact('role','user_info','languages','language'));
    }

    public function postNewLanguage(Request $request){
        $this->validate($request,array(
            'lang_country' => 'required',
        ));

        $lang = Language::where('short_name',$request['lang_country'])->first();
        $lang->used = 1;

        if ($lang->save()) {
            Session::flash('success','New language added successfully!');
            return redirect()->route('cms.languages');
        }else{
            Session::flash('error','There was a problem adding a new language! Please contact your system administrator!');
            return redirect()->route('cms.languages');
        }
    }

    public function postNewPage(Request $request){
        $this->validate($request,array(
            'page_name' => 'required',
            'page_description' => 'required',
            'slug' => 'unique:pages',
        ));

        $page = new Page();
        $page->name = $request['page_name'];
        $page->description = $request['page_description'];
        $page->slug = $request['slug'];

        if ($page->save()) {
            Session::flash('success','New page has been added successfully!');
            return redirect()->route('cms.pages');
        }else{
            Session::flash('error','There was a problem creating a new page! Please contact your system administrator!');
            return redirect()->route('cms.pages');
        }
    }

    public function postNewContent(Request $request){
        $this->validate($request,array(
            'page' => 'required',
            'language_id' => 'required',
            'section_name' => 'required',
            'title'=>'required'
        ));

        $content = new Section();
        $content->page = $request['page_id'];
        $content->lang = $request['language_id'];
        $content->title = $request['title'];
        $content->section_name = $request['section_name'];
        $content->content = $request['content'];

        if ($content->save()) {
            Session::flash('success','New section has been added successfully!');
            return redirect()->route('cms.index',$request['page_id']);
        }else{
            Session::flash('error','There was a problem saving the content! Please contact your system administrator!');
            return redirect()->route('cms.index',$request['page_id']);
        }
    }

    public function postUpdateContent(Request $request){
        $this->validate($request,array(
            'page' => 'required',
            'language_id' => 'required',
            'section_name' => 'required',
            'title'=>'required'
        ));

        $content = Section::find($request['section_id']);
        $content->page = $request['page_id'];
        $content->lang = $request['language_id'];
        $content->title = $request['title'];
        $content->section_name = $request['section_name'];
        $content->content = $request['content'];

        if ($content->save()) {
            Session::flash('success','Changes to content has been saved successfully!');
            return redirect()->route('cms.index',$request['page_id']);
        }else{
            Session::flash('error','There was a problem updating the content! Please contact your system administrator!');
            return redirect()->route('cms.index',$request['page_id']);
        }
    }

}
