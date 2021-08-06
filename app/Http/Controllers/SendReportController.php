<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Report;
use App\Template;
use Carbon\Carbon;
use DateTime;
use DOMDocument;
use DOMNode;
use function foo\func;
use Illuminate\Http\Request;
use App\InspectionPhotos;
use App\Checklist;
use App\Supplier;
use App\Cargo;
use App\Loading;
use App\DetailedPhoto;
use App\DetailedProduct;
use App\DetailedProductQty;
use App\Observation;
use App\DetailedPhotoDescription;
use App\InspectionInfo;
use App\Inspection;
use App\Serial;
use App\UserInfo;

use App\productPhoto;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Mail;
use DB;
use PhpOffice\PhpWord\IOFactory;
use \PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Shared\Html;
use Symfony\Component\DomCrawler\Crawler;
use ZipArchive;

class SendReportController extends Controller
{
    public function sendMail(Request $request){

        $inspector_id=$request->input('inspector_id');
        $inspector = UserInfo::where("user_id",$inspector_id)->first();
        $inspector_name="Inspector Name";
        if($inspector){
            $inspector_name=$inspector->name;
        }
        $report_no=$request->input('report_no');
        
        $inspection=Inspection::select('created_by')->where('reference_number',$report_no)->first();
        $book_id="";
        if(!empty($inspection)){
            $book_id=$inspection->created_by;
        }
        $user_info=UserInfo::select('email_address')->where('user_id',$book_id)->first();
        $book_email="";
        if(!empty($user_info)){
            $book_email=$user_info->email_address;
        }
        $data = ['report_number' =>  $request->input('report_no'),"inspector_name"=>$inspector_name,'book_email'=>$book_email];

        Mail::send('email.report',$data, function($message) use ($data){
            $message->to('it-support@t-i-c.asia');
            $message->cc('gregor@t-i-c.asia');
            $message->cc('report@t-i-c.asia');
            if(!empty($data['book_email'])){
                $message->cc($data['book_email']);
            }
            //$message->cc('eloisa@the-inspection-company.com');
            //$message->to('ajay@etelligens.in');
            //$message->cc('ajaykr089@gmail.com');
            $message->subject('Inspection Report for ' . $data['report_number']);
        });

        if (count(Mail::failures()) > 0) {
            return response()->json([
                'Error'=>'There was an error sending your mail'
            ],500);
        }else{
            return response()->json([
                'message'=>'OK'
            ],200);
        }
    }



   


    public function downloadzipnew($id){
        $dirname = 'images/reports/' . $id;

        $zip = new ZipArchive;

        $zip_path= $dirname . '/' . $id . ".zip";
        $zip_url = URL::asset($zip_path);

        if (file_exists($zip_path))
			@unlink($zip_path);

        $zip->open($zip_path, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

        if (file_exists("images/reports/$id")){
            $files = File::allFiles("images/reports/$id");
            foreach ($files as $file){
                $zip->addFile($file->getPathname());
            }
        }

        $zip->close();

        return redirect($zip_url);
    }

    public function downloadzip($id){

        $zip = new ZipArchive;

        $zip_name = $id . ".zip";

        $zip_path='images/reports/' .$id. '/'.$zip_name;
        $zip_url = URL::asset($zip_path);

        @unlink($zip_path);


        $zres = $zip->open($zip_path, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

        if ($zres === TRUE) {
            $inpect_info = Inspection::where('reference_number',$id)->first();
            $checklist = Checklist::where('report_number',$id)->first();
            $supplier = Supplier::where('report_number',$id)->first();
            $cargo = Cargo::where('report_number',$id)->first();
            if ($cargo->container_status == 'good' ) {
                //$zip->addFile('images/placeholder.png');
                //$zip->addFile('images/placeholder.png');
            }else{

                if($cargo->container_status_photos!=null && !empty($cargo->container_status_photos)){

                    $container_status_photos=json_decode($cargo->container_status_photos);

                    if(is_array($container_status_photos) && !empty($container_status_photos)){

                        foreach ($container_status_photos as $key => $container_status_photo) {
                            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$container_status_photo->image);
                        }
                    }
                }
            }

            if ($cargo->holes == 'yes') {
                //$cargo_holes = 'images/placeholder.png';
                if($cargo->hole_photos!=null && !empty($cargo->hole_photos)){
                    $hole_photos=json_decode($cargo->hole_photos);
                    if(is_array($hole_photos) && !empty($hole_photos)){
                        foreach ($hole_photos as $key => $hole_photo) {
                            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$hole_photo->image);
                        }
                    }

                }
            }

            if ($cargo->dents == 'yes') {
                //$cargo_dents = 'images/placeholder.png';
                if($cargo->dent_photos!=null && !empty($cargo->dent_photos)){
                    $dent_photos=json_decode($cargo->dent_photos);
                    if(is_array($dent_photos) && !empty($dent_photos)){
                        foreach ($dent_photos as $key => $dent_photo) {
                            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$dent_photo->image);
                        }
                    }
                }

            }

            if ($cargo->pallet_material == null) {
                $pallet_material = 'images/placeholder.png';
            }else{
                $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->pallet_material);

            }

            if ($cargo->fumigation_stamp == null) {
                $fumigation_stamp = 'images/placeholder.png';
            }else{
                $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->fumigation_stamp);
            }


            $product_detail = DetailedProduct::where('report_number',$id)->get();
            $product_info = DetailedProductQty::where('report_number',$id)->first();
            $observation = Observation::where('report_number',$id)->first();
            if ($inpect_info->service == 'cbpi_serial') {
                $serials = Serial::where('report_number',$id)->get();
            }

            if (!empty($observation->damaged_product_photo)) {
                $zip->addFile('images/reports/'.$cargo->report_number.'/observation/'.$observation->damaged_product_photo);
            }

            $loadings = Loading::where('report_number',$id)->first();

            $desc = DetailedPhotoDescription::where('report_number',$id)->orderBy('photo_count', 'asc')->get();

            $zip->addFile('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_location);
            $zip->addFile('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_gate);

            $zip->addFile('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->warehouse);
            $zip->addFile('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->loading_area);

            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->loading_area);
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors);

            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->left_side);
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->right_side);

            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_floor_and_joint);
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_wall_and_joint);

            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_ceiling);
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_doors_closed);

            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->equipment_interchange_receipt);

            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_number_photo);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->empty_container);


            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->quarter_loaded_container);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->half_loaded_container);


            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->threefourth_loaded_container);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->full_loaded_container);

            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number);

            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number);


            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number);


            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->sera_seal_number);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->warehouse);


            $photos = DetailedPhoto::distinct()->select('photo_count')->where('report_number',$inpect_info->reference_number)->orderBy('photo_count', 'asc')->groupBy('photo_count')->get();

            foreach ($photos as $key => $value) {

                $images = DetailedPhoto::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->get();
                $descr = DetailedPhotoDescription::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->first();
                $length = count($images);

                foreach ($images as $k => $image) {
                    if ($k % 2 === 0) {

                        if ($k < $length) {
                            $zip->addFile('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k]->photo_count.'/'.$images[$k]->image_data);
                        }
                        if ($k+1 < $length) {
                            $zip->addFile('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k+1]->photo_count.'/'.$images[$k+1]->image_data);
                        }
                    }
                };

            }

        }

        $zip->close();

        /*header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$zip_name");
        header("Content-length: " . filesize($zip_path));
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        ob_clean();
        flush();*/
        return redirect($zip_url);
        //readfile($zip_path);
    }

    public function loadingReportNew($id){
		set_time_limit(0);
		ini_set('memory_limit', '-1');
		stream_context_set_default(['ssl'=>['verify_peer'=>false,'verify_peer_name'=>false]]);
        
		$id = strtoupper($id);
        $inspection = Inspection::where('reference_number', $id)->first();
        $template = $inspection->word_template?Template::where('id', $inspection->word_template)->first():Template::where('id', $inspection->template_id)->first();
        $report = Report::where('report_no', $id)->orderBy('created_at', 'desc')->first();
        $answers = Answer::where('report_id', $report->id)->orderBy('id', 'desc')->first();
		$translate = null;
        $ansArr = [];

        foreach (json_decode($answers->answers) as $data){
            foreach ($data->data as $datum){
                foreach ($datum as $k => $v){
                    $ansArr[$k] = [ 'value' => $v, 'title' => $data->title ];
                }
            }
        }

        $html = new Crawler();
		$html->addHtmlContent(preg_replace( "/\r|\n/", "", $template->html));
		
		if(!is_null($inspection->word_template)){
			$word_template = Template::where('id', $inspection->word_template)->first();
			$translate = new Crawler();
			$translate->addHtmlContent(preg_replace( "/\r|\n/", "", $word_template->html));
		}
			
        $html->filter('.header th[colspan=100]')->each(function ($crawler){
            foreach ($crawler as $node){
                $rem_node = $node->parentNode;
                $rem_node->parentNode->removeChild($rem_node);
            }
        });

        $html->filter('.footer th[colspan=100]')->each(function ($crawler){
            foreach ($crawler as $node){
                $rem_node = $node->parentNode;
                $rem_node->parentNode->removeChild($rem_node);
            }
        });

        $html->filter('div[tic-input=product-input]')->each(function ($crawler){
            $colspan = 0;
            if($crawler->parents()->getNode(1)->previousSibling->childNodes){
                foreach($crawler->parents()->getNode(1)->previousSibling->childNodes as $node){
                    if($node->nodeName == 'td'){
                        if($node->getAttribute('colspan'))
                            $colspan += $node->getAttribute('colspan') - 0;
                        else
                            ++$colspan;
                    }
                }
            } elseif ($crawler->parents()->getNode(1)->nextSibling->childNodes){
                foreach($crawler->parents()->getNode(1)->nextSibling->childNodes as $node){
                    if($node->nodeName == 'td'){
                        if($node->getAttribute('colspan'))
                            $colspan += $node->getAttribute('colspan') - 0;
                        else
                            ++$colspan;
                    }
                }
            }
            $crawler->getNode(0)->parentNode->removeAttribute('colspan');
            $crawler->getNode(0)->parentNode->setAttribute('colspan', $colspan>2?$colspan:2);
        });

        $html->filter('div[tic-input=product-description]')->each(function ($crawler){
            $colspan = 0;
            if($crawler->parents()->getNode(1)->previousSibling->childNodes){
                foreach($crawler->parents()->getNode(1)->previousSibling->childNodes as $node){
                    if($node->nodeName == 'td'){
                        if($node->getAttribute('colspan'))
                            $colspan += $node->getAttribute('colspan') - 0;
                        else
                            ++$colspan;
                    }
                }
            } elseif ($crawler->parents()->getNode(1)->nextSibling->childNodes){
                foreach($crawler->parents()->getNode(1)->nextSibling->childNodes as $node){
                    if($node->nodeName == 'td'){
                        if($node->getAttribute('colspan'))
                            $colspan += $node->getAttribute('colspan') - 0;
                        else
                            ++$colspan;
                    }
                }
            }
            $crawler->getNode(0)->parentNode->removeAttribute('colspan');
            $crawler->getNode(0)->parentNode->setAttribute('colspan', $colspan>2?$colspan:2);
        });

        $html->filter('img')->each(function ($crawler){
            if($crawler->getNode(0)->hasAttribute('style')){
                $properties = explode(';', trim($crawler->getNode(0)->getAttribute('style'), " \t\n\r\0\x0B;"));
                $width = 725;
				$height = 'auto';
                foreach ($properties as $property){
                    list($cKey, $cValue) = array_pad(explode(':', $property, 2), 2, null);
                    if(trim($cKey) == 'width'){
                        if (preg_match('/([0-9]+)%/', $cValue, $matches)) {
                            $width = (int) $matches[1] / 100 * $width;
                        } elseif (preg_match('/([0-9]+)[a-z]+/', $cValue, $matches)){
                            $width = (int) $matches[1] > $width?$width:(int) $matches[1];
                        }
                    } elseif(trim($cKey) == 'height'){
                        $height = trim($cValue);
                    }
                }
                $crawler->getNode(0)->removeAttribute('width');
                $crawler->getNode(0)->removeAttribute('height');
                $crawler->getNode(0)->setAttribute('width', $width);
                $crawler->getNode(0)->setAttribute('height', $height);

            }
        });

        $html->filter('table[tic-input=custom-table]')->each(function ($node) {
            $node->filterXPath('//td/*[@tic-input != "cb-option" and @tic-input != "product-option" and @tic-input != "cr-option" and @tic-input != "image"]')->each(function($nod){
                $attr = $nod->getNode(0)->getAttribute('tic-input');
                $nod->getNode(0)->removeAttribute('tic-input');
                $nod->getNode(0)->setAttribute('tic-component', $attr);
            });
        });

        $dump_node = [];
        $html->filterXPath('//td/*[@tic-input != "cb-option" and @tic-input != "product-option" and @tic-input != "cr-option" and @tic-input != "image"]')->each(function ($crawler) use ($id, $inspection, $ansArr, $translate, &$dump_node){
            $image_width = 0;
            $image_height = 0;
            $key = $crawler->attr('id');
            $type = $crawler->attr('tic-input');
            $node  = $crawler->getNode(0);
            $td = $node->parentNode;

            $doc = new DOMDocument;
            $div_node = $doc->createElement("div");

            if($node->hasAttribute('img-width'))
                $image_width = (int)$node->getAttribute('img-width');
            if($node->hasAttribute('img-height'))
                $image_height = (int)$node->getAttribute('img-height');
            switch ($type){
                case 'custom-table':
                    if($node->getAttribute('output') == 'stack'){
                        $ids = $crawler->filter('*[tic-component]')->each(function($comp){
                            return $comp->attr('id');
                        });

                        $ct = 0;
                        while(array_key_exists($ids[0] . $ct, $ansArr)){
                            $clone = tableClone($node, $node->ownerDocument, $ct);
                            $dom = $clone->ownerDocument;
                            $tbody = $clone->firstChild;

                            foreach($tbody->childNodes as $tr){

                                foreach($tr->childNodes as $td){
									
									for($i = $td->childNodes->length - 1; $i > -1; $i--){
											$tdchild = $td->childNodes->item($i);
											if($tdchild != null && $tdchild->getAttribute('tic-component') !== ''){
											$child_id = $tdchild->getAttribute('id');
											if($tdchild->hasAttribute('img-width'))
												$image_width = (int)$tdchild->getAttribute('img-width');
											if($tdchild->hasAttribute('img-height'))
												$image_height = (int)$tdchild->getAttribute('img-height');
											$has_label = !$tdchild->hasAttribute('no-label');
											switch($tdchild->getAttribute('tic-component')){
												case 'inputbox':
													$text = is_object($ansArr[$child_id]['value'])?$ansArr[$child_id]['value']->value:$ansArr[$child_id]['value'];
													$text_node = $dom->createTextNode($text);
													$td->replaceChild($text_node, $tdchild);
													break;
												case 'cb-group':
													$text = is_object($ansArr[$child_id]['value'])?$ansArr[$child_id]['value']->value:$ansArr[$child_id]['value'];
													$text = $translate?translate_cb($translate, $child_id, $text, $ansArr[$child_id]['value']->options, true):$text;
													$text_node = $dom->createTextNode($text);
													$tdchild = $td->replaceChild($text_node, $tdchild);
													break;
												case 'remarks':
													$text = is_object($ansArr[$child_id]['value'])?$ansArr[$child_id]['value']->value:$ansArr[$child_id]['value'];
													$text_node = $dom->createTextNode($text);
													$td->replaceChild($text_node, $tdchild);
													break;
												case 'picture':
													$output = 2;
													if($tdchild->getAttribute('output') == 'stack'){
														$output = 'stack';
													} else if ($tdchild->getAttribute('output') == '3-columns') {
														$output = 3;
													}
													if(is_array($ansArr[$child_id]['value'])){
														if(array_key_exists('value', $ansArr[$child_id])){
															$picturesArr = $ansArr[$child_id]['value'];
															$section = $ansArr[$child_id]['title'];
															$table = $dom->createElement('table');
															$tbody = $dom->createElement('tbody');
															
															if($output == 'stack'){
																foreach ($picturesArr as $picture){
																	if(property_exists($picture, 'value') && preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $picture->value)){
																		if($picture->type == 'multi-take-picture'){
																			$filename = basename($picture->value);
																			$row_header = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																			$cell->appendChild($text_node);
																			$row_header->appendChild($cell);

																			$row = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$image_node = $dom->createElement('img');
																			$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																			list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																			if($width > $height){
																				$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																			} else {
																				$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																			}
																			$cell->appendChild($image_node);
																			$row->appendChild($cell);
																			if($has_label) $tbody->appendChild($row_header);
																			$tbody->appendChild($row);
																		} elseif ($picture->type == 'multi-take-picture-remarks') {
																			$filename = basename($picture->value);
																			$row_header = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																			$cell->appendChild($text_node);
																			$row_header->appendChild($cell);
																			if($has_label) $tbody->appendChild($row_header);

																			$row = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$image_node = $dom->createElement('img');
																			$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																			list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																			if($width > $height){
																				$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																			} else {
																				$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																			}
																			$cell->appendChild($image_node);
																			$row->appendChild($cell);
																			$tbody->appendChild($row);
																			$row = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$text_node = $dom->createTextNode($picture->remark);
																			$cell->appendChild($text_node);
																			$row->appendChild($cell);
																			$tbody->appendChild($row);
																		}
																	}
																}
																$table->appendChild($tbody);
																$td->setAttribute('v-align', 'top');
															} else if(count($picturesArr) == 1){
																foreach ($picturesArr as $picture){
																	if(property_exists($picture, 'value') && preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $picture->value)){
																		if($picture->type == 'multi-take-picture'){
																			$filename = basename($picture->value);
																			$row_header = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																			$cell->appendChild($text_node);
																			$row_header->appendChild($cell);

																			$row = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$image_node = $dom->createElement('img');
																			$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																			list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																			if($width > $height){
																				$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																			} else {
																				$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																			}
																			$cell->appendChild($image_node);
																			$row->appendChild($cell);
																			if($has_label) $tbody->appendChild($row_header);
																			$tbody->appendChild($row);
																		} elseif ($picture->type == 'multi-take-picture-remarks') {
																			$filename = basename($picture->value);
																			$row_header = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																			$cell->appendChild($text_node);
																			$row_header->appendChild($cell);
																			if($has_label) $tbody->appendChild($row_header);

																			$row = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$image_node = $dom->createElement('img');
																			$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																			list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																			if($width > $height){
																				$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																			} else {
																				$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																			}
																			$cell->appendChild($image_node);
																			$row->appendChild($cell);
																			$tbody->appendChild($row);
																			$row = $dom->createElement('tr');
																			$cell = $dom->createElement('td');
																			$text_node = $dom->createTextNode($picture->remark);
																			$cell->appendChild($text_node);
																			$row->appendChild($cell);
																			$tbody->appendChild($row);
																		}
																	} else if(property_exists($picture, 'description')){
																		$section = $ansArr[$child_id]['title'];
																		if(count($ansArr[$child_id]['value']) > 0) {
																			foreach($ansArr[$child_id]['value'] as $description){
																				$table = $dom->createElement('table');
																				$tbody = $dom->createElement('tbody');
																				$row = $dom->createElement('tr');
																				$cell = $dom->createElement('td');
																				$cell->appendChild($dom->createTextNode($description->description));
																				if(count($description->pictures) > 1)
																					$cell->setAttribute('colspan', count($description->pictures));
																				$row->appendChild($cell);
																				$tbody->appendChild($row);

																				if(count($description->pictures) == 1){

																					foreach ($description->pictures as $picture){
																						$filename = basename($picture->value);

																						$row_header = $dom->createElement('tr');
																						$cell = $dom->createElement('td');
																						$cell->setAttribute('style', 'text-align: center');
																						$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																						$cell->appendChild($text_node);
																						$row_header->appendChild($cell);

																						$row = $dom->createElement('tr');
																						$cell = $dom->createElement('td');
																						$cell->setAttribute('style', 'text-align: center');
																						$image_node = $dom->createElement('img');
																						$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																						list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																						if($width > $height){
																							$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																						} else {
																							$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																						}
																						$cell->appendChild($image_node);
																						$row->appendChild($cell);
																						$tbody->appendChild($row);
																					}

																				} else {
																					$i = 0;
																					foreach ($description->pictures as $picture){
																						$filename = basename($picture->value);
																						if($i % 2 == 0){
																							$row_header = $dom->createElement('tr');
																							$row = $dom->createElement('tr');
																						}
																						$cell = $dom->createElement('td');
																						$cell->setAttribute('style', 'text-align: center');
																						$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																						$cell->appendChild($text_node);
																						$row_header->appendChild($cell);
																						$cell = $dom->createElement('td');
																						$cell->setAttribute('style', 'text-align: center');
																						$image_node = $dom->createElement('img');
																						$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																						list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																						if($width > $height){
																							$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																						} else {
																							$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																						}
																						$cell->appendChild($image_node);
																						$row->appendChild($cell);
																						if(count($description->pictures) === $i + 1 && $i % 2 === 0){
																							$cell = $dom->createElement('td');
																							$cell->setAttribute('style', 'text-align: center');
																							$text_node = $dom->createTextNode('N/A');
																							$cell->appendChild($text_node);
																							$row_header->appendChild($cell);
																							$cell = $dom->createElement('td');
																							$cell->setAttribute('style', 'text-align: center');
																							$text_node = $dom->createTextNode('N/A');
																							$cell->appendChild($text_node);
																							$row->appendChild($cell);
																						}
																						if($i % 2 == 0){
																							//if($has_label) $tbody->appendChild($row_header);
																							$tbody->appendChild($row);
																						}
																						++$i;
																					}
																				}
																				$table->appendChild($tbody);
																				$td->replaceChild($table, $tdchild);
																			}
																		}
																	} else {
																		//$row_header = $dom->createElement('tr');
																		//$cell = $dom->createElement('td');
																		//$cell->setAttribute('style', 'text-align: center');
																		//$text_node = $dom->createTextNode('N/A');
																		//$cell->appendChild($text_node);
																		//$row_header->appendChild($cell);

																		$row = $dom->createElement('tr');
																		$cell = $dom->createElement('td');
																		$cell->setAttribute('style', 'text-align: center');
																		$text_node = $dom->createTextNode('N/A');
																		$cell->appendChild($text_node);
																		$row->appendChild($cell);
																		//$tbody->appendChild($row_header);
																		$tbody->appendChild($row);
																	}
																}
															} else {
																$i = 0;
																foreach ($picturesArr as $picture){
																	if(property_exists($picture, 'value') && preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $picture->value)){
																		if($picture->type == 'multi-take-picture'){
																			$filename = basename($picture->value);
																			if($i % 2 == 0){
																				$row_header = $dom->createElement('tr');
																				$row = $dom->createElement('tr');
																			}
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																			$cell->appendChild($text_node);
																			$row_header->appendChild($cell);
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$image_node = $dom->createElement('img');
																			$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																			list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																			if($width > $height){
																				$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																			} else {
																				$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																			}
																			$cell->appendChild($image_node);
																			$row->appendChild($cell);
																			if(count($picturesArr) === $i + 1 && $i % 2 === 0){
																				$cell = $dom->createElement('td');
																				$cell->setAttribute('style', 'text-align: center');
																				$text_node = $dom->createTextNode('N/A');
																				$cell->appendChild($text_node);
																				$row_header->appendChild($cell);
																				$cell = $dom->createElement('td');
																				$cell->setAttribute('style', 'text-align: center');
																				$text_node = $dom->createTextNode('N/A');
																				$cell->appendChild($text_node);
																				$row->appendChild($cell);
																			}
																			if($i % 2 == 0){
																				if($has_label)  $tbody->appendChild($row_header);
																				$tbody->appendChild($row);
																			}
																			++$i;
																		} else if ($picture->type == 'multi-take-picture-remarks') {
																			$filename = basename($picture->value);
																			if($i % 2 == 0){
																				$row_header = $dom->createElement('tr');
																				$row = $dom->createElement('tr');
																				$row_remark = $dom->createElement('tr');
																			}
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																			$cell->appendChild($text_node);
																			$row_header->appendChild($cell);
																			$cell = $dom->createElement('td');
																			$cell->setAttribute('style', 'text-align: center');
																			$image_node = $dom->createElement('img');
																			$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																			list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																			if($width > $height){
																				$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																			} else {
																				$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																			}
																			$cell->appendChild($image_node);
																			$row->appendChild($cell);
																			$cell = $dom->createElement('td');
																			$text_node = $dom->createTextNode($picture->remark);
																			$cell->appendChild($text_node);
																			$row_remark->appendChild($cell);
																			if(count($picturesArr) === $i + 1 && $i % 2 === 0){
																				$cell = $dom->createElement('td');
																				$cell->setAttribute('style', 'text-align: center');
																				$text_node = $dom->createTextNode('N/A');
																				$cell->appendChild($text_node);
																				$row_header->appendChild($cell);
																				$cell = $dom->createElement('td');
																				$cell->setAttribute('style', 'text-align: center');
																				$text_node = $dom->createTextNode('N/A');
																				$cell->appendChild($text_node);
																				$row->appendChild($cell);
																			}
																			if($i % 2 == 0){
																				if($has_label) $tbody->appendChild($row_header);
																				$tbody->appendChild($row);
																				$tbody->appendChild($row_remark);
																			}
																			++$i;
																		}
																	} else if(property_exists($picture, 'description')){
																		$section = $ansArr[$child_id]['title'];
																		if(count($ansArr[$child_id]['value']) > 0) {
																			foreach($ansArr[$child_id]['value'] as $description){
																				$table = $dom->createElement('table');
																				$tbody = $dom->createElement('tbody');
																				$row = $dom->createElement('tr');
																				$cell = $dom->createElement('td');
																				$cell->appendChild($dom->createTextNode($description->description));
																				if(count($description->pictures) > 1)
																					$cell->setAttribute('colspan', $td->getAttribute('colspan'));
																				$row->appendChild($cell);
																				$tbody->appendChild($row);

																				if(count($description->pictures) == 1){

																					foreach ($description->pictures as $picture){
																						$filename = basename($picture->value);

																						$row_header = $dom->createElement('tr');
																						$cell = $dom->createElement('td');
																						$cell->setAttribute('style', 'text-align: center');
																						$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																						$cell->appendChild($text_node);
																						$row_header->appendChild($cell);

																						$row = $dom->createElement('tr');
																						$cell = $dom->createElement('td');
																						$cell->setAttribute('style', 'text-align: center');
																						$image_node = $dom->createElement('img');
																						$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																						list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																						if($width > $height){
																							$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																						} else {
																							$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																						}
																						$cell->appendChild($image_node);
																						$row->appendChild($cell);
																						$tbody->appendChild($row);
																					}

																				} else {
																					$i = 0;
																					foreach ($description->pictures as $picture){
																						$filename = basename($picture->value);
																						if($i % $output == 0){
																							$row_header = $dom->createElement('tr');
																							$row = $dom->createElement('tr');
																						}
																						$cell = $dom->createElement('td');
																						$cell->setAttribute('style', 'text-align: center');
																						$text_node = $translate?$dom->createTextNode(translate_text($translate, $child_id)):$dom->createTextNode($picture->label);
																						$cell->appendChild($text_node);
																						$row_header->appendChild($cell);
																						$cell = $dom->createElement('td');
																						$cell->setAttribute('style', 'text-align: center');
																						$image_node = $dom->createElement('img');
																						$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
																						list($width, $height) = getjpegsize($image_node->getAttribute('src'));
																						if($width > $height){
																							$image_node->setAttribute('width', $image_width == 0?200:$image_width);
																						} else {
																							$image_node->setAttribute('height', $image_height == 0?200:$image_height);
																						}
																						$cell->appendChild($image_node);
																						$row->appendChild($cell);
																						if(count($description->pictures) === $i + 1 && $i % $output === 0){
																							$cell = $dom->createElement('td');
																							$cell->setAttribute('style', 'text-align: center');
																							$text_node = $dom->createTextNode('N/A');
																							$cell->appendChild($text_node);
																							$row_header->appendChild($cell);
																							$cell = $dom->createElement('td');
																							$cell->setAttribute('style', 'text-align: center');
																							$text_node = $dom->createTextNode('N/A');
																							$cell->appendChild($text_node);
																							$row->appendChild($cell);
																						}
																						if(count($description->pictures) === $i + 1 && $i % $output === 0 && $output === 3){
																							$cell = $dom->createElement('td');
																							$cell->setAttribute('style', 'text-align: center');
																							$text_node = $dom->createTextNode('N/A');
																							$cell->appendChild($text_node);
																							$row_header->appendChild($cell);
																							$cell = $dom->createElement('td');
																							$cell->setAttribute('style', 'text-align: center');
																							$text_node = $dom->createTextNode('N/A');
																							$cell->appendChild($text_node);
																							$row->appendChild($cell);
																						}
																						if(count($description->pictures) === $i + 1 && $i % $output === 1 && $output === 3){
																							$cell = $dom->createElement('td');
																							$cell->setAttribute('style', 'text-align: center');
																							$text_node = $dom->createTextNode('N/A');
																							$cell->appendChild($text_node);
																							$row_header->appendChild($cell);
																							$cell = $dom->createElement('td');
																							$cell->setAttribute('style', 'text-align: center');
																							$text_node = $dom->createTextNode('N/A');
																							$cell->appendChild($text_node);
																							$row->appendChild($cell);
																						}
																						if($i % $output == 0){
																							//if($picture->label != '')
																							//if($has_label) $tbody->appendChild($row_header);
																							$tbody->appendChild($row);
																						}
																						++$i;
																					}
																				}
																				$table->appendChild($tbody);
																				$td->replaceChild($table, $tdchild);
																			}
																		}
																	} else {
																		$row_header = $dom->createElement('tr');
																		$cell = $dom->createElement('td');
																		$cell->setAttribute('style', 'text-align: center');
																		$text_node = $dom->createTextNode('N/A');
																		$cell->appendChild($text_node);
																		$row_header->appendChild($cell);

																		$row = $dom->createElement('tr');
																		$cell = $dom->createElement('td');
																		$cell->setAttribute('style', 'text-align: center');
																		$text_node = $dom->createTextNode('N/A');
																		$cell->appendChild($text_node);
																		$row->appendChild($cell);
																		if($has_label) $tbody->appendChild($row_header);
																		$tbody->appendChild($row);
																	}
																}
															}
															$table->appendChild($tbody);
															$td->replaceChild($table, $tdchild);
														}
													} else {
														if(preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $ansArr[$child_id]['value']->value)){
															$filename = basename($ansArr[$child_id]['value']->value);
															$section = $ansArr[$child_id]['title'];
															$image_node = $dom->createElement("img");
															$image_node->setAttribute('src', get_src($id, $section, $ansArr[$child_id]['value']->label, $filename));
															list($width, $height) = getjpegsize($image_node->getAttribute('src'));
															if($width > $height){
																$image_node->setAttribute('width', $image_width == 0?200:$image_width);
															} else {
																$image_node->setAttribute('height', $image_height == 0?200:$image_height);
															}
															$td->replaceChild($image_node, $tdchild);
														} else {
															$text_node = $dom->createTextNode('N/A');
															$td->replaceChild($text_node, $tdchild);
														}

													}
													break;
											}
										}
									}

                                }

                            }

                            $node->parentNode->appendChild($clone);
                            //$node->parentNode->appendChild($dom->createElement('br'));

                            $ct++;
                        }

                    } else {
                        $ids = $crawler->filter('*[tic-component]')->each(function($comp){
                            return $comp->attr('id');
                        });

                        $dom = $node->ownerDocument;
                        $parent = $node->childNodes->item(0);

                        $ct = 0;
                        while(array_key_exists($ids[0] . $ct, $ansArr)){
                            $main_row = $dom->createElement('tr');
                            foreach ($ids as $i){
                                $main_node = $crawler->filterXPath("//div[@id = '$i']")->getNode(0);
								if($main_node->hasAttribute('img-width'))
									$image_width = (int)$main_node->getAttribute('img-width');
								if($main_node->hasAttribute('img-height'))
									$image_height = (int)$main_node->getAttribute('img-height');
								$main_colspan = $main_node->parentNode->getAttribute('colspan');
                                $main_cell = $dom->createElement('td');
                                if($main_colspan != '')
                                    $main_cell->setAttribute('colspan', $main_colspan);
                                if(array_key_exists($i . $ct . '-combo-box-condition', $ansArr)) {
                                    $dump_cell = $crawler->filterXPath("//div[@id = '$i']")->attr('output-dump-cell-id');
                                    if ($dump_cell != '') {
                                        if (is_array($ansArr[$i . $ct . '-combo-box-condition']['value'])) {
                                            $combobox_cond = $ansArr[$i . $ct . '-combo-box-condition']['value'];
                                            $section = $ansArr[$i . $ct . '-combo-box-condition']['title'];
                                            foreach ($combobox_cond as $cond) {
                                                if (property_exists($cond, 'value') && preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $cond->value)) {
                                                    if (!array_key_exists($dump_cell . "_image", $dump_node))
                                                        $dump_node[$dump_cell . "_image"] = [];
                                                    if ($cond->type == 'multi-take-picture') {
                                                        $filename = basename($cond->value);
                                                        $item['label'] = $cond->label;
                                                        $item['src'] = 'images/reports/' . $id . '/' . str_replace(' ', '%20', $section) . '/' . str_slug($cond->label, '-') . '-' . $filename;
                                                        array_push($dump_node[$dump_cell . "_image"], $item);
                                                    } else if ($cond->type == 'multi-take-picture-remarks') {
                                                        $filename = basename($cond->value);
                                                        $item['label'] = $cond->label;
                                                        $item['src'] = 'images/reports/' . $id . '/' . str_replace(' ', '%20', $section) . '/' . str_slug($cond->label, '-') . '-' . $filename;
                                                        array_push($dump_node[$dump_cell . "_image"], $item);
                                                    }
                                                } else if (property_exists($cond, 'description')) {
                                                    if (!array_key_exists($dump_cell . "_image", $dump_node))
                                                        $dump_node[$dump_cell . "_image"] = [];
                                                    $section = $ansArr[$i . $ct . '-combo-box-condition']['title'];
                                                    if (count($ansArr[$i . $ct . '-combo-box-condition']['value']) > 0) {
                                                        foreach ($ansArr[$i . $ct . '-combo-box-condition']['value'] as $description) {
                                                            if (count($description->pictures) == 1) {
                                                                foreach ($description->pictures as $picture) {
                                                                    $filename = basename($picture->value);
                                                                    $item['label'] = $picture->label;
                                                                    $item['src'] = 'images/reports/' . $id . '/' . str_replace(' ', '%20', $section) . '/' . str_slug($picture->label, '-') . '-' . $filename;
                                                                    array_push($dump_node[$dump_cell . "_image"], $item);
                                                                }
                                                            } else {
                                                                foreach ($description->pictures as $picture) {
                                                                    $filename = basename($picture->value);
                                                                    $item['label'] = $picture->label;
                                                                    $item['src'] = 'images/reports/' . $id . '/' . str_replace(' ', '%20', $section) . '/' . str_slug($picture->label, '-') . '-' . $filename;
                                                                    array_push($dump_node[$dump_cell . "_image"], $item);
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    if (!array_key_exists($dump_cell . "_remarks", $dump_node))
                                                        $dump_node[$dump_cell . "_remarks"] = [];
                                                    if ($cond->type == 'multi-remarks') {
                                                        $text_node = $dom->createTextNode($cond->value);
                                                        array_push($dump_node[$dump_cell . "_remarks"], $text_node);
                                                    } else {
                                                        $text_node = $dom->createTextNode('N/A');
                                                        array_push($dump_node[$dump_cell . "_remarks"], $text_node);
                                                    }
                                                }
                                            }
                                        } else {
                                            if (!array_key_exists($dump_cell . "_remarks", $dump_node))
                                                $dump_node[$dump_cell . "_remarks"] = [];
                                            $text_node = $dom->createTextNode($ansArr[$i . $ct . '-combo-box-condition']['value']->value);
                                            array_push($dump_node[$dump_cell . "_remarks"], $text_node);
                                        }
                                    }
                                }
                                if(is_object($ansArr[$i . $ct]['value'])){
                                    if($ansArr[$i . $ct]['value']->type == 'take-picture'){
                                        $filename = basename($ansArr[$i . $ct]['value']->value);
                                        $section = $ansArr[$i . $ct]['title'];
                                        $image_node = $dom->createElement("img");
                                        $image_node->setAttribute('src', get_src($id, $section, $ansArr[$i . $ct]['value']->label, $filename));
                                        list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                        if($width > $height){
                                            $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                        } else {
                                            $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                        }
                                        $main_cell->appendChild($image_node);
                                    } else {
                                        $text_node = $dom->createTextNode($ansArr[$i . $ct]['value']->value);
                                        $main_cell->appendChild($text_node);
                                    }
                                } else {
                                    if(is_array($ansArr[$i . $ct]['value'])){
                                        $picturesArr = $ansArr[$i . $ct]['value'];
                                        $section = $ansArr[$i . $ct]['title'];

                                        foreach ($picturesArr as $picture){
                                            if(property_exists($picture, 'value') && preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $picture->value)){
                                                if($picture->type == 'multi-take-picture'){
                                                    $filename = basename($picture->value);
                                                    $image_node = $dom->createElement('img');
                                                    $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                                    list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                    if($width > $height){
                                                        $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                    } else {
                                                        $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                    }
                                                    $main_cell->appendChild($image_node);
                                                }
                                            }
                                        }
                                    } else {
                                        $text_node = $dom->createTextNode($ansArr[$i . $ct]['value']);
                                        $main_cell->appendChild($text_node);
                                    }
                                }
                                $main_row->appendChild($main_cell);
                            }
                            $parent->appendChild($main_row);
                            $ct++;
                        }
                    }
                    break;
                case 'gen-info':
                    if(is_array($ansArr[$key]['value'])){
                        foreach ($ansArr[$key]['value'] as $value){
                            $div = $doc->createElement('div');
                            $text_node = $doc->createTextNode($value);
                            $div->appendChild($text_node);
                            $div_node->appendChild($div);
                        }
                    } else {
                        $text = is_object($ansArr[$key]['value'])?$ansArr[$key]['value']->value:$ansArr[$key]['value'];
						$text = is_array($text)?$text[0]:$text;
                        $text_node = $doc->createTextNode(getGenInfo($text, $inspection));
                        $div_node->appendChild($text_node);
                    }
                    break;
                case 'inputbox':
                    $text = is_object($ansArr[$key]['value'])?$ansArr[$key]['value']->value:$ansArr[$key]['value'];
                    $text_node = $doc->createTextNode($text);
                    $div_node->appendChild($text_node);
                    break;
                case 'cr-group':
                    foreach ($ansArr[$key]['value'] as $option){
                        if($option->value === true)
                            $text_node = $doc->createTextNode('[!!X!!]' . $option->option);
                        else
                            $text_node = $doc->createTextNode('[!!Y!!]' . $option->option);
						$span = $doc->createElement('span');
						$span->appendChild($text_node);
                        $div_node->appendChild($span);
                        //$br = $doc->createElement('br');
                        //$div_node->appendChild($br);
                    }
                    break;
                case 'cb-group':
					$no_display = $node->hasAttribute('no-display');
                    $dump_cell = $node->getAttribute('output-dump-cell-id');
                    $combo_colspan = 0;
                    $table = $doc->createElement('table');
					if(!$no_display){
						if($ansArr[$key]['value']->show == 'no'){
							$text_node = $translate?$doc->createTextNode(translate_cb($translate, $key, $ansArr[$key]['value']->value, $ansArr[$key]['value']->options)):$doc->createTextNode($ansArr[$key]['value']->value);
							$div_node->appendChild($text_node);
						} else {
							$row = $doc->createElement('tr');
							foreach ($ansArr[$key]['value']->options as $option){
								$cell = $doc->createElement('td');
								$text_node = $translate?$doc->createTextNode(translate_cb($translate, $key, $option->option, $ansArr[$key]['value']->options)):$doc->createTextNode($option->option);
								$cell->appendChild($text_node);
								if($option->option == $ansArr[$key]['value']->value){
									$cell->setAttribute('style','background-color:#D3D3D3');//#fdeb37
								}
								$row->appendChild($cell);
								++$combo_colspan;
							}
							$table->appendChild($row);
							//$table->setAttribute('style','border:1px solid #111111');
							$div_node->appendChild($table);
						}
					}
                    if (array_key_exists($key . '-combo-box-condition',$ansArr)){
                        if($dump_cell === ''){
                            if($ansArr[$key . '-combo-box-condition']['value'] != null){
                                if(is_array($ansArr[$key . '-combo-box-condition']['value'])){
                                    $combobox_cond = $ansArr[$key . '-combo-box-condition']['value'];
                                    $section = $ansArr[$key . '-combo-box-condition']['title'];
                                    foreach ($combobox_cond as $cond){
                                        if(property_exists($cond, 'value') && preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $cond->value)){
                                            if($cond->type == 'multi-take-picture'){
                                                $filename = basename($cond->value);
                                                $row = $doc->createElement('tr');
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $cell->setAttribute('colspan', $combo_colspan);
                                                $image_node = $doc->createElement("img");
                                                $image_node->setAttribute('src', get_src($id, $section, $cond->label, $filename));
                                                list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                if($width > $height){
                                                    $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                } else {
                                                    $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                }
                                                $cell->appendChild($image_node);
                                                $row->appendChild($cell);
                                                $table->appendChild($row);
                                            } else if($cond->type == 'multi-take-picture-remarks') {
												$filename = basename($cond->value);
                                                $row = $doc->createElement('tr');
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $cell->setAttribute('colspan', $combo_colspan);
                                                $image_node = $doc->createElement("img");
                                                $image_node->setAttribute('src', get_src($id, $section, $cond->label, $filename));
                                                list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                if($width > $height){
                                                    $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                } else {
                                                    $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                }
                                                $cell->appendChild($image_node);
                                                $row->appendChild($cell);
                                                $table->appendChild($row);
                                                $row = $doc->createElement('tr');
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('colspan', $combo_colspan);
                                                $text_node = $doc->createTextNode('Remark: ' . $cond->remark);
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                                $table->appendChild($row);
                                            }
											$div_node->appendChild($table);
                                        } else if(property_exists($cond, 'description')){
                                            $section = $ansArr[$key . '-combo-box-condition']['title'];
                                            if(count($ansArr[$key . '-combo-box-condition']['value']) > 0) {
                                                foreach($ansArr[$key . '-combo-box-condition']['value'] as $description){
                                                    $table = $doc->createElement('table');
                                                    $tbody = $doc->createElement('tbody');
                                                    $row = $doc->createElement('tr');
                                                    $cell = $doc->createElement('td');
                                                    $cell->appendChild($doc->createTextNode($description->description));
                                                    if(count($description->pictures) > 1)
                                                        $cell->setAttribute('colspan', $td->getAttribute('colspan'));
                                                    $row->appendChild($cell);
                                                    $tbody->appendChild($row);

                                                    if(count($description->pictures) == 1){

                                                        foreach ($description->pictures as $picture){
                                                            $filename = basename($picture->value);

                                                            $row_header = $doc->createElement('tr');
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                                            $cell->appendChild($text_node);
                                                            $row_header->appendChild($cell);

                                                            $row = $doc->createElement('tr');
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $image_node = $doc->createElement('img');
                                                            $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                            if($width > $height){
                                                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                            } else {
                                                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                            }
                                                            $cell->appendChild($image_node);
                                                            $row->appendChild($cell);
                                                            $tbody->appendChild($row);
                                                        }

                                                    } else {
                                                        $i = 0;
                                                        foreach ($description->pictures as $picture){
                                                            $filename = basename($picture->value);
                                                            if($i % 2 == 0){
                                                                $row_header = $doc->createElement('tr');
                                                                $row = $doc->createElement('tr');
                                                            }
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                                            $cell->appendChild($text_node);
                                                            $row_header->appendChild($cell);
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $image_node = $doc->createElement('img');
                                                            $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                            if($width > $height){
                                                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                            } else {
                                                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                            }
                                                            $cell->appendChild($image_node);
                                                            $row->appendChild($cell);
                                                            if(count($description->pictures) === $i + 1 && $i % 2 === 0){
                                                                $cell = $doc->createElement('td');
                                                                $cell->setAttribute('style', 'text-align: center');
                                                                $text_node = $doc->createTextNode('N/A');
                                                                $cell->appendChild($text_node);
                                                                $row_header->appendChild($cell);
                                                                $cell = $doc->createElement('td');
                                                                $cell->setAttribute('style', 'text-align: center');
                                                                $text_node = $doc->createTextNode('N/A');
                                                                $cell->appendChild($text_node);
                                                                $row->appendChild($cell);
                                                            }
                                                            if($i % 2 == 0){
                                                                $tbody->appendChild($row_header);
                                                                $tbody->appendChild($row);
                                                            }
                                                            ++$i;
                                                        }
                                                    }
                                                    $table->appendChild($tbody);
                                                    $div_node->appendChild($doc->createElement('br'));
                                                    $div_node->appendChild($table);
                                                }
                                            }
                                        } else {
                                            if($cond->type == 'multi-remarks') {
                                                $paragraph = $doc->createElement('p');
                                                $text_node = $doc->createTextNode($cond->value);
                                                $paragraph->appendChild($text_node);
                                                $div_node->appendChild($paragraph);
                                            } else {
                                                $text_node = $doc->createTextNode('N/A');
                                                $div_node->appendChild($text_node);
                                            }
                                        }
                                    }
                                } else {
                                    if(is_object($ansArr[$key . '-combo-box-condition']['value'])){
                                        if(property_exists($ansArr[$key . '-combo-box-condition']['value'], 'value')){
                                            if(preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $ansArr[$key . '-combo-box-condition']['value']->value)){
                                                $filename = basename($ansArr[$key . '-combo-box-condition']['value']->value);
                                                $section = $ansArr[$key . '-combo-box-condition']['title'];
                                                $row = $doc->createElement('tr');
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $cell->setAttribute('colspan', $combo_colspan);
                                                $image_node = $doc->createElement("img");
                                                $image_node->setAttribute('src', get_src($id, $section, $ansArr[$key . '-combo-box-condition']['value']->label, $filename));
                                                list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                if($width > $height){
                                                    $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                } else {
                                                    $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                }
                                                $cell->appendChild($image_node);
                                                $row->appendChild($cell);
                                                $table->appendChild($row);
                                            } else {
                                                if(is_array($ansArr[$key . '-combo-box-condition'])){
                                                    if($ansArr[$key . '-combo-box-condition']['value']->value == 'N/A'){
                                                        $text_node = $doc->createTextNode('N/A');
                                                        $div_node->appendChild($text_node);
                                                    } else {
                                                        if($ansArr[$key . '-combo-box-condition']['value']->value !== "null"){
                                                            $text_node = $doc->createTextNode($ansArr[$key . '-combo-box-condition']['value']->value);
                                                            $div_node->appendChild($text_node);
                                                        }
                                                    }
                                                } else {
                                                    $text_node = $doc->createTextNode($ansArr[$key . '-combo-box-condition']['value']->value);
                                                    $div_node->appendChild($text_node);
                                                }
                                            }
                                        } else {
                                            $palletized = $ansArr[$key . '-combo-box-condition']['value'];
                                            if($palletized){
                                                $section = $ansArr[$key . '-combo-box-condition']['title'];
                                                $dom = $td->ownerDocument;
                                                $tbody = $td->parentNode->parentNode;
                                                $row = $dom->createElement('tr');
                                                $cell = $dom->createElement('td');
                                                $cell->setAttribute('colspan', $td->getAttribute('colspan') / 2);
                                                $text_node = $dom->createTextNode($palletized->material->label);
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                                $cell = $dom->createElement('td');
                                                $cell->setAttribute('colspan', $td->getAttribute('colspan') / 2);
                                                $text_node = $dom->createTextNode($palletized->material->value);
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                                $tbody->appendChild ($row);
                                                $row = $dom->createElement('tr');
                                                $cell = $dom->createElement('td');
                                                $cell->setAttribute('colspan', $td->getAttribute('colspan') / 2);
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $dom->createTextNode($palletized->materialPicture->label);
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                                $cell = $dom->createElement('td');
                                                $cell->setAttribute('colspan', $td->getAttribute('colspan') / 2);
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $dom->createTextNode($palletized->fumigationStampPicture->label);
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                                $tbody->appendChild ($row);
                                                $row = $dom->createElement('tr');
                                                $cell = $dom->createElement('td');
                                                $cell->setAttribute('colspan', $td->getAttribute('colspan') / 2);
                                                $cell->setAttribute('style', 'text-align: center');
                                                if(preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $palletized->materialPicture->value)){
                                                    $filename = basename($palletized->materialPicture->value);
                                                    $image_node = $dom->createElement("img");
                                                    $image_node->setAttribute('src', get_src($id, $section, $palletized->materialPicture->label, $filename));
                                                    list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                    if($width > $height){
                                                        $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                    } else {
                                                        $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                    }
                                                    $cell->appendChild($image_node);
                                                } else {
                                                    $text_node = $dom->createTextNode($palletized->materialPicture->value);
                                                    $cell->appendChild($text_node);
                                                }
                                                $row->appendChild($cell);
                                                $cell = $dom->createElement('td');
                                                $cell->setAttribute('colspan', $td->getAttribute('colspan') / 2);
                                                $cell->setAttribute('style', 'text-align: center');
                                                if(preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $palletized->fumigationStampPicture->value)){
                                                    $filename = basename($palletized->fumigationStampPicture->value);
                                                    $image_node = $dom->createElement("img");
                                                    $image_node->setAttribute('src', get_src($id, $section, $palletized->fumigationStampPicture->label, $filename));
                                                    list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                    if($width > $height){
                                                        $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                    } else {
                                                        $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                    }
                                                    $cell->appendChild($image_node);
                                                } else {
                                                    $text_node = $dom->createTextNode($palletized->fumigationStampPicture->value);
                                                    $cell->appendChild($text_node);
                                                }
                                                $row->appendChild($cell);
                                                $tbody->appendChild ($row);
                                                $row = $dom->createElement('tr');
                                                $cell = $dom->createElement('td');
                                                $cell->setAttribute('colspan', $td->getAttribute('colspan'));
                                                $table_nested = $dom->createElement('table');
                                                $table_nested->setAttribute('style', 'border:1px solid #000000');
                                                $tbody_nested = $dom->createElement('tbody');
                                                $row_nested = $dom->createElement('tr');
                                                $cell_nested = $dom->createElement('td');
                                                $cell_nested->appendChild($dom->createTextNode($palletized->palletsLoaded->label));
												$cell_nested->setAttribute('colspan', 3);
                                                $row_nested->appendChild($cell_nested);
                                                $cell_nested = $dom->createElement('td');
                                                $cell_nested->appendChild($dom->createTextNode($palletized->palletsLoaded->value));
                                                $row_nested->appendChild($cell_nested);
                                                $cell_nested = $dom->createElement('td');
                                                $cell_nested->appendChild($dom->createTextNode($palletized->palletsFrom->label));
												$cell_nested->setAttribute('colspan', 2);
                                                $row_nested->appendChild($cell_nested);
                                                $cell_nested = $dom->createElement('td');
                                                $cell_nested->appendChild($dom->createTextNode($palletized->palletsFrom->value));
                                                $row_nested->appendChild($cell_nested);
                                                $cell_nested = $dom->createElement('td');
                                                $cell_nested->appendChild($dom->createTextNode($palletized->palletsTo->label));
                                                $row_nested->appendChild($cell_nested);
                                                $cell_nested = $dom->createElement('td');
                                                $cell_nested->appendChild($dom->createTextNode($palletized->palletsTo->value));
                                                $row_nested->appendChild($cell_nested);
                                                $tbody_nested->appendChild($row_nested);
//                                                $table_nested->appendChild($tbody_nested);
//                                                $cell->appendChild($table_nested);
//                                                $row->appendChild($cell);
//                                                $tbody->appendChild ($row);
//                                                $row = $dom->createElement('tr');
//                                                $cell = $dom->createElement('td');
//                                                $cell->setAttribute('colspan', $td->getAttribute('colspan'));
//                                                $table_nested = $dom->createElement('table');
//                                                $tbody_nested = $dom->createElement('tbody');
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->setAttribute('style', 'text-align: center');
//                                                $cell_nested->setAttribute('colspan', 4);
//                                                $image_node = $dom->createElement("img");
//                                                $image_node->setAttribute('src', 'images/sera.jpg');
//                                                $image_node->setAttribute('width', 675);
//                                                $cell_nested->appendChild($image_node);
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->setAttribute('colspan', 4);
//                                                $cell_nested->setAttribute('style', 'color: #ffffff; background-color: #000000');
//                                                $cell_nested->appendChild($dom->createTextNode('Container Loading Details'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->setAttribute('style', 'color: #ff0000');
//                                                $cell_nested->appendChild($dom->createTextNode('SECTION'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->setAttribute('style', 'color: #ff0000');
//                                                $cell_nested->appendChild($dom->createTextNode('LEVEL 1'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->setAttribute('style', 'color: #ff0000');
//                                                $cell_nested->appendChild($dom->createTextNode('LEVEL 2'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->setAttribute('style', 'color: #ff0000');
//                                                $cell_nested->appendChild($dom->createTextNode('LEVEL 3'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode('A'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsAL1->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsAL2->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsAL3->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode('B'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsBL1->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsBL2->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsBL3->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode('C'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsCL1->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsCL2->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsCL3->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode('D'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsDL1->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsDL2->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsDL3->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode('E'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsEL1->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsEL2->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsEL3->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode('F'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsFL1->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsFL2->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsFL3->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode('G'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsGL1->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsGL2->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsGL3->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);
//
//                                                $row_nested = $dom->createElement('tr');
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode('H'));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsHL1->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsHL2->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $cell_nested = $dom->createElement('td');
//                                                $cell_nested->appendChild($dom->createTextNode($palletized->loadingDetailsHL3->value));
//                                                $row_nested->appendChild($cell_nested);
//                                                $tbody_nested->appendChild($row_nested);


                                                $table_nested->appendChild($tbody_nested);
                                                $cell->appendChild($table_nested);
                                                $row->appendChild($cell);
                                                $tbody->appendChild ($row);
                                            }
                                        }
                                    } else {
                                        if(preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $ansArr[$key . '-combo-box-condition']['value'])){
                                            $filename = basename($ansArr[$key . '-combo-box-condition']['value']);
                                            $section = $ansArr[$key . '-combo-box-condition']['title'];
                                            $row = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $cell->setAttribute('colspan', $combo_colspan);
                                            $image_node = $doc->createElement("img");
                                            $image_node->setAttribute('src', get_src($id, $section, $ansArr[$key . '-combo-box-condition']['value']->label, $filename));
                                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                            if($width > $height){
                                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                            } else {
                                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                            }
                                            $cell->appendChild($image_node);
                                            $row->appendChild($cell);
                                            $table->appendChild($row);
                                        } else {
                                            $text_node = $doc->createTextNode('Remarks: ' . $ansArr[$key . '-combo-box-condition']['value']);
											$div_node->appendChild($doc->createElement('br'));
                                            $div_node->appendChild($text_node);
                                        }
                                    }
                                }
                            }
                        } else {
                            $dom = $node->ownerDocument;
                            if(is_array($ansArr[$key . '-combo-box-condition']['value'])) {
                                $combobox_cond = $ansArr[$key . '-combo-box-condition']['value'];
                                $section = $ansArr[$key . '-combo-box-condition']['title'];
                                foreach ($combobox_cond as $cond){
                                    if(property_exists($cond, 'value') && preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $cond->value)){
                                        if(!array_key_exists($dump_cell . "_image", $dump_node))
                                            $dump_node[$dump_cell . "_image"] = [];
                                        if($cond->type == 'multi-take-picture'){
                                            $filename = basename($cond->value);
                                            $item['label'] = $cond->label;
                                            $item['src'] = 'images/reports/' . $id . '/' . str_replace(' ', '%20', $section) . '/' . str_slug($cond->label, '-') . '-' . $filename;
                                            array_push($dump_node[$dump_cell . "_image"], $item);
                                        } else if($cond->type == 'multi-take-picture-remarks') {
                                            $filename = basename($cond->value);
                                            $item['label'] = $cond->label;
                                            $item['src'] = 'images/reports/' . $id . '/' . str_replace(' ', '%20', $section) . '/' . str_slug($cond->label, '-') . '-' . $filename;
											$item['remark'] = $cond->remark;
                                            array_push($dump_node[$dump_cell . "_image"], $item);
                                        }
                                    } else if(property_exists($cond, 'description')){
                                        if(!array_key_exists($dump_cell . "_image", $dump_node))
                                            $dump_node[$dump_cell . "_image"] = [];
                                        $section = $ansArr[$key . '-combo-box-condition']['title'];
                                        if(count($ansArr[$key . '-combo-box-condition']['value']) > 0) {
                                            foreach($ansArr[$key . '-combo-box-condition']['value'] as $description){
                                                if(count($description->pictures) == 1){
                                                    foreach ($description->pictures as $picture){
                                                        $filename = basename($picture->value);
                                                        $item['label'] = $picture->label;
                                                        $item['src'] = 'images/reports/' . $id . '/' . str_replace(' ', '%20', $section) . '/' . str_slug($picture->label, '-') . '-' . $filename;
                                                        array_push($dump_node[$dump_cell . "_image"], $item);
                                                    }
                                                } else {
                                                    foreach ($description->pictures as $picture){
                                                        $filename = basename($picture->value);
                                                        $item['label'] = $picture->label;
                                                        $item['src'] = 'images/reports/' . $id . '/' . str_replace(' ', '%20', $section) . '/' . str_slug($picture->label, '-') . '-' . $filename;
                                                        array_push($dump_node[$dump_cell . "_image"], $item);
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if(!array_key_exists($dump_cell . "_remarks", $dump_node))
                                            $dump_node[$dump_cell . "_remarks"] = [];
                                        if($cond->type == 'multi-remarks') {
                                            $text_node = $dom->createTextNode($cond->value);
                                            array_push($dump_node[$dump_cell . "_remarks"], $text_node);
                                        } else {
                                            $text_node = $dom->createTextNode('N/A');
                                            array_push($dump_node[$dump_cell . "_remarks"], $text_node);
                                        }
                                    }
                                }
                            } else {
                                if(!array_key_exists($dump_cell . "_remarks", $dump_node))
                                    $dump_node[$dump_cell . "_remarks"] = [];
								$text = is_object($ansArr[$key . '-combo-box-condition']['value'])?$ansArr[$key . '-combo-box-condition']['value']->value:$ansArr[$key . '-combo-box-condition']['value'];
								
								if(in_array($text, ['Başarısız oldu', 'geçti', 'kadar'])){
									switch ($text){
										case 'Başarısız oldu':
											$text = 'Failed';
											break;
										case 'geçti':
											$text = 'Passed';
											break;
										case 'kadar':
											$text = 'Pending';
											break;
									}
								}
									
								$text_node = $dom->createTextNode($text);
								if(strtolower($text_node->data) == 'null')
									$text_node->data = 'N/A';
                                array_push($dump_node[$dump_cell . "_remarks"], $text_node);
                            }
                        }
                    }
                    break;
                case 'remarks':
                    if(is_array($ansArr[$key]['value'])){
                        $remarksArr = $ansArr[$key]['value'];
                        foreach ($remarksArr as $remarks){
                            if($remarks->type == 'product-description'){
                                $section = $ansArr[$key]['title'];
                                $table = $doc->createElement('table');
                                $tbody = $doc->createElement('tbody');
                                $row = $doc->createElement('tr');
                                $cell = $doc->createElement('td');
                                $cell->appendChild($doc->createTextNode($remarks->description));
                                if(count($remarks->pictures) > 1)
                                    $cell->setAttribute('colspan', 2);
                                $row->appendChild($cell);
                                $tbody->appendChild($row);

                                if(count($remarks->pictures) == 1){

                                    foreach ($remarks->pictures as $picture){
                                        $filename = basename($picture->value);

                                        $row_header = $doc->createElement('tr');
                                        $cell = $doc->createElement('td');
                                        $cell->setAttribute('style', 'text-align: center');
                                        $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                        $cell->appendChild($text_node);
                                        $row_header->appendChild($cell);

                                        $row = $doc->createElement('tr');
                                        $cell = $doc->createElement('td');
                                        $cell->setAttribute('style', 'text-align: center');
                                        $image_node = $doc->createElement('img');
                                        $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                        list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                        if($width > $height){
                                            $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                        } else {
                                            $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                        }
                                        $cell->appendChild($image_node);
                                        $row->appendChild($cell);
										//$tbody->appendChild($row_header);
                                        $tbody->appendChild($row);
                                    }

                                } else {
                                    $i = 0;
                                    foreach ($remarks->pictures as $picture){
                                        $filename = basename($picture->value);
                                        if($i % 2 == 0){
                                            $row_header = $doc->createElement('tr');
                                            $row = $doc->createElement('tr');
                                        }
                                        $cell = $doc->createElement('td');
                                        $cell->setAttribute('style', 'text-align: center');
                                        $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                        $cell->appendChild($text_node);
                                        $row_header->appendChild($cell);
                                        $cell = $doc->createElement('td');
                                        $cell->setAttribute('style', 'text-align: center');
                                        $image_node = $doc->createElement('img');
                                        $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                        list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                        if($width > $height){
                                            $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                        } else {
                                            $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                        }
                                        $cell->appendChild($image_node);
                                        $row->appendChild($cell);
                                        if(count($remarks->pictures) === $i + 1 && $i % 2 === 0){
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $text_node = $doc->createTextNode('N/A');
                                            $cell->appendChild($text_node);
                                            $row_header->appendChild($cell);
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $text_node = $doc->createTextNode('N/A');
                                            $cell->appendChild($text_node);
                                            $row->appendChild($cell);
                                        }
                                        if($i % 2 == 0){
                                            //$tbody->appendChild($row_header);
                                            $tbody->appendChild($row);
                                        }
                                        ++$i;
                                    }
                                }
                                $table->appendChild($tbody);
                                $div_node->appendChild($table);
                            } else {
                                $text_node = $doc->createTextNode($remarks->value);
                                $div_node->appendChild($text_node);
                                $line_break = $doc->createElement('br');
                                $div_node->appendChild($line_break);
                            }
                        }
                    } else {
                        $text_node = $doc->createTextNode($ansArr[$key]['value']->value);
                        $div_node->appendChild($text_node);
                    }
                    break;
                case 'picture':
                    $output = 2;
                    if($node->getAttribute('output') == 'stack'){
                        $output = 'stack';
                    } else if ($node->getAttribute('output') == '3-columns') {
                        $output = 3;
                    }
					$has_label = !$node->hasAttribute('no-label');
                    if(is_array($ansArr[$key]['value'])){
                        if(array_key_exists('value', $ansArr[$key])){
                            $picturesArr = $ansArr[$key]['value'];
                            $section = $ansArr[$key]['title'];

                            $table = $doc->createElement('table');
                            $tbody = $doc->createElement('tbody');

                            if($output == 'stack'){
                                foreach ($picturesArr as $picture){
                                    if(property_exists($picture, 'value') && preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $picture->value)){
                                        if($picture->type == 'multi-take-picture'){
                                            $filename = basename($picture->value);
                                            $row_header = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                            $cell->appendChild($text_node);
											$row_header->appendChild($cell);
                                            $row = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $image_node = $doc->createElement('img');
                                            $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                            if($width > $height){
                                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                            } else {
                                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                            }
                                            $cell->appendChild($image_node);
                                            $row->appendChild($cell);
											if($has_label) $tbody->appendChild($row_header);
                                            $tbody->appendChild($row);
                                        } elseif ($picture->type == 'multi-take-picture-remarks') {
                                            $filename = basename($picture->value);
                                            $row_header = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                            $cell->appendChild($text_node);
                                            $row_header->appendChild($cell);
                                            //if($has_label) $tbody->appendChild($row_header);

                                            $row = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $image_node = $doc->createElement('img');
                                            $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                            if($width > $height){
                                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                            } else {
                                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                            }
                                            $cell->appendChild($image_node);
                                            $row->appendChild($cell);
                                            $tbody->appendChild($row);
                                            $row = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $text_node = $doc->createTextNode($picture->remark);
                                            $cell->appendChild($text_node);
                                            $row->appendChild($cell);
                                            $tbody->appendChild($row);
                                        }
                                    } else {
                                        $row = $doc->createElement('tr');
                                        $cell = $doc->createElement('td');
                                        $text_node = $doc->createTextNode('N/A');
                                        $cell->appendChild($text_node);
                                        $row->appendChild($cell);
                                        $tbody->appendChild($row);
                                    }
                                }
								$table->appendChild($tbody);
                                $div_node->appendChild($table);
								$td->setAttribute('v-align', 'top');
                            } else if(count($picturesArr) == 1){
                                foreach ($picturesArr as $picture){
                                    if(property_exists($picture, 'value') && preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $picture->value)){
                                        if($picture->type == 'multi-take-picture'){
                                            $filename = basename($picture->value);
                                            $row_header = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                            $cell->appendChild($text_node);
                                            $row_header->appendChild($cell);

                                            $row = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $image_node = $doc->createElement('img');
                                            $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                            if($width > $height){
                                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                            } else {
                                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                            }
                                            $cell->appendChild($image_node);
                                            $row->appendChild($cell);
                                            if($has_label)  $tbody->appendChild($row_header);
                                            $tbody->appendChild($row);
                                        } else if ($picture->type == 'multi-take-picture-remarks') {
                                            $filename = basename($picture->value);
                                            $row_header = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                            $cell->appendChild($text_node);
                                            $row_header->appendChild($cell);
                                            if($has_label) $tbody->appendChild($row_header);

                                            $row = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $image_node = $doc->createElement('img');
                                            $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                            if($width > $height){
                                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                            } else {
                                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                            }
                                            $cell->appendChild($image_node);
                                            $row->appendChild($cell);
                                            $tbody->appendChild($row);
                                            $row = $doc->createElement('tr');
                                            $cell = $doc->createElement('td');
                                            $text_node = $doc->createTextNode($picture->remark);
                                            $cell->appendChild($text_node);
                                            $row->appendChild($cell);
                                            $tbody->appendChild($row);
                                        }
                                    } else if(property_exists($picture, 'description')) {
                                        $section = $ansArr[$key]['title'];
                                        if(count($ansArr[$key]['value']) > 0) {
                                            foreach($ansArr[$key]['value'] as $description){
                                                $table = $doc->createElement('table');
                                                $tbody = $doc->createElement('tbody');
                                                $row = $doc->createElement('tr');
                                                $cell = $doc->createElement('td');
                                                $cell->appendChild($doc->createTextNode($description->description));
                                                if(count($description->pictures) > 1){
                                                    $cell->setAttribute('colspan', $output);
                                                }
                                                $row->appendChild($cell);
                                                $tbody->appendChild($row);

                                                if(count($description->pictures) == 1){
													
                                                    foreach ($description->pictures as $picture){
                                                        $filename = basename($picture->value);

                                                        $row_header = $doc->createElement('tr');
                                                        $cell = $doc->createElement('td');
                                                        $cell->setAttribute('style', 'text-align: center');
                                                        $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                                        $cell->appendChild($text_node);
                                                        $row_header->appendChild($cell);

                                                        $row = $doc->createElement('tr');
                                                        $cell = $doc->createElement('td');
                                                        $cell->setAttribute('style', 'text-align: center');
                                                        $image_node = $doc->createElement('img');
                                                        $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                                        list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                        if($width > $height){
                                                            $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                        } else {
                                                            $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                        }
                                                        $cell->appendChild($image_node);
                                                        $row->appendChild($cell);
                                                        $tbody->appendChild($row);
                                                    }

                                                } else {
                                                    $i = 0;
                                                    foreach ($description->pictures as $picture){
                                                        $filename = basename($picture->value);
                                                        if($i % $output == 0){
                                                            $row_header = $doc->createElement('tr');
                                                            $row = $doc->createElement('tr');
                                                        }
                                                        $cell = $doc->createElement('td');
                                                        $cell->setAttribute('style', 'text-align: center');
                                                        $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                                        $cell->appendChild($text_node);
                                                        $row_header->appendChild($cell);
                                                        $cell = $doc->createElement('td');
                                                        $cell->setAttribute('style', 'text-align: center');
                                                        $image_node = $doc->createElement('img');
                                                        $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                                        list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                                        if($width > $height){
                                                            $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                                        } else {
                                                            $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                                        }
                                                        $cell->appendChild($image_node);
                                                        $row->appendChild($cell);
                                                        if(count($description->pictures) === $i + 1 && $i % $output === 0){
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $text_node = $doc->createTextNode('N/A');
                                                            $cell->appendChild($text_node);
                                                            $row_header->appendChild($cell);
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $text_node = $doc->createTextNode('N/A');
                                                            $cell->appendChild($text_node);
                                                            $row->appendChild($cell);
                                                        }
                                                        if(count($description->pictures) === $i + 1 && $i % $output === 0 && $output === 3){
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $text_node = $doc->createTextNode('N/A');
                                                            $cell->appendChild($text_node);
                                                            $row_header->appendChild($cell);
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $text_node = $doc->createTextNode('N/A');
                                                            $cell->appendChild($text_node);
                                                            $row->appendChild($cell);
                                                        }
                                                        if(count($description->pictures) === $i + 1 && $i % $output === 1 && $output === 3){
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $text_node = $doc->createTextNode('N/A');
                                                            $cell->appendChild($text_node);
                                                            $row_header->appendChild($cell);
                                                            $cell = $doc->createElement('td');
                                                            $cell->setAttribute('style', 'text-align: center');
                                                            $text_node = $doc->createTextNode('N/A');
                                                            $cell->appendChild($text_node);
                                                            $row->appendChild($cell);
                                                        }
                                                        if($i % $output == 0){
                                                            //if($has_label)  $tbody->appendChild($row_header);
                                                            $tbody->appendChild($row);
                                                        }
                                                        ++$i;
                                                    }
                                                }
                                                $table->appendChild($tbody);
                                                $div_node->appendChild($table);
                                                $div_node->appendChild($doc->createElement('br'));
                                            }
                                        }
                                    } else {
                                        //$row_header = $doc->createElement('tr');
                                        //$cell = $doc->createElement('td');
                                        //$cell->setAttribute('style', 'text-align: center');
                                        //$text_node = $doc->createTextNode('N/A');
                                        //$cell->appendChild($text_node);
                                        //$row_header->appendChild($cell);

                                        $row = $doc->createElement('tr');
                                        $cell = $doc->createElement('td');
                                        $cell->setAttribute('style', 'text-align: center');
                                        $text_node = $doc->createTextNode('N/A');
                                        $cell->appendChild($text_node);
                                        $row->appendChild($cell);
                                        //$tbody->appendChild($row_header);
                                        $tbody->appendChild($row);
                                    }
                                }
                            } else {
                                $i = 0;
                                foreach ($picturesArr as $picture){
									if(property_exists($picture, 'description')){
                                        $section = $ansArr[$key]['title'];
										$table = $doc->createElement('table');
										$tbody = $doc->createElement('tbody');
										$row = $doc->createElement('tr');
										$cell = $doc->createElement('td');
										$cell->appendChild($doc->createTextNode($picture->description));
										if(count($picture->pictures) > 1)
											$cell->setAttribute('colspan', $output);
										$row->appendChild($cell);
										$tbody->appendChild($row);

										if(count($picture->pictures) == 1){

											foreach ($picture->pictures as $picture){
												$filename = basename($picture->value);

												//if($picture->label != ''){
													//$row_header = $doc->createElement('tr');
													//$cell = $doc->createElement('td');
													//$cell->setAttribute('style', 'text-align: center');
													//$text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
													//$cell->appendChild($text_node);
													//$row_header->appendChild($cell);
												//}
												
												$row = $doc->createElement('tr');
												$cell = $doc->createElement('td');
												$cell->setAttribute('style', 'text-align: center');
												$image_node = $doc->createElement('img');
												$image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
												list($width, $height) = getjpegsize($image_node->getAttribute('src'));
												if($width > $height){
													$image_node->setAttribute('width', $image_width == 0?200:$image_width);
												} else {
													$image_node->setAttribute('height', $image_height == 0?200:$image_height);
												}
												$cell->appendChild($image_node);
												$row->appendChild($cell);
												//if($picture->label != '')
													//if($has_label) $tbody->appendChild($row_header);
												$tbody->appendChild($row);
											}

										} else {
											$i = 0;
											foreach ($picture->pictures as $pictur){
												$filename = basename($pictur->value);
												if($i % $output == 0){
													$row_header = $doc->createElement('tr');
													$row = $doc->createElement('tr');
												}
												$cell = $doc->createElement('td');
												$cell->setAttribute('style', 'text-align: center');
												$text_node = $doc->createTextNode($pictur->label);
												$cell->appendChild($text_node);
												$row_header->appendChild($cell);
												$cell = $doc->createElement('td');
												$cell->setAttribute('style', 'text-align: center');
												$image_node = $doc->createElement('img');
												$image_node->setAttribute('src', get_src($id, $section, $pictur->label, $filename));
												list($width, $height) = getjpegsize($image_node->getAttribute('src'));
												if($width > $height){
													$image_node->setAttribute('width', $image_width == 0?200:$image_width);
												} else {
													$image_node->setAttribute('height', $image_height == 0?200:$image_height);
												}
												$cell->appendChild($image_node);
												$row->appendChild($cell);
												if(count($picture->pictures) === $i + 1 && $i % $output === 0){
													$cell = $doc->createElement('td');
													$cell->setAttribute('style', 'text-align: center');
													$text_node = $doc->createTextNode('N/A');
													$cell->appendChild($text_node);
													$row_header->appendChild($cell);
													$cell = $doc->createElement('td');
													$cell->setAttribute('style', 'text-align: center');
													$text_node = $doc->createTextNode('N/A');
													$cell->appendChild($text_node);
													$row->appendChild($cell);
												}
												if(count($picture->pictures) === $i + 1 && $i % $output === 0 && $output === 3){
													$cell = $doc->createElement('td');
													$cell->setAttribute('style', 'text-align: center');
													$text_node = $doc->createTextNode('N/A');
													$cell->appendChild($text_node);
													$row_header->appendChild($cell);
													$cell = $doc->createElement('td');
													$cell->setAttribute('style', 'text-align: center');
													$text_node = $doc->createTextNode('N/A');
													$cell->appendChild($text_node);
													$row->appendChild($cell);
												}
												if(count($picture->pictures) === $i + 1 && $i % $output === 1 && $output === 3){
													$cell = $doc->createElement('td');
													$cell->setAttribute('style', 'text-align: center');
													$text_node = $doc->createTextNode('N/A');
													$cell->appendChild($text_node);
													$row_header->appendChild($cell);
													$cell = $doc->createElement('td');
													$cell->setAttribute('style', 'text-align: center');
													$text_node = $doc->createTextNode('N/A');
													$cell->appendChild($text_node);
													$row->appendChild($cell);
												}
												if($i % $output == 0){
													//if($pictur->label != '')
														//if($has_label) $tbody->appendChild($row_header);
													$tbody->appendChild($row);
												}
												++$i;
											}
										}
										$table->appendChild($tbody);
										$div_node->appendChild($table);
										$div_node->appendChild($doc->createElement('br'));
                                    } else if(preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $picture->value)){
                                        if($picture->type == 'multi-take-picture'){
                                            $filename = basename($picture->value);
                                            if($i % $output == 0){
                                                $row_header = $doc->createElement('tr');
                                                $row = $doc->createElement('tr');
                                            }
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                            $cell->appendChild($text_node);
                                            $row_header->appendChild($cell);
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $image_node = $doc->createElement('img');
                                            $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                            if($width > $height){
                                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                            } else {
                                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                            }
                                            $cell->appendChild($image_node);
                                            $row->appendChild($cell);
                                            if(count($picturesArr) === $i + 1 && $i % $output === 0){
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row_header->appendChild($cell);
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                            }
                                            if(count($picturesArr) === $i + 1 && $i % $output === 0 && $output === 3){
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row_header->appendChild($cell);
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                            }
                                            if(count($picturesArr) === $i + 1 && $i % $output === 1 && $output === 3){
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row_header->appendChild($cell);
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                            }
                                            if($i % $output == 0){
                                                if($has_label) $tbody->appendChild($row_header);
                                                $tbody->appendChild($row);
                                            }
                                            ++$i;
                                        } else if ($picture->type == 'multi-take-picture-remarks') {
                                            $filename = basename($picture->value);
                                            if($i % $output == 0){
                                                $row_header = $doc->createElement('tr');
                                                $row = $doc->createElement('tr');
                                                $row_remark = $doc->createElement('tr');
                                            }
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $text_node = $translate?$doc->createTextNode(translate_text($translate, $key)):$doc->createTextNode($picture->label);
                                            $cell->appendChild($text_node);
                                            $row_header->appendChild($cell);
                                            $cell = $doc->createElement('td');
                                            $cell->setAttribute('style', 'text-align: center');
                                            $image_node = $doc->createElement('img');
                                            $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                            if($width > $height){
                                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                            } else {
                                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                            }
                                            $cell->appendChild($image_node);
                                            $row->appendChild($cell);
                                            $cell = $doc->createElement('td');
                                            $text_node = $doc->createTextNode($picture->remark);
                                            $cell->appendChild($text_node);
                                            $row_remark->appendChild($cell);
                                            if(count($picturesArr) === $i + 1 && $i % $output === 0){
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row_header->appendChild($cell);
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row_remark->appendChild($cell);
                                            }
                                            if(count($picturesArr) === $i + 1 && $i % $output === 0 && $output === 3){
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row_header->appendChild($cell);
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row_remark->appendChild($cell);
                                            }
                                            if(count($picturesArr) === $i + 1 && $i % $output === 1 && $output === 3){
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row_header->appendChild($cell);
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row->appendChild($cell);
                                                $cell = $doc->createElement('td');
                                                $cell->setAttribute('style', 'text-align: center');
                                                $text_node = $doc->createTextNode('N/A');
                                                $cell->appendChild($text_node);
                                                $row_remark->appendChild($cell);
                                            }
                                            if($i % $output == 0){
                                                if($has_label) $tbody->appendChild($row_header);
                                                $tbody->appendChild($row);
                                                $tbody->appendChild($row_remark);
                                            }
                                            ++$i;
                                        }
                                    } else {
                                        //$row_header = $doc->createElement('tr');
                                        //$cell = $doc->createElement('td');
                                        //$cell->setAttribute('style', 'text-align: center');
                                        //$text_node = $doc->createTextNode('N/A');
                                        //$cell->appendChild($text_node);
                                        //$row_header->appendChild($cell);

                                        $row = $doc->createElement('tr');
                                        $cell = $doc->createElement('td');
                                        $cell->setAttribute('style', 'text-align: center');
                                        $text_node = $doc->createTextNode('N/A');
                                        $cell->appendChild($text_node);
                                        $row->appendChild($cell);
                                        //$tbody->appendChild($row_header);
                                        $tbody->appendChild($row);
                                    }
                                }
                            }
                            $table->appendChild($tbody);
                            $div_node->appendChild($table);
                            $div_node->appendChild($doc->createElement('br'));
                        }
                    } else {
                        
                        if(preg_match('/^http:\\/\\/localhost:8080.+\.[jJ][pP][gG]|[jJ][pP][eE][gG]$/', $ansArr[$key]['value']->value)){
                            $filename = basename($ansArr[$key]['value']->value);
                            $section = html_entity_decode($ansArr[$key]['title']);
                            $image_node = $doc->createElement("img");
                            $image_node->setAttribute('src', get_src($id, $section, $ansArr[$key]['value']->label, $filename));
                            list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                            if($width > $height){
                                $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                            } else {
                                $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                            }
                            $div_node->appendChild($image_node);
                        } else {
                            $text_node = $doc->createTextNode('N/A');
                            $div_node->appendChild($text_node);
                        }
                    }
                    break;
                case 'product-input':
                    $labels = array_map('trim', explode(',',$node->getAttribute('auto-sum-label')));
                    $column_labels = array_map('trim', explode(',',$node->getAttribute('auto-sum-column-label')));
                    $sum = [];
                    foreach ($labels as $k => $label){
                        $item['label'] = $label;
                        $item['column'] = $column_labels[$k];
                        $item['sum'] = 0;
                        array_push($sum,$item);
                    }
                    if(count($ansArr[$key]['value']) > 0){
                        $table = $doc->createElement('table');
						$table->setAttribute('style', 'border:1px solid #000000');
                        $tbody = $doc->createElement('tbody');
						$row_total_quantity = $doc->createElement('tr');
						$tbody->appendChild($row_total_quantity);

                        $row_header = $doc->createElement('tr');
                        foreach($ansArr[$key]['value'][0]->options as $option){
                            $cell_header = $doc->createElement('td');
                            $text_header = $doc->createTextNode($option->label);
                            $cell_header->setAttribute('style', 'background-color:#000000; color:#ffffff');
                            $cell_header->appendChild($text_header);
                            $row_header->appendChild($cell_header);
                        }
                        $tbody->appendChild($row_header);
                        foreach ($ansArr[$key]['value'] as $options){
                            $row = $doc->createElement('tr');
                            foreach($options->options as $option){
                                if(in_array($option->label, $column_labels)){
                                    $i = array_search($option->label, $column_labels);
                                    $sum[$i]['sum'] += $option->value;
                                }
                                $cell = $doc->createElement('td');
                                $text = $doc->createTextNode($option->value);
                                $cell->appendChild($text);
                                $row->appendChild($cell);
                                $tbody->appendChild($row);
                            }
                        }
                    }
					$cell_total_quantity = $doc->createElement('td');
                    $cell_total_quantity->setAttribute('colspan', count($ansArr[$key]['value'][0]->options));
                    $text_total_quantity = 'Total Quantity Loaded: ';
                    if(count($ansArr[$key]['value'][0]->options)  % 2 == 1){
                        $colspan1 = ceil(count($ansArr[$key]['value'][0]->options) / 2);
                        $colspan2 = count($ansArr[$key]['value'][0]->options) - $colspan1;
                    } else {
                        $colspan1 = ceil(count($ansArr[$key]['value'][0]->options) / 2);
                        $colspan2 = ceil(count($ansArr[$key]['value'][0]->options) / 2);
                    }

                    foreach($sum as $su){
                        $row = $doc->createElement('tr');
                        $cell = $doc->createElement('td');
                        $text_node = $doc->createTextNode($su['label']);
                        $cell->appendChild($text_node);
                        $cell->setAttribute('colspan', $colspan1);
                        $cell->setAttribute('style', 'background-color:#000000; color:#ffffff');
                        $row->appendChild($cell);
                        $cell = $doc->createElement('td');
                        $text_node = $doc->createTextNode($su['sum']);
                        $cell->appendChild($text_node);
                        $cell->setAttribute('colspan', $colspan2);
                        $cell->setAttribute('style', 'background-color:#000000; color:#ffffff');
                        $row->appendChild($cell);
                        $tbody->appendChild($row);
						$quantity_label = explode(' ', $su['label']);
                        $text_total_quantity .= $su['sum'] . ' ' . end($quantity_label) . ' / ';
                    }
					$text_total_quantity = substr($text_total_quantity,0,-3);
                    $cell_total_quantity->appendChild($doc->createTextNode($text_total_quantity));
					$cell_total_quantity->setAttribute('style', 'font-weight:bold; color: #ff0000');
					$row_total_quantity->appendChild($cell_total_quantity);
                    $table->appendChild($tbody);
                    $div_node->appendChild($table);
                    break;
                case 'product-description':
                    $tbody  = $td->parentNode->parentNode;
                    $dom = $td->ownerDocument;
                    $section = $ansArr[$key]['title'];
                    if(count($ansArr[$key]['value']) > 0) {
                        foreach($ansArr[$key]['value'] as $description){
                            $row = $dom->createElement('tr');
                            $cell = $dom->createElement('td');
                            $cell->appendChild($dom->createTextNode($description->description));
                            if(count($description->pictures) > 1)
                                $cell->setAttribute('colspan', 2);
                            $row->appendChild($cell);
                            $tbody->insertBefore ($row, $td->parentNode);

                            if(count($description->pictures) == 1){

                                foreach ($description->pictures as $picture){
                                    $filename = basename($picture->value);

                                    $row_header = $dom->createElement('tr');
                                    $cell = $dom->createElement('td');
                                    $cell->setAttribute('style', 'text-align: center');
                                    $text_node = $translate?$dom->createTextNode(translate_text($translate, $key)):$dom->createTextNode($picture->label);
                                    $cell->appendChild($text_node);
                                    $row_header->appendChild($cell);

                                    $row = $dom->createElement('tr');
                                    $cell = $dom->createElement('td');
                                    $cell->setAttribute('style', 'text-align: center');
                                    $image_node = $dom->createElement('img');
                                    $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                    list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                    if($width > $height){
                                        $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                    } else {
                                        $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                    }
                                    $cell->appendChild($image_node);
                                    $row->appendChild($cell);
                                    //$tbody->insertBefore ($row_header, $td->parentNode);
                                    $tbody->insertBefore ($row, $td->parentNode);
                                }

                            } else {
                                $i = 0;
                                foreach ($description->pictures as $picture){
                                    $filename = basename($picture->value);
                                    if($i % 2 == 0){
                                        $row_header = $dom->createElement('tr');
                                        $row = $dom->createElement('tr');
                                    }
                                    $cell = $dom->createElement('td');
                                    $cell->setAttribute('style', 'text-align: center');
                                    $text_node = $translate?$dom->createTextNode(translate_text($translate, $key)):$dom->createTextNode($picture->label);
                                    $cell->appendChild($text_node);
                                    $row_header->appendChild($cell);
                                    $cell = $dom->createElement('td');
                                    $cell->setAttribute('style', 'text-align: center');
                                    $image_node = $dom->createElement('img');
                                    $image_node->setAttribute('src', get_src($id, $section, $picture->label, $filename));
                                    list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                                    if($width > $height){
                                        $image_node->setAttribute('width', $image_width == 0?200:$image_width);
                                    } else {
                                        $image_node->setAttribute('height', $image_height == 0?200:$image_height);
                                    }
                                    $cell->appendChild($image_node);
                                    $row->appendChild($cell);
                                    if(count($description->pictures) === $i + 1 && $i % 2 === 0){
                                        $cell = $dom->createElement('td');
                                        $cell->setAttribute('style', 'text-align: center');
                                        $text_node = $dom->createTextNode('N/A');
                                        $cell->appendChild($text_node);
                                        $row_header->appendChild($cell);
                                        $cell = $dom->createElement('td');
                                        $cell->setAttribute('style', 'text-align: center');
                                        $text_node = $dom->createTextNode('N/A');
                                        $cell->appendChild($text_node);
                                        $row->appendChild($cell);
                                    }
                                    if($i % 2 == 0){
                                        //$tbody->insertBefore ($row_header, $td->parentNode);
                                        $tbody->insertBefore ($row, $td->parentNode);
                                    }
                                    ++$i;
                                }
                            }
                        }
                    }
                    break;
                case 'total-number':
                    $td->removeAttribute('colspan');
                    $dom = $td->ownerDocument;
                    $tbody = $td->parentNode->parentNode;
                    $row = $dom->createElement('tr');
                    $cell = $dom->createElement('td');
                    $text_node = $dom->createTextNode($ansArr[$key]['value']->package_opened->label);
                    $cell->appendChild($text_node);
                    $row->appendChild($cell);
                    $tbody->insertBefore ($row, $td->parentNode);
                    $cell = $dom->createElement('td');
					$cell->setAttribute('style', 'color: #ff0000');
                    $text_node = $dom->createTextNode($ansArr[$key]['value']->package_opened->value);
                    $cell->appendChild($text_node);
                    $row->appendChild($cell);
                    $tbody->insertBefore ($row, $td->parentNode);
                    $row = $dom->createElement('tr');
                    $cell = $dom->createElement('td');
                    $text_node = $dom->createTextNode($ansArr[$key]['value']->package_inspected->label);
                    $cell->appendChild($text_node);
                    $row->appendChild($cell);
                    $tbody->insertBefore ($row, $td->parentNode);
                    $cell = $dom->createElement('td');
					$cell->setAttribute('style', 'color: #ff0000');
                    $text_node = $dom->createTextNode($ansArr[$key]['value']->package_inspected->value);
                    $cell->appendChild($text_node);
                    $row->appendChild($cell);
                    $tbody->insertBefore ($row, $td->parentNode);
                    $row = $dom->createElement('tr');
                    $cell = $dom->createElement('td');
                    $text_node = $dom->createTextNode($ansArr[$key]['value']->stickers_used->label);
                    $cell->appendChild($text_node);
                    $row->appendChild($cell);
                    $tbody->insertBefore ($row, $td->parentNode);
                    $cell = $dom->createElement('td');
					$cell->setAttribute('style', 'color: #ff0000');
                    $text_node = $dom->createTextNode($ansArr[$key]['value']->stickers_used->value);
                    $cell->appendChild($text_node);
                    $row->appendChild($cell);
                    $tbody->insertBefore ($row, $td->parentNode);

                    break;
            }
            $doc->appendChild($div_node);

            $new_node = $td->ownerDocument->importNode($doc->documentElement, true);
            if($type != 'custom-table')
                $td->replaceChild($new_node, $node);
            if($type == 'total-number' || $type == 'product-description'){
                $td->parentNode->parentNode->removeChild($td->parentNode);
            }
        });

        foreach ($dump_node as $k => $nodes){
            list($id, $type) = explode('_', $k);
            if($type == 'remarks')
                foreach ($nodes as $node){
                    $td = $html->filterXPath("//*[@id='$id']")->getNode(0);
                    $td->appendChild($node);
                }
            else {
                $td = $html->filterXPath("//*[@id='$id']")->getNode(0);
                $dom = $td->ownerDocument;
                $table = $dom->createElement('table');
                $tbody = $dom->createElement('tbody');
                foreach ($nodes as $i => $node){
					$remark = array_key_exists('remark', $node);
                    if($i % 2 === 0){
                        $row_header = $dom->createElement('tr');
                        $row = $dom->createElement('tr');
						if($remark) $row_remark = $dom->createElement('tr');
                    }
                    $cell_header = $dom->createElement('td');
                    $cell_header->setAttribute('style', 'text-align: center');
                    $text_header = $dom->createTextNode($node['label']);
                    $cell_header->appendChild($text_header);
                    $row_header->appendChild($cell_header);

                    $cell = $dom->createElement('td');
                    $cell->setAttribute('style', 'text-align: center');
                    $image_node = $dom->createElement("img");
                    $image_node->setAttribute('src', 'https://tic-service.company/' . $node['src']);
                    list($width, $height) = getjpegsize($image_node->getAttribute('src'));
                    if($width > $height){
                        $image_node->setAttribute('width', 350);
                    } else {
                        $image_node->setAttribute('height', 350);
                    }
                    $cell->appendChild($image_node);
                    $row->appendChild($cell);
					if($remark) $cell_remark = $dom->createElement('td');
					if($remark) $text_remark = $dom->createTextNode('Remark: ' . $node['remark']);
                    if($remark) $cell_remark->appendChild($text_remark);
					if($remark) $row_remark->appendChild($cell_remark);
                    if($i % 2 === 0) {
                        $tbody->appendChild($row_header);
                        $tbody->appendChild($row);
						if($remark) $tbody->appendChild($row_remark);
                    }
                }
                $table->appendChild($tbody);
                $td->appendChild($table);
            }
        }

        $html->filterXPath('//table[@tic-input="custom-table"]')->each(function($table){
            if($table->attr('output') === 'stack'){
                $table->getNode(0)->parentNode->removeChild($table->getNode(0));
            } else {
                $table->filterXPath('//tbody/tr[position()=2]')->each(function($child){
                    $child->getNode(0)->parentNode->removeChild($child->getNode(0));
                });
            }
        });

        $header_ = $html->filter('.header')->each(function ($node){
			if($node->getNode(0)->hasAttribute('render-as-img')) {
				if($node->filterXpath('//img')->count() === 1) {
					return outerHTML($node->filterXpath('//img')->getNode(0));
				}
			}
            if($node->filterXpath('//tbody/tr[position()=2]')->count() > 0){
                $colCount = $node->filterXpath('//tbody/tr[position()=2]')->children()->each(function($child){
                    if($child->getNode(0)->getAttribute('colspan'))
                        return $child->getNode(0)->getAttribute('colspan') - 0;
                    else
                        return 1;
                });
                $colCount = array_sum($colCount);

                $col = $colCount;

                $row = $node->filterXpath('//tbody/tr[position() > 1]')->count() + 1;

                $map = [];

                for($y = 1; $y <= $row; $y++){

                    for($x = 1; $x <= $col; $x++){
                        $tdnode = $node->filterXpath("//tbody/tr[position() = $y]/td[position() = $x]")->getNode(0);
                        if($tdnode){
                            if($tdnode->getAttribute('rowspan')){
                                $map[$y][$x] = $tdnode->getAttribute('rowspan')-1;
                                $tdnode->setAttribute('rowspan', 'restart');
                            } else {
                                if($y > 1 && $map[$y-1][$x] > 0){
                                    $map[$y][$x] = $map[$y-1][$x] - 1;
                                    $tdclone = cloneNode($tdnode,$tdnode->ownerDocument);
                                    $tdnode->parentNode->insertBefore($tdclone, $tdnode);
                                } else {
                                    $map[$y][$x] = 'normal';
                                }
                            }
                        } else {
                            if($y > 1 && $map[$y-1][$x] > 0){
                                $map[$y][$x] = $map[$y-1][$x] - 1;
                                $doc = $node->getNode(0)->ownerDocument;
                                $td = $doc->createElement('td');
                                $td->setAttribute('rowspan','continue');
                                $node->filterXpath("//tbody/tr[position() = $y]")->getNode(0)->appendChild($td);
                            } else {
                                $map[$y][$x] = 'not existing';
                            }
                        }
                    }
                }
            }

            return outerHTML($node->getNode(0));
        });
		
		$header_[0] .= '<br>';
		
        $footer_ = $html->filter('.footer')->each(function ($node){
            if($node->filterXpath('//tbody/tr[position()=2]')->count() > 0){
                $colCount = $node->filterXpath('//tbody/tr[position()=2]')->children()->each(function($child){
                    if($child->getNode(0)->getAttribute('colspan'))
                        return $child->getNode(0)->getAttribute('colspan') - 0;
                    else
                        return 1;
                });
                $colCount = array_sum($colCount);

                $col = $colCount;

                $row = $node->filterXpath('//tbody/tr[position() > 1]')->count() + 1;

                $map = [];

                for($y = 1; $y <= $row; $y++){

                    for($x = 1; $x <= $col; $x++){
                        $tdnode = $node->filterXpath("//tbody/tr[position() = $y]/td[position() = $x]")->getNode(0);
                        if($tdnode){
                            if($tdnode->getAttribute('rowspan')){
                                $map[$y][$x] = $tdnode->getAttribute('rowspan')-1;
                                $tdnode->setAttribute('rowspan', 'restart');
                            } else {
                                if($y > 1 && $map[$y-1][$x] > 0){
                                    $map[$y][$x] = $map[$y-1][$x] - 1;
                                    $tdclone = cloneNode($tdnode,$tdnode->ownerDocument);
                                    $tdnode->parentNode->insertBefore($tdclone, $tdnode);
                                } else {
                                    $map[$y][$x] = 'normal';
                                }
                            }
                        } else {
                            if($y > 1 && $map[$y-1][$x] > 0){
                                $map[$y][$x] = $map[$y-1][$x] - 1;
                                $doc = $node->getNode(0)->ownerDocument;
                                $td = $doc->createElement('td');
                                $td->setAttribute('rowspan','continue');
                                $node->filterXpath("//tbody/tr[position() = $y]")->getNode(0)->appendChild($td);
                            } else {
                                $map[$y][$x] = 'not existing';
                            }
                        }
                    }
                }
            }

            return outerHTML($node->getNode(0));
        });
        $html->filterXpath('//table[@section]/tbody/tr/td/table')->each(function ($node){
            $colCount = $node->filterXpath('//tbody/tr[position()=1]')->children()->each(function($child){
                if($child->getNode(0)->getAttribute('colspan'))
                    return $child->getNode(0)->getAttribute('colspan') - 0;
                else
                    return 1;
            });
            $colCount = array_sum($colCount);

            $col = $colCount;

            $row = $node->filterXpath('//tbody/tr[position() > 1]')->count() + 1;

            $map = [];

            for($y = 1; $y <= $row; $y++){

                for($x = 1; $x <= $col; $x++){
                    $tdnode = $node->filterXpath("//tbody/tr[position() = $y]/td[position() = $x]")->getNode(0);
                    if($tdnode){
                        if($tdnode->getAttribute('rowspan')){
                            $map[$y][$x] = $tdnode->getAttribute('rowspan')-1;
                            $tdnode->setAttribute('rowspan', 'restart');
                        } else {
                            if($y > 1 && $map[$y-1][$x] > 0){
                                $map[$y][$x] = $map[$y-1][$x] - 1;
                                $tdclone = cloneNode($tdnode,$tdnode->ownerDocument);
                                $tdnode->parentNode->insertBefore($tdclone, $tdnode);
                            } else {
                                $map[$y][$x] = 'normal';
                            }
                        }
                    } else {
                        if($y > 1 && $map[$y-1][$x] > 0){
                            $map[$y][$x] = $map[$y-1][$x] - 1;
                            $doc = $node->getNode(0)->ownerDocument;
                            $td = $doc->createElement('td');
                            $td->setAttribute('rowspan','continue');
                            $node->filterXpath("//tbody/tr[position() = $y]")->getNode(0)->appendChild($td);
                        } else {
                            $map[$y][$x] = 'not existing';
                        }
                    }
                }
            }
        });
        $section_ = $html->filter('table[section=yes]')->each(function ($node){
            $colCount = $node->filterXpath('//tbody/tr[position()=2]')->children()->each(function($child){
                if($child->getNode(0)->getAttribute('colspan'))
                    return $child->getNode(0)->getAttribute('colspan') - 0;
                else
                    return 1;
            });
            $colCount = array_sum($colCount);
            $sectionHeader = $node->filterXpath('//tbody/tr/th')->getNode(0);
            $sectionHeader->removeAttribute('colspan');
            $sectionHeader->setAttribute('colspan', $colCount);
            $border = 'none';
            if($node->getNode(0)->hasAttribute('style')){
                $properties = explode(';', trim($node->getNode(0)->getAttribute('style'), " \t\n\r\0\x0B;"));
                foreach ($properties as $property){
                    list($cKey, $cValue) = array_pad(explode(':', $property, 2), 2, null);
                    if(trim($cKey) == 'border'){
                        $border = trim($cValue);
						$node->getNode(0)->removeAttribute('style');
						$node->getNode(0)->setAttribute('style', 'border:' . $border);
                    }
                }
            }
            $col = $colCount;

            $row = $node->filterXpath('//tbody/tr[position() > 1]')->count() + 1;

            $map = [];
			$colspan = [];

            for($y = 2; $y <= $row; $y++){

                for($x = 1; $x <= $col; $x++){
                    $tdnode = $node->filterXpath("//tbody/tr[position() = $y]/td[position() = $x]")->getNode(0);
                    $colspan[$y][$x] = '0';
                    if($tdnode){
                        if($tdnode->getAttribute('rowspan')){
                            $map[$y][$x] = $tdnode->getAttribute('rowspan')-1;
                            $tdnode->setAttribute('rowspan', 'restart');
                            if($tdnode->getAttribute('colspan'))
                                $colspan[$y][$x] = $tdnode->getAttribute('colspan');
                        } else {
                            if($y > 2 && $map[$y-1][$x] > 0){
                                $map[$y][$x] = $map[$y-1][$x] - 1;
                                $tdclone = cloneNode($tdnode,$tdnode->ownerDocument);
                                if($colspan[$y-1][$x] != '0'){
                                    $colspan[$y][$x] = $colspan[$y-1][$x];
                                    $tdclone->setAttribute('colspan', $colspan[$y][$x]);
                                }
                                $tdnode->parentNode->insertBefore($tdclone, $tdnode);
                            } else {
                                $map[$y][$x] = 'normal';
                            }
                        }
                    } else {
                        if($y > 2 && $map[$y-1][$x] > 0){
                            $map[$y][$x] = $map[$y-1][$x] - 1;
                            $doc = $node->getNode(0)->ownerDocument;
                            $td = $doc->createElement('td');
                            $td->setAttribute('rowspan','continue');
                            if($colspan[$y-1][$x] != '0'){
                                $colspan[$y][$x] = $colspan[$y-1][$x];
                                $td->setAttribute('colspan', $colspan[$y][$x]);
                            }
                            $node->filterXpath("//tbody/tr[position() = $y]")->getNode(0)->appendChild($td);
                        } else {
                            $map[$y][$x] = 'not existing';
                        }
                    }
                }
            }

            return outerHTML($node->getNode(0));
        });

        $phpWord  = new PHPWord();

        $sectionStyle=[
            'marginLeft'=>Converter::inchToTwip(.5),
            'marginRight'=>Converter::inchToTwip(.5),
            'marginTop'=>Converter::inchToTwip(.75),
            'marginBottom'=>Converter::inchToTwip(.75),
            'headerHeight'=> Converter::inchToTwip(.25),
            'footerHeight'=> Converter::inchToTwip(.25),
            'pageSizeH'=> Converter::inchToTwip(11.69),
            'pageSizeW'=> Converter::inchToTwip(8.27),
        ];
        $phpWord->setDefaultParagraphStyle([
            'spaceAfter' => 0
        ]);
        $phpWord->setDefaultFontSize(12);
        $section = $phpWord->addSection($sectionStyle);
        $header = $section->addHeader();
        Html::addHtml($header, $header_[0]);

		if($footer_){
			$footer = $section->addFooter();
			Html::addHtml($footer, $footer_[0]);
		}

        $total = (count($section_));
        $current = 0;
        header('X-Accel-Buffering: no');
        foreach ($section_ as $sec) {
            $current++;
            Html::addHtml($section, $sec);
			//$section->addTextBreak();
			$section->addPageBreak();
            outputProgress($current, $total);
        }

        $filename = strtoupper($inspection->reference_number).'.doc';

        $objWriter = IOFactory::createWriter( $phpWord, "Word2007" );

        try {
            $objWriter->save('documents/' . $filename);

        } catch (Exception $e) {

        }

        //echo url('/'.$filename);
        //return url('/'.$filename);

    }
	
	public function testResizeImage($report)
	{
		if(!empty($report)){
			$base_path = 'images/reports/' . strtoupper($report);
			if(is_dir($base_path)){
				$images = list_all_files_full_path($base_path);
				return resize_images($images);
			}
		}
	}

    public function loadingReportLoader($id){
       return view('pages.download.report', compact('id'));
    }


    public function loadingReport($id){
        $inpect_info = Inspection::where('reference_number',$id)->first();
        $checklist = Checklist::where('report_number',$id)->first();
        $supplier = Supplier::where('report_number',$id)->first();
        $cargo = Cargo::where('report_number',$id)->first();
        $productPhoto = productPhoto::where('report_number',$id)->first();

        if ($cargo->container_status == 'good' ) {
            $cargo_photo_1 = 'images/placeholder.png';
            $cargo_photo_2 = 'images/placeholder.png';
        }else{
            $cargo_photo_1 = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_damage_1;
            $cargo_photo_2 = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_damage_2;
        }

        if ($cargo->cargo_holes == null) {
            $cargo_holes = 'images/placeholder.png';
        }else{
            $cargo_holes = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->cargo_holes;
        }

        if ($cargo->cargo_dents == null) {
            $cargo_dents = 'images/placeholder.png';
        }else{
            $cargo_dents = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->cargo_dents;
        }

        if ($cargo->pallet_material == null) {
            $pallet_material = 'images/placeholder.png';
        }else{
            $pallet_material =  'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->pallet_material;

        }

        if ($cargo->fumigation_stamp == null) {
            $fumigation_stamp = 'images/placeholder.png';
        }else{
            $fumigation_stamp =  'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->fumigation_stamp;
        }


        $product_detail = DetailedProduct::where('report_number',$id)->get();
        $product_info = DetailedProductQty::where('report_number',$id)->first();
        $observation = Observation::where('report_number',$id)->first();
        if ($inpect_info->service == 'cbpi_serial') {
            $serials = Serial::where('report_number',$id)->get();
        }

        if (!empty($observation->damaged_product_photo)) {
            $observation_product_photo = 'images/reports/'.$cargo->report_number.'/observation/'.$observation->damaged_product_photo;
        }else{
            $observation_product_photo = 'images/placeholder.png';
        }
        $loadings = Loading::where('report_number',$id)->first();

        $desc = DetailedPhotoDescription::where('report_number',$id)->orderBy('photo_count', 'asc')->get();

        $phpWord  = new PHPWord();
        /* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...
        $sectionStyle=array( 'marginLeft'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5), 'marginRight'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5), 'marginTop'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.25), 'marginBottom'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.25),'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2),'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2));


        $section = $phpWord->addSection($sectionStyle);


        $header = $section->createHeader();
        if ($inpect_info->service == 'cbpi' || $inpect_info->service == 'cbpi_serial' ) {
            $header->addImage('images/sera.png',['marginTop' => 0]);
        }else{
            $header->addImage('images/isce.jpg',['marginTop' => 0]);
        }
        $footer = $section->createFooter();
        $footer->addPreserveText('{PAGE}');
        //create table styles
        $tableStyle = ['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 80];
        $headerStyle = ['bold' => true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];

        $tableCellNormal = ['valign' => 'center','color'=>'000000','size' => 12];
        $tableCellNormalJess = ['valign' => 'center','align' => 'center','color'=>'000000'];
        $tableCellNormal2 = ['valign' => 'center','color'=>'red'];// joe
        $labelStyle = ['bold'=>true,'align'=>'left','spaceAfter' => 0,'size' => 12]; //jesser
        $labelStyleCentered = ['bold'=>true,'align'=>'center','spaceAfter' => 0, 'size'=>12, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $cellStyle = ['align'=>'left','spaceAfter' => 0];
        $cellStyle2 = ['align'=>'center','spaceAfter' => 0,'color'=>'red'];
        $headercellStyle = ['gridSpan'=>'2','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyle4 = ['gridSpan'=>'4','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerTextStyle= ['bold'=>true,'color'=>'FFFFFF', 'size' => 12];
        $headerTextStyle2= ['bold'=>true,'color'=>'black']; // font color black
        $headerTextStyle3= ['Regular'=>true,'color'=>'black']; // font color black
        $headerTextStyleBlack= ['bold'=>true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'valign'=>'center'];
        $headerTextStyleBlackNotBold= ['color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'valign'=>'center'];
        $serialHeaderTextStyle= ['bold'=>true,'color'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $removeCellBottomPadding = ['spaceAfter' => 0];
        $tableHeaderCellStyle =['gridSpan'=>'4','bgColor'=>'909090'];
        $tableHeaderCellStyleColumnName =['bgColor'=>'000000','align'=>'center','valign'=>'center','size' => 10];
        $tableHeaderCellStyleInfo =['gridSpan'=>'7','bgColor'=>'909090'];
        $tableHeaderCellStyleInfo2 =['gridSpan'=>'7','bgColor'=>'white']; //color white shadding
        //$imageCellDimensions = ['width'=>295,'height'=>250,'spaceAfter' => 0];

        $imageCellDimensions = ['width'=>345,'height'=>290, 'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center']; //'wrappingStyle' => 'inline'
        $imageCellDimensions2 = ['width'=>305,'height'=>290,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center','wrappingStyle' => 'infront'];
        $imageCellDimensions350H = ['width'=>295,'height'=>350,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center'];

        $imageCellDimensionsNew = ['width'=>245,'height'=>200,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center'];

        //jesser
        $labelStyleSize = ['align'=>'left', 'valign' => 'center','size' => 12];
        $cellStyleBorder = ['align'=>'left', 'valign' => 'center', 'borderSize' => 1 ];
        $labelStyle3 = ['bold'=>true,'align'=>'left','spaceAfter' => 0, 'color' => 'ff0000','size' => 12];
        $cellStyleCenter = ['align'=>'center','spaceAfter' => 0];

        //create actual table for general information
        /* if ($inpect_info->service == 'cbpi' || $inpect_info->service == 'cbpi_serial' ) {
            $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => '266baf']);
        }else{
            $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => '1A5E8F']);
        } */

        $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => 'red']);

        $gen_table_cell_style=['align' => 'center','gridSpan'=>'3', 'borderLeftSize'=>0,'borderLeftColor'=>'ffffff'];
        $gen_table_cell_style2=['align' => 'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'ffffff'];
        $gen_txt_box_style=['width'=> 450,'height'=> 30,'borderSize'=> 1,'borderColor' => 'FF0000', 'align' => 'left'];

        /* 1. General Information	 */
        $gentable = $section->addTable('General Info Table');
        $gentable->addRow(50);
        $gentable->addCell(9500, ['gridSpan'=>'4'])->addText('CBPI REPORT', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        $gentable->addRow(50);
        $gentable->addCell(1500, ['align' => 'center'])->addText('Reference:', $labelStyle,$cellStyle);
        $gentable->addCell(8000, ['align' => 'center','gridSpan'=>'3'])->addText($inpect_info->reference_number, $tableCellNormal,$cellStyle);
        $gentable->addRow(50);
        $gentable->addCell(9500, $tableHeaderCellStyle)->addText('1. General Information', $headerTextStyle,$removeCellBottomPadding);
        $gentable->addRow(50);



        $gentable->addCell(500, ['align' => 'center','valign' => 'center','borderSize'=>1,'borderRightColor'=>'ffffff','borderBottomColor'=>'ffffff'])->addText('Date:', $tableCellNormal,$cellStyle);
        $gentable2 = $gentable->addCell(4000,['align' => 'left', 'borderLeftSize'=>0,'borderLeftColor'=>'ffffff','borderRightSize'=>0,'borderRightColor'=>'ffffff','borderBottomSize'=>1,'borderBottomColor'=>'ffffff']);
        $gentable2->addText('',['size' => 0,'lineHeight' =>0.0001]);
        $innerTable = $gentable2->addTable(['valign'=>'center','borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50]);
        $gentable2->addTextBreak();
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4000)->addText($inpect_info->inspection_date);

        $gentable->addCell(500, ['align' => 'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'ffffff', 'borderLeftSize'=>1,'borderLeftColor'=>'ffffff','borderBottomSize'=>1,'borderBottomColor'=>'ffffff'])->addText('Place of Inspection:',$tableCellNormal,$cellStyle);
        $gentable2 = $gentable->addCell(4500,['align' => 'center', 'borderLeftSize'=>1,'borderLeftColor'=>'ffffff','borderBottomSize'=>1,'borderBottomColor'=>'ffffff']);
        $gentable2->addText('',['size' => 0,'lineHeight' =>0.0001]);
        $innerTable = $gentable2->addTable(['valign'=>'center','borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50]);
        $gentable2->addTextBreak();
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4500)->addText($inpect_info->factory_address);
        $gentable->addRow(50);

        $table_style = array(
            'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
            'width' => 100 * 50,
        );

        $cell = $gentable->addCell(9500, ['gridSpan'=>4,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);

        $innerTable = $cell->addTable(['valign'=>'center','borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50, 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
            'width' => 100 * 50]);

        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(2000,['bgcolor'=>'white','align'=>'left','valign' => 'center','borderSize'=>1,'borderTopColor'=>'white','borderLeftColor'=>'white','borderBottomColor'=>'white'])->addText('Client Name',$tableCellNormal,$cellStyle);
        $innerTable->addCell(7500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($inpect_info->client_name,['align'=>'center'],['align'=>'center']);

        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(2000,['bgcolor'=>'white','align'=>'left','valign' => 'center','borderSize'=>1,'borderTopColor'=>'white','borderLeftColor'=>'white','borderBottomColor'=>'white'])->addText('Supplier Name',$tableCellNormal,$cellStyle);
        $innerTable->addCell(7500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($inpect_info->supplier_name,['align'=>'center'],['align'=>'center']);

        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(2000,['bgcolor'=>'white','align'=>'left','valign' => 'center','borderSize'=>1,'borderTopColor'=>'white','borderLeftColor'=>'white','borderBottomColor'=>'white'])->addText('Factory Name',$tableCellNormal,$cellStyle);
        $innerTable->addCell(7500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($inpect_info->factory,['align'=>'center'],['align'=>'center']);


        $section->addTextBreak();



        /* 2. Product Information	*/
        /* $phpWord->addTableStyle('Product Information',  $tableStyle, ['bgColor' => 'FF0000', 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
        'width' => 100 * 50]); */
        $max_width_table_style=['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 80,'bgColor' => 'FF0000', 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
            'width' => 100 * 50];
        $productInfoTable = $section->addTable($max_width_table_style);
        $productInfoTable->addRow(50);
        $productInfoTable->addCell(9500, ['gridSpan'=>'8','bgColor'=>'909090'])->addText('2. Product Information', $headerTextStyle,$removeCellBottomPadding);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Product Name:', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center', 'gridSpan'=>'2'])->addText($productPhoto->Product_Name, $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center', 'gridSpan'=>'5'])->addText('Product', $labelStyle,$cellStyleCenter);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Invoice / PO Number', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText($productPhoto->Invoice_PO_Number, $tableCellNormalJess,$cellStyleCenter);

        $productInfoTable->addCell(4500, ['align' => 'center','valign' => 'center','vMerge' => 'restart', 'gridSpan'=>'5'])->addImage('images/reports/'.$supplier->report_number.'/productPhotoData/'.$productPhoto->Product_Photo,['width'=>300,'height'=>220, 'align'=>'center', 'valign'=>'center']);

        /*  $productInfoTable->addCell(4500, ['align' => 'center','valign' => 'center','vMerge' => 'restart', 'gridSpan'=>'5'])->addText('Photo Of Product(s)', $labelStyle3,$cellStyleCenter); */

        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('PL / Invoice Provided ', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText($productPhoto->PL_Invoice_Provided, $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Total quantity ordered', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText($productPhoto->Total_quantity_ordered, $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Pallets', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText($productPhoto->Pallets, $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center','valign' => 'center','vMerge' => 'restart'])->addText('Inspected Sampling Size', $labelStyle,$cellStyle);
        $productInfoTable->addCell(1000, ['align' => 'center'])->addText('Packages', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(1000, ['align' => 'center'])->addText('Pieces', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center','vMerge' => 'continue']);
        $productInfoTable->addCell(1000, ['align' => 'center'])->addText($productPhoto->Packages, $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(1000, ['align' => 'center'])->addText($productPhoto->Pieces, $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Defects Found', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText($productPhoto->Defects_Found, $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Total Qty. packages Loaded', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText($productPhoto->Total_Qty_packages_Loaded, $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);

        $section->addTextBreak();


        /* 3. Important Remarks */
        $labelStyleRem = ['bold'=>true,'align'=>'left','spaceAfter' => 0, 'color' => 'black'];
        //$phpWord->addTableStyle('Important Remarks',  $tableStyle, ['bgColor' => 'FF0000']);
        $impRemTable = $section->addTable($max_width_table_style);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, $tableHeaderCellStyle)->addText('3. Important Remarks', $headerTextStyle,$removeCellBottomPadding);
        //$impRemTable->addRow(50);

        $get_remarks = explode("&&",$productPhoto->remarks);

        for ($i = 0; $i<count($get_remarks);$i++){
            $num=$i+1;
            $impRemTable->addRow(50);

            if($num==count($get_remarks)){
                $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'black','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText( $num.'. '.$get_remarks[$i], $labelStyleRem,$cellStyle);
            }else{
                $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'ffffff','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText( $num.'. '.$get_remarks[$i], $labelStyleRem,$cellStyle);
            }
        }

        /* $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'ffffff','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText($get_remarks[0], $labelStyleRem,$cellStyle);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'ffffff','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText($get_remarks[1], $labelStyleRem,$cellStyle);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'ffffff','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText('3. ', $labelStyleRem,$cellStyle);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'ffffff','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText('4. ', $labelStyleRem,$cellStyle);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText('5. ', $labelStyleRem,$cellStyle); */

        $section->addTextBreak(7);

        /* $headercellStyleContR = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'borderLeftColor'=>'white', 'borderTopColor'=>'white', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyleContL = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'align'=>'center', 'borderRightColor'=>'white', 'borderTopColor'=>'white', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER]; */

        $headercellStyleContR = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'borderLeftColor'=>'white', 'borderTopColor'=>'black', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyleContL = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'align'=>'center', 'borderRightColor'=>'white', 'borderTopColor'=>'black', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];


        $headercellStyleCont = ['gridSpan'=>'4','bgColor'=>'FFFFFFF', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerTextStyleCont= ['align'=>'center','bold'=>true,'color'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $image_cell_border=['gridSpan'=>'2', 'align' => 'center', 'valign' => 'center'];
        $removeCellBottomPaddingCont = ['spaceAfter' => 0, 'align' => 'center'];

        /* 4. Supplier Overview */
        //$phpWord->addTableStyle('Supplier Overview Table', $tableStyle, ['bgColor' => 'FF0000']);
        $supplierTable = $section->addTable($max_width_table_style);
        $supplierTable->addRow(50);
        $supplierTable->addCell(9500, $tableHeaderCellStyle)->addText('4. Supplier Overview', $headerTextStyle,$removeCellBottomPadding);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, $headercellStyleContL)->addText('Factory Location', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $supplierTable->addCell(4500, $headercellStyleContR)->addText('Factory Gate Picture', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_location,$imageCellDimensions);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_gate, $imageCellDimensions);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, $headercellStyleContL)->addText('Warehouse', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $supplierTable->addCell(4500, $headercellStyleContR)->addText('Loading Area', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->warehouse,$imageCellDimensions);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->loading_area, $imageCellDimensions);

        $section->addPageBreak();

        /* 5. Cargo Information */
        //styles
        $labelStyleSize = ['align'=>'left', 'valign' => 'center','size' => 12];
        $cellStyleBorder = ['align'=>'left', 'valign' => 'center', 'borderSize' => 1 ];
        $headercellStyleJess = ['gridSpan'=>'2', 'color'=> 'white', 'bold'=> true,'size' => 12, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $tableHeaderCellStyleJess =['gridSpan'=>'4','bgcolor'=>'909090'];
        $cargoLabel =['spaceAfter' => 0, 'bold' => true, 'spacing' => 0, 'spaceBefore' => 0, 'size'=> 12];
        $cargoNotBoldLabel =['spaceAfter' => 0, 'spacing' => 0, 'spaceBefore' => 0, 'size'=> 12];
        $cell_style=['gridSpan'=>'2','bgcolor'=>'white'];
        $inner_table_style=['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 10, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER,'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
            'width' => 100 * 50];
        $cargo_text_style=['align' =>'center', 'valign' =>'center', 'size' => 12];

        $table = $section->addTable($max_width_table_style);
        $cargoTable = $table->addRow(50)->addCell(9500,$tableHeaderCellStyleJess);
        $cargoTable->addText('5. Cargo Information', $headercellStyleJess, $removeCellBottomPadding);

        $section->addTextBreak();
        $cargoTable = $table->addRow(50)->addCell(9500,['gridSpan'=>'4','bgcolor'=>'white']);
        $cargoTable->addText('',['size' => 1, 'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable( $inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Inspector Arrival Time:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->inspector_arrival_time, $cargo_text_style, ['align' =>'center']);
        //$section->addTextBreak();

        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Cargo ready Time:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->cargo_ready_time, $cargo_text_style , ['align' =>'center']);
        //$section->addTextBreak();

        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Container Arrival Time:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->container_arrival_time, $cargo_text_style, ['align' =>'center']);
        //$section->addTextBreak();

        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Loading Started:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->loading_started, $cargo_text_style, ['align' =>'center']);
        //$section->addTextBreak();

        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Inspection Finished:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->inspection_finished, $cargo_text_style, ['align' =>'center']);
        //$section->addTextBreak();

        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4500,$cell_style)->addText('Loading Facility Cooperation:',$cargoLabel);
        $innerTable->addCell(1000,$cell_style)->addText('Good',['size'=> 12]);
        if($cargo->loading_facility_cooperation=="good"){
            $innerTable->addCell(500,$cell_style)->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(500,$cell_style)->addText('',$cargoLabel,['align'=>'center']);
        }
        $innerTable->addCell(1000,$cell_style)->addText('Average',['size'=> 12]);
        if($cargo->loading_facility_cooperation=="average"){
            $innerTable->addCell(500,$cell_style)->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(500,$cell_style)->addText('',$cargoLabel,['align'=>'center']);
        }
        $innerTable->addCell(1000,$cell_style)->addText('Bad',['size'=> 12]);
        if($cargo->loading_facility_cooperation=="bad"){
            $innerTable->addCell(1000,$cell_style)->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(1000,$cell_style)->addText('',$cargoLabel,['align'=>'center']);
        }

        //$section->addTextBreak();
        //$cargoTable->addTextBreak();

        $cargoTable = $table->addRow(50)->addCell(2375);
        $cargoTable->addText('Container Number', $cargoLabel);
        $cargoTable = $table->addCell(2375);
        $cargoTable->addText($cargo->container_number, $cargoNotBoldLabel);
        $cargoTable = $table->addCell(2375, ['gridspan' =>2]);
        $cargoTable->addText('', $cargoLabel);

        $cargoTable = $table->addRow(50)->addCell(2375);
        $cargoTable->addText('Shipping Seal No:', $cargoLabel);
        $cargoTable = $table->addCell(2375);
        $cargoTable->addText(ucwords($cargo->shipping_seal_number), $cargoNotBoldLabel);
        $cargoTable = $table->addCell(2375);
        $cargoTable->addText('SERA Seal No:', $cargoLabel);
        $cargoTable = $table->addCell(2375);
        $cargoTable->addText($cargo->sera_seal_number, $cargoNotBoldLabel);

        $top_border=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white'];
        $bot_border=['valign' => 'center','borderSize'=>1, 'borderBottomColor'=>'white'];
        $left_border=['valign' => 'center','borderSize'=>1,'borderLeftColor'=>'white'];
        $right_border=['valign' => 'center','borderSize'=>1, 'borderRightColor'=>'white'];

        $left_right=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderRightColor'=>'white'];

        $left_right_bot=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderRightColor'=>'white','borderBottomColor'=>'white'];
        $left_right_top=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderRightColor'=>'white','borderTopColor'=>'white'];

        $top_bot_left=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderBottomColor'=>'white','borderLeftColor'=>'white'];
        $top_bot_right=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderBottomColor'=>'white','borderRightColor'=>'white'];

        $top_bot_right_left=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderBottomColor'=>'white','borderRightColor'=>'white', 'borderLeftColor'=>'white'];

        $right_bot=['valign' => 'center','borderSize'=>1, 'borderRightColor'=>'white', 'borderBottomColor'=>'white'];
        $right_top=['valign' => 'center','borderSize'=>1, 'borderRightColor'=>'white', 'borderTopColor'=>'white'];
        $left_bot=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderBottomColor'=>'white'];
        $left_top=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderTopColor'=>'white'];
        $top_bot=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderBottomColor'=>'white'];

        $inner_table_style2=['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER,'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
            'width' => 100 * 50];

        $cargoTable = $table->addRow(50)->addCell(3000, $right_bot);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]);
        $cargoTable->addText('Container Size:', $cargoLabel);
        $cargoTable = $table->addCell(6500, ['gridSpan'=>3,'valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderBottomColor'=>'white']);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table 
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(1225,$cell_style , ['valign'=>'center'])->addText('20 ST');
        if($cargo->container_size=="20st"){
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }

        $innerTable->addCell(1225,$cell_style , ['valign'=>'center'])->addText('40 ST');
        if($cargo->container_size=="40st"){
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('✓');
        }else{
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }

        $innerTable->addCell(1225,$cell_style , ['valign'=>'center'])->addText('40 HC');
        if($cargo->container_size=="40hc"){
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }

        $innerTable->addCell(1225,$cell_style , ['valign'=>'center'])->addText('45HC');
        if($cargo->container_size=="45hc"){
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }


        $cargoTable = $table->addRow(50)->addCell(3000, $right_top);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]);
        $cargoTable->addText('Container Status:', $cargoLabel);
        $cargoTable = $table->addCell(6500, ['gridspan' =>3,'borderLeftColor'=>'white', 'borderTopColor'=>'white', 'borderSize'=>1]);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);

        $innerTable->addCell(1250,$cell_style , ['valign'=>'center'])->addText('Good');
        if($cargo->container_status=="good"){
            $innerTable->addCell(416,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(416,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }

        $innerTable->addCell(1500,$cell_style , ['valign'=>'center'])->addText('Damaged');
        if($cargo->container_status=="damaged"){
            $innerTable->addCell(416,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(416,$cell_style , ['valign'=>'center'])->addText('');
        }

        $innerTable->addCell(2500,$cell_style , ['valign'=>'center'])->addText('Seriously Damaged');
        if($cargo->container_status=="seriously damaged"){
            $innerTable->addCell(418,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(418,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }

        function loopTextBreak($count,$tableName){
            for($i=0;$i<$count;$i++){
                $tableName->addTextBreak();
            }
        }




        //$cargoTable = $table->addRow(50)->addCell(9000, ['align' => 'center','gridSpan'=>'4']);
        //$cargoTable->addTextBreak();
        /* $cargoTable->addText('If Damaged, Please Specify', $labelStyle,$cellStyle); 
        if ($cargo->container_status == 'good') {
            $cargoTable = $table->addRow(50)->addCell(4500, ['gridSpan'=>'2'])->addText('N/A', $labelStyleCentered,$cellStyle);
            $cargoTable = $table->addCell(4500, ['gridSpan'=>'2'])->addText('N/A', $labelStyleCentered,$cellStyle);
        }else{
            $cargoTable = $table->addRow(50)->addCell(4500, ['gridSpan'=>'2'])->addImage($cargo_photo_1,$imageCellDimensions350H);
            $cargoTable = $table->addCell(4500, ['gridSpan'=>'2'])->addImage($cargo_photo_2,$imageCellDimensions350H);
            $cargoTable = $table->addRow(50)->addCell(4500, ['gridSpan'=>'2'])->addText();
            $cargoTable = $table->addCell(4500, ['gridSpan'=>'2'])->addText();
        }
        */

        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4]);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(50);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('If Damaged, Please Specify',$labelStyle,$cellStyle);
        $innerTable->addRow(50);
        if($cargo->container_status == 'good'){
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addText('N/A');
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addText('N/A');
        }else{
            /* $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.cargo_photo_1.'/cargo/'.$cargo->loading_area,$imageCellDimensions);
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors, $imageCellDimensions); */
            $damage_count=0;
            $container_status_photos=json_decode($cargo->container_status_photos);
            foreach ($container_status_photos as $key => $container_status_photo) {
                $damage_count= $damage_count+1;
            }
            if($damage_count==1){
                foreach ($container_status_photos as $key => $container_status_photo) {
                    $_container_status_photo='images/reports/'.$cargo->report_number.'/cargo/'.$container_status_photo->image;
                    if($key%3==2){
                        $innerTable->addRow(50);
                    }

                    $c_s_photos=$innerTable->addCell(9500, ['gridSpan'=>'4']);
                    $textrun = $c_s_photos->addTextRun();

                    if($container_status_photo->label!='Label Name' && !empty($container_status_photo->label)){
                        $textrun->addText($container_status_photo->label,['align'=>'center', 'size'=>'12'],['align'=>'center']);
                        $textrun->addTextBreak();
                    }
                    $textrun->addImage($_container_status_photo, ['width'=>690, 'height'=>330,'align'=>'center', 'valign'=>'center']);
                }
            }else{
                if($cargo->container_status_photos!=null && !empty($cargo->container_status_photos)){

                    $container_status_photos=json_decode($cargo->container_status_photos);

                    if(is_array($container_status_photos) && !empty($container_status_photos)){

                        foreach ($container_status_photos as $key => $container_status_photo) {
                            $_container_status_photo='images/reports/'.$cargo->report_number.'/cargo/'.$container_status_photo->image;
                            if($key%3==2){
                                $innerTable->addRow(50);
                            }

                            $c_s_photos=$innerTable->addCell(4750, ['gridSpan'=>'2']);
                            $textrun = $c_s_photos->addTextRun();

                            if($container_status_photo->label!='Label Name' && !empty($container_status_photo->label)){
                                $textrun->addText($container_status_photo->label,['align'=>'center', 'size'=>'12'],['align'=>'center']);
                                $textrun->addTextBreak();
                            }
                            $textrun->addImage($_container_status_photo, $imageCellDimensions350H);
                        }
                    }
                }
            }



            $cargoTable->addTextBreak();
        }



        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1]);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $cargoTable->addTextBreak();
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(1550, ['valign'=>'center'])->addText('Holes:',$labelStyle,$cellStyle);
        $innerTable->addCell(850, ['valign'=>'center'])->addText('Yes');
        $cargo_holes_yes="";
        $cargo_holes_no="";
        if($cargo->holes=="yes"){
            $cargo_holes_yes="✓";
            $cargo_holes_no="";
        }else{
            $cargo_holes_yes="";
            $cargo_holes_no="✓";
        }

        $cargo_dents_yes="";
        $cargo_dents_no="";
        if($cargo->dents=="yes"){
            $cargo_dents_yes="✓";
            $cargo_dents_no="";
        }else{
            $cargo_dents_yes="";
            $cargo_dents_no="✓";
        }


        $innerTable->addCell(750,['valign'=>'center'])->addText($cargo_holes_yes,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(850,['valign'=>'center'])->addText('No');
        $innerTable->addCell(750,['valign'=>'center'])->addText($cargo_holes_no,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1550,['valign'=>'center'])->addText('Dents:',$labelStyle,$cellStyle);
        $innerTable->addCell(750,['valign'=>'center'])->addText('Yes');
        $innerTable->addCell(850,['valign'=>'center'])->addText($cargo_dents_yes,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(750,['valign'=>'center'])->addText('No');
        $innerTable->addCell(850,['valign'=>'center'])->addText($cargo_dents_no,$cargoLabel,['align'=>'center']);



        if ($cargo->holes == 'yes') {
            $innerTable->addRow(50);
            //$cargoHoles = $cargoTable->addCell(4500, ['gridSpan'=>'2']);
            $cargoHoles= $innerTable->addCell(9500,['gridSpan'=>'10']);
            $cargoHoles->addText('Container Holes',['align'=>'center', 'size'=>'12','bold'=>true],['align'=>'center']);
            //$cargoHoles->addImage($cargo_holes,$imageCellDimensions);
            $count_holes=0;
            $hole_photos=json_decode($cargo->hole_photos);
            foreach ($hole_photos as $key => $hole_photo) {
                $count_holes=$count_holes+1;
            }
            if($count_holes==1){
                //if holes is one only
                $innerTable->addRow(50);
                foreach ($hole_photos as $key => $hole_photo) {
                    $_hole_photo='images/reports/'.$cargo->report_number.'/cargo/'.$hole_photo->image;
                    if($key%3==2){
                        $innerTable->addRow(50);
                    }
                    $holes_columns= $innerTable->addCell(9500,['gridSpan'=>'10']);
                    $holes_txtrun=$holes_columns->addTextRun(['align'=>'center','valign'=>'center']);
                    if($hole_photo->label!='Label Name' && !empty($hole_photo->label)){
                        $holes_txtrun->addText($hole_photo->label,['align'=>'center', 'size'=>'12']);
                        $holes_txtrun->addTextBreak();
                    }
                    $holes_txtrun->addImage($_hole_photo, ['width'=>690, 'height'=>300,'align'=>'center', 'valign'=>'center']);
                }
            }else{
                if($cargo->hole_photos!=null && !empty($cargo->hole_photos)){
                    $hole_photos=json_decode($cargo->hole_photos);
                    if(is_array($hole_photos) && !empty($hole_photos)){
                        //$cargoTable->addRow(50);
                        $innerTable->addRow(50);
                        foreach ($hole_photos as $key => $hole_photo) {
                            $_hole_photo='images/reports/'.$cargo->report_number.'/cargo/'.$hole_photo->image;
                            //$cargoHoles->addImage($_hole_photo,$imageCellDimensions);
                            if($key%3==2){
                                // $cargoTable->addRow(50);
                                $innerTable->addRow(50);
                            }

                            //$holes_coulmns=$cargoTable->addCell(4500, ['gridSpan'=>'2']);
                            $holes_columns= $innerTable->addCell(4750,['gridSpan'=>'5']);
                            $holes_txtrun=$holes_columns->addTextRun(['align'=>'center','valign'=>'center']);
                            if($hole_photo->label!='Label Name' && !empty($hole_photo->label)){
                                $holes_txtrun->addText($hole_photo->label,['align'=>'center', 'size'=>'12']);
                                $holes_txtrun->addTextBreak();
                            }
                            $holes_txtrun->addImage($_hole_photo, $imageCellDimensions);
                        }
                    }
                }
            }

        }else{

        }

        if ($cargo->dents == 'yes') {
            $innerTable->addRow(50);
            //$cargoDents = $cargoTable->addCell(9500, ['gridSpan'=>'10']);
            $cargoDents= $innerTable->addCell(9500,['gridSpan'=>'10']);
            $cargoDents->addText('Container Dents',['align'=>'center', 'size'=>'12','bold'=>true],['align'=>'center']);

            $count_dents=0;
            $dent_photos=json_decode($cargo->dent_photos);
            foreach ($dent_photos as $key => $dent_photo) {
                $count_dents=$count_dents+1;
            }
            if($count_dents==1){
                //if holes is one only
                $innerTable->addRow(50);
                foreach ($dent_photos as $key => $dent_photo) {
                    $_dent_photo='images/reports/'.$cargo->report_number.'/cargo/'.$dent_photo->image;

                    if($key%3==2){
                        $innerTable->addRow(50);
                    }
                    $dent_coulmns= $innerTable->addCell(9500,['gridSpan'=>'10']);
                    $dent_txtrun=$dent_coulmns->addTextRun(['align'=>'center','valign'=>'center']);
                    if($dent_photo->label!='Label Name' && !empty($dent_photo->label)){
                        $dent_txtrun->addText($dent_photo->label,['align'=>'center', 'size'=>'12']);
                        $dent_txtrun->addTextBreak();
                    }
                    $dent_txtrun->addImage($_dent_photo, ['width'=>690, 'height'=>300,'align'=>'center', 'valign'=>'center']);

                }
            }else{
                if($cargo->dent_photos!=null && !empty($cargo->dent_photos)){
                    $dent_photos=json_decode($cargo->dent_photos);
                    if(is_array($dent_photos) && !empty($dent_photos)){
                        $innerTable->addRow(50);
                        foreach ($dent_photos as $key => $dent_photo) {
                            $_dent_photo='images/reports/'.$cargo->report_number.'/cargo/'.$dent_photo->image;

                            if($key%3==2){
                                $innerTable->addRow(50);
                            }

                            //$dent_coulmns=$cargoTable->addCell(4750, ['gridSpan'=>'2']);
                            $dent_coulmns= $innerTable->addCell(4750,['gridSpan'=>'5']);
                            $dent_txtrun=$dent_coulmns->addTextRun(['align'=>'center','valign'=>'center']);
                            if($dent_photo->label!='Label Name' && !empty($dent_photo->label)){
                                $dent_txtrun->addText($dent_photo->label,['align'=>'center', 'size'=>'12']);
                                $dent_txtrun->addTextBreak();
                            }
                            $dent_txtrun->addImage($_dent_photo, $imageCellDimensions);

                        }
                    }
                }
            }


        }else{

        }

        //$innerTable->addRow(2000);


        /* $textrun = $innerTable->addCell(4750,['gridSpan'=>'10','bgcolor'=>'white','valign'=>'center']);
        $textrun->addText('Image',['valign'=>'center','align'=>'center'],['valign'=>'center','align'=>'center']);
        $textrun->addTable($inner_table_style2);
        $textrun->addRow(1500);
        $textrun->addCell(4750,['gridSpan'=>'10','bgcolor'=>'white','valign'=>'center']);
        $textrun->addText('test',['valign'=>'center','align'=>'center'],['valign'=>'center','align'=>'center']); */
        // $textrun->addImage('images/tic.png', array( 'wrappingStyle' => 'inline', 'width' => 120, 'height' => 40, 'align'=>'center','spaceAfter'=>0));

        //$innerTable->addCell(4750,['gridSpan'=>'5','bgcolor'=>'white','valign'=>'center'])->addText('N/A'); 
        /* if ($cargo->holes == 'yes') {
           // $cargoHoles = $cargoTable->addCell(4500, ['gridSpan'=>'2']);
            //$cargoHoles->addText('Container Holes');
            //$cargoHoles->addImage($cargo_holes,$imageCellDimensions);

            if($cargo->hole_photos!=null && !empty($cargo->hole_photos)){
                    $hole_photos=json_decode($cargo->hole_photos);
                    if(is_array($hole_photos) && !empty($hole_photos)){
                        $cargoTable->addRow(50);
                        foreach ($hole_photos as $key => $hole_photo) {
                             $_hole_photo='images/reports/'.$cargo->report_number.'/cargo/'.$hole_photo->image;
                             //$cargoHoles->addImage($_hole_photo,$imageCellDimensions);
                             if($key%3==2){
                                 $cargoTable->addRow(50);
                             }
                             
                             $holes_coulmns=$cargoTable->addCell(4500, ['gridSpan'=>'2']);
                             $holes_txtrun=$holes_coulmns->addTextRun();
                                if($hole_photo->label!='Label Name' && !empty($hole_photo->label)){
                                     $holes_txtrun->addText($hole_photo->label);
                                     $holes_txtrun->addTextBreak();
                                }
                             $holes_txtrun->addImage($_hole_photo, $imageCellDimensions);
                        }
                    }
                   
                }

        }else{
           $innerTable->addCell(4750,['gridSpan'=>'10','bgcolor'=>'white','valign'=>'center'])->addText('N/A',['valign'=>'center','align'=>'center'],['valign'=>'center','align'=>'center']);
            $innerTable->addCell(4750,['gridSpan'=>'10','bgcolor'=>'white','valign'=>'center'])->addText('N/A',['valign'=>'center','align'=>'center'],['valign'=>'center','align'=>'center']);
        }  */

        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderBottomColor'=>'white', 'borderTopColor'=>'white']);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $flr_cond_good="";  // good
        $flr_cond_scr="";  // scratched
        $flr_cond_bro="";     // broken
        if($cargo->floor_condition=="good"){
            $flr_cond_good="✓";
            $flr_cond_scr="";
            $flr_cond_bro="";
        }else if($cargo->floor_condition=="broken"){
            $flr_cond_good="";
            $flr_cond_scr="✓";
            $flr_cond_bro="";
        }else{
            $flr_cond_good="";
            $flr_cond_scr="";
            $flr_cond_bro="✓";
        }
        $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Floors Condition:',$labelStyle,$cellStyle);
        $innerTable->addCell(1000,$cell_style , ['valign'=>'center'])->addText('Good');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($flr_cond_good,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1000,$cell_style , ['valign'=>'center'])->addText('Scratched');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($flr_cond_scr,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1000,$cell_style , ['valign'=>'center'])->addText('Broken');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($flr_cond_bro,$cargoLabel,['align'=>'center']);

        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderBottomColor'=>'white', 'borderTopColor'=>'white']);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $door_cond_good="";  // good
        $door_cond_bad="";  // scratched
        if($cargo->doors_condition=="good"){
            $door_cond_good="✓";
            $door_cond_bad="";
        }else{
            $door_cond_good="";
            $door_cond_bad="✓";
        }
        $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Doors Condition:',$labelStyle,$cellStyle);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Good');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($door_cond_good,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Bad');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($door_cond_bad,$cargoLabel,['align'=>'center']);

        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderTopColor'=>'white']);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $lig_cond_good="";  // good
        $lig_cond_bad="";  // scratched
        if($cargo->light_proof=="good"){
            $lig_cond_good="✓";
            $lig_cond_bad="";
        }else{
            $lig_cond_good="";
            $lig_cond_bad="✓";
        }
        $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Light Proof:',$labelStyle,$cellStyle);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Good');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($door_cond_good,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Bad');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($door_cond_bad,$cargoLabel,['align'=>'center']);

        /* OUTSIDE CONTAINER PHOTO */


        /* $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'align'=>'center', 'borderSize'=>1]);
        $cargoTable->addText('OUTSIDE CONTAINER PHOTO',$labelStyleCentered,['align'=>'center']); 
        
       
        $cargoTable = $table->addRow(50)->addCell(4500, $headercellStyleContL);
        $cargoTable->addText('Container Front (Doors)', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable = $table->addCell(4500, $headercellStyleContR);
        $cargoTable->addText('Container Back Side', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable= $table->addRow(50)->addCell(4500,  $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->loading_area,$imageCellDimensions);
        $cargoTable= $table->addCell(4500,  $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors, $imageCellDimensions);
        
        $cargoTable = $table->addRow(50)->addCell(4500, $headercellStyleContL);
        $cargoTable->addText('Container Left Side ', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable = $table->addCell(4500, $headercellStyleContR);
        $cargoTable->addText('Container Right Side', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable= $table->addRow(50)->addCell(4500, $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->left_side,$imageCellDimensions);
        $cargoTable= $table->addCell(4500, $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->right_side, $imageCellDimensions);
         */


        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4]);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(50);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('Front (Doors)', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('Back', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $innerTable->addRow(50);
        if($cargo->loading_area=='N/A'){
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addText('N/A',['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center'],['align'=>'center']);
        }else{
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->loading_area,['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center']);
        }

        if($cargo->front_doors=='N/A'){
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addText('N/A',['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center'],['align'=>'center']);
        }else{
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors, ['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center']);
        }



        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4]);
        //$cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(50);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('Left Side', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('Right Side', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $innerTable->addRow(50);
        if($cargo->left_side=='N/A'){
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addText('N/A',['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center'],['align'=>'center']);
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->right_side, ['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center']);
        }else{
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->left_side,['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center']);
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->right_side, ['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center']);
        }



        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4]);
        //$cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(50);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('Container floor n joint inside', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('Container wall n joint inside', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $innerTable->addRow(50);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_floor_and_joint,['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center']);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_wall_and_joint, ['width'=>285,'height'=>240,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center']);


        /* $cargoTable = $table->addRow(50)->addCell(4500, $headercellStyleContL);
        $cargoTable->addText('Container Left Side ', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable = $table->addCell(4500, $headercellStyleContR);
        $cargoTable->addText('Container Right Side', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable= $table->addRow(50)->addCell(4500, $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->left_side,$imageCellDimensions);
        $cargoTable= $table->addCell(4500, $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->right_side, $imageCellDimensions); */

        /* INSIDE CONTAINER PHOTO */

        /*  $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'align'=>'center', 'borderSize'=>1]);
         //$cargoTable->addTextBreak();
         $cargoTable->addText('INSIDE CONTAINER PHOTO',$labelStyleCentered,['align'=>'center']);  */

        /*  $cargoTable = $table->addRow(50)->addCell(4750, $headercellStyleContL);
         $cargoTable->addText('Container floor and joint (inside)', $headerTextStyleCont,$removeCellBottomPaddingCont);
         $cargoTable = $table->addCell(4750, $headercellStyleContR);
         $cargoTable->addText('Container wall and joint (Inside)', $headerTextStyleCont,$removeCellBottomPaddingCont);
         $cargoTable= $table->addRow(50)->addCell(4750,  $image_cell_border);
         $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_floor_and_joint,$imageCellDimensions2);
         $cargoTable= $table->addCell(4750,  $image_cell_border);
         $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_wall_and_joint, $imageCellDimensions2);

         $cargoTable = $table->addRow(50)->addCell(4750, $headercellStyleContL);
         $cargoTable->addText('Container Ceiling (inside)', $headerTextStyleCont,$removeCellBottomPaddingCont);
         $cargoTable = $table->addCell(4750, $headercellStyleContR);
         $cargoTable->addText('Container Doors Closed (Inside)', $headerTextStyleCont,$removeCellBottomPaddingCont);
         $cargoTable= $table->addRow(50)->addCell(4750, $image_cell_border);
         $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_ceiling,$imageCellDimensions2);
         $cargoTable= $table->addCell(4750, $image_cell_border);
         $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_doors_closed, $imageCellDimensions2); */

        $cargoTable = $table->addRow(50)->addCell(9500, $headercellStyleCont);
        //$cargoTable->addTextBreak();
        $cargoTable->addText('Equipment Interchange Receipt(EIR)', $headerTextStyleCont,['align'=>'center']);
        $cargoTable = $table->addRow(50)->addCell(9500, ['gridSpan'=>'4']);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->equipment_interchange_receipt,['width'=>690, 'height'=>530,'align'=>'center', 'valign'=>'center']);

        $section->addTextBreak();

        $table = $section->addTable($max_width_table_style);
        $palletizedCargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderBottomColor'=>'black', 'borderTopColor'=>'black']);
        $palletizedCargoTable->addText('',['size' => 0,'lineHeight' =>0.001]); //Nested Table
        $innerTable = $palletizedCargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);

        $pal_carg_yes="";  // good
        $pal_carg_no="";  // scratched
        if($cargo->palletized_cargo=="yes"){
            $pal_carg_yes="✓";
            $pal_carg_no="";
        }else{
            $pal_carg_yes="";
            $pal_carg_no="✓";
        }
        $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Palletized Cargo:',$labelStyle,$cellStyle);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Yes');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($pal_carg_yes,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('No');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($pal_carg_no,$cargoLabel,['align'=>'center']);

        $palletizedCargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderTopColor'=>'black']);
        $palletizedCargoTable->addText('',['size' => 0,'lineHeight' =>0.001]); //Nested Table
        $innerTable = $palletizedCargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Specify the material of the Pallet:',$labelStyle,$cellStyle);
        $innerTable->addCell(4500,$cell_style , ['valign'=>'center'])->addText($cargo->specify_pallet_material);

        $palletizedCargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1]);
        $palletizedCargoTable->addText('',['size' => 0,'lineHeight' =>0.001]); //Nested Table
        $innerTable = $palletizedCargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderLeftColor'=>'white', 'borderRightColor'=>'white'])->addText('Pallet’s Material',$labelStyle,['align'=>'center']);
        $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderLeftColor'=>'white', 'borderRightColor'=>'white'])->addText('Fumigation’s Stamp',$labelStyle,['align'=>'center']);
        //$innerTable->addRow(50);

        if($cargo->pallet_material == null) {
            $innerTable->addRow(300,['exactHeight'=>true]);
            $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center'])->addText('N/A',$headerTextStyleCont,['align'=>'center']);
            $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center'])->addText('N/A',$headerTextStyleCont,['align'=>'center']);
        }else{

            $innerTable->addRow(50);
            $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center'])->addImage($pallet_material,$imageCellDimensions);
            $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center'])->addImage($fumigation_stamp,$imageCellDimensions);
        }



        $palletizedCargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1]);
        $palletizedCargoTable->addText('',['size' => 0,'lineHeight' =>0.001]); //Nested Table
        $innerTable = $palletizedCargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3500,$cell_style , ['valign'=>'center'])->addText('Number of Pallets loaded:',$labelStyle,$cellStyle);
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($cargo->number_of_pallets_loaded, $cargoLabel,['align'=>'center']);
        $innerTable->addCell(2500,$cell_style , ['valign'=>'center'])->addText('From Pallet No:',$labelStyle,$cellStyle);
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($cargo->from_pallet_number,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(2500,$cell_style , ['valign'=>'center'])->addText('To:',$labelStyle,$cellStyle);
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($cargo->to_pallet_number,$cargoLabel,['align'=>'center']);

        $section->addTextBreak();

        //joe 6-7

        /* 6. Product Detailed Information */
        //$phpWord->addTableStyle('Product Detailed Information', $tableStyle, ['bgColor' => 'FF0000']);
        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(9500, $tableHeaderCellStyleInfo)->addText('6. Product Detailed Information', $headerTextStyle,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(9500, $tableHeaderCellStyleInfo2)->addText('Total Quantity:	', $headerTextStyle2,$removeCellBottomPadding);
        $productInfo->addRow(50,['exactHeight'=>true]);
        $productInfo->addCell(9500,['gridSpan'=>'7'])->addText('');
        $productInfo->addRow(50);
        $productInfo->addCell(2000, $tableHeaderCellStyleColumnName)->addText('Invoice No.', $headerTextStyleBlackNotBold, $removeCellBottomPadding);
        $productInfo->addCell(500, $tableHeaderCellStyleColumnName)->addText('P.O.', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(500, $tableHeaderCellStyleColumnName)->addText('Model', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(2500, $tableHeaderCellStyleColumnName)->addText('Description', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(1250, $tableHeaderCellStyleColumnName)->addText('Packages (Cartons)', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(1500, $tableHeaderCellStyleColumnName)->addText('Pieces/Pairs', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(1250, $tableHeaderCellStyleColumnName)->addText('Material', $headerTextStyleBlackNotBold,$removeCellBottomPadding);

        $total = 0;
        foreach ($product_detail as $p) {
            $productInfo->addRow(50);
            $productInfo->addCell(1350, ['align' => 'center','valign' => 'center'])->addText($p->invoice_no, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->po_no, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->model_number, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->description, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->package_qty, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->pieces, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->material, $tableCellNormalJess,$cellStyleCenter);
            $total+= $p->package_qty;
        }

        /* for($i=0;$i<=9;$i++){
            $productInfo->addRow(50);
            $productInfo->addCell(1350, ['align' => 'center','vMerge' => 'continue'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        } */
        $productInfo->addRow(50);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('Total', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText($total, $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);



        //$productInfo->addRow(50);
        /* $productInfo->addCell(1350, ['gridSpan'=>'4', 'align' => 'center'])->addText('Total', $tableCellNormal2,$cellStyle2);
        $productInfo->addCell(1350, ['align' => 'center'])->addText($total, $tableCellNormal2,$cellStyle2);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormal2,$cellStyle2);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormal2,$cellStyle2); */


        /*  if ($inpect_info->service == 'cbpi_serial') {
             $section->addTextBreak();
             $phpWord->addTableStyle('Serial Numbers', $tableStyle, ['bgColor' => 'FFFFFF']);
             $serial_no = $section->addTable($max_width_table_style);
             $serial_no->addRow(50);
             $serial_no->addCell(3500, ['align' => 'center'])->addText('Item Name', $serialHeaderTextStyle,$cellStyle);
             $serial_no->addCell(3000, ['align' => 'center'])->addText('Serial Number', $serialHeaderTextStyle,$cellStyle);
             $serial_no->addCell(3000, ['align' => 'center'])->addText('Carton Size', $serialHeaderTextStyle,$cellStyle);

             foreach ($serials as $s) {
                 $serial_no->addRow(50);
                 $serial_no->addCell(3500, ['align' => 'center'])->addText($s->item_name, $tableCellNormal,$cellStyle);
                 $serial_no->addCell(3000, ['align' => 'center'])->addText($s->serial_number, $tableCellNormal,$cellStyle);
                 $serial_no->addCell(3000, ['align' => 'center'])->addText($s->carton_size, $tableCellNormal,$cellStyle);
             }

         } */


        $section->addTextBreak();

        $productInfo2 = $section->addTable($max_width_table_style);
        $productInfo2->addRow(50);
        $productInfo2->addCell(7500, ['align' => 'left','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1])->addText('Does the quantity and characteristics of the items from the packing list match exactly with the inspected items?',['size'=>12]);
        $cell = $productInfo2->addCell(2000, ['valign' => 'center','align' => 'left','borderLeftSize'=>1,'borderLeftColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1]);
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>800, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $prod_match_yes="";
        $prod_match_no="";
        if($product_info->match=='yes' || $product_info->match=='Yes' || $product_info->match=='YES'){
            $prod_match_yes="✓";
            $prod_match_no="";
        }else{
            $prod_match_yes="";
            $prod_match_no="✓";
        }
        $innerTable->addCell(500,['bgcolor'=>'white'])->addText('Yes');
        $innerTable->addCell(500,['bgcolor'=>'white'])->addText($prod_match_yes,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white'])->addText('No');
        $innerTable->addCell(500,['bgcolor'=>'white'])->addText($prod_match_no,$cargoLabel,['align'=>'center']);

        //$productInfo2->addRow(50);

        $ifnotTable = $productInfo2->addRow(50)->addCell(9500, ['gridspan' =>2, 'borderSize'=>1]);
        $ifnotTable->addText('',['size' => 0,'lineHeight' =>0.001]); //Nested Table
        $innerTable = $ifnotTable->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
            'width' => 100 * 50, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(9500,['gridSpan'=>4,'valign'=>'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderLeftColor'=>'white', 'borderRightColor'=>'white'])    ->addText('If not, please specify:',['size'=>12,'bold' => true,'valign' => 'bottom','spaceAfter'=>0,'lineHeight' => 1]);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(9500,['bgcolor'=>'white','gridSpan'=>4])->addText('N/A');


        /* $productInfo2->addCell(9500,['gridSpan'=>2,'borderTopColor'=>'white','borderBottomColor'=>'white','bgcolor'=>'white','borderTopSize'=>1,'borderBottomSize'=>1,'valign' => 'bottom','spaceAfter'=>0])->addText('If not, please specify:',['size'=>12,'bold' => true,'valign' => 'bottom','spaceAfter'=>0,'lineHeight' => 1]);
        $productInfo2->addRow(50);
        $cell = $productInfo2->addCell(9500, ['gridSpan'=>2,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
        'width' => 100 * 50, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(9500,['bgcolor'=>'white'])->addText('Yes'); */

        $productInfo2->addRow(50);
        $cell = $productInfo2->addCell(9500, ['gridSpan'=>2,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);
        /* $cell->addTextBreak(); */
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000));

        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4000,['bgcolor'=>'white','align'=>'left','valign' => 'center'])->addText('Total number of packages opened:');
        $innerTable->addCell(1500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($product_info->boxes_opened_photos,['align'=>'center'],['align'=>'center']);

        /* $cell->addTextBreak(); */
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4000,['bgcolor'=>'white','align'=>'left','valign' => 'center'])->addText('Total number of packages inspected:');
        $innerTable->addCell(1500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($product_info->boxes_opened_revision,['align'=>'center'],['align'=>'center']);

        /* $cell->addTextBreak(); */
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4000,['bgcolor'=>'white','align'=>'left','valign' => 'center'])->addText('Total number or SERA Stickers used:');
        $innerTable->addCell(1500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($product_info->boxes_opened_photos + $product_info->boxes_opened_revision,['align'=>'center'],['align'=>'center']);



        $section->addTextBreak();
        /* 7. Observations */
        // $phpWord->addTableStyle('If not, please specify:', $tableStyle, ['bgColor' => 'ffffff']);
        $productInfo2 = $section->addTable($max_width_table_style);
        $productInfo2->addRow(50);
        $productInfo2->addCell(9500, ['gridSpan'=>'4', 'bgColor'=>'gray'])->addText('7. Observations', $headerTextStyle,$removeCellBottomPadding);
        /*    $cell = $productInfo2->addCell(9500, ['gridSpan'=>2,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderBottomColor'=>'black','borderBottomSize'=>1]);
           $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
           $innerTable->addRow(50);
           $innerTable->addCell(9500, $tableHeaderCellStyleInfo)->addText('7. Observations', $headerTextStyle,$removeCellBottomPadding); */

        $productInfo2->addRow(50);
        $cell = $productInfo2->addCell(9500, ['gridSpan'=>4,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);
        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000));

        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(2000,['bgcolor'=>'white','align'=>'left','valign' => 'center'])->addText('Damaged Products:',['bold' => true]);
        $damage_yes="";
        $damage_no="";
        if($observation->damaged_products=='yes' || $observation->damaged_products=='Yes' || $observation->damaged_products=='YES'){
            $damage_yes="✓";
            $damage_no="";
        }else{
            $damage_yes="";
            $damage_no="✓";
        }
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('Yes',['align'=>'center'],['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($damage_yes,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('No',['align'=>'center'],['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($damage_no,$cargoLabel,['align'=>'center']);


        $cell->addTextBreak();
        $innerTable = $cell->addTable($max_width_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(9500,['bgcolor'=>'white','align'=>'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1,'borderLeftSize'=>1,'borderBottomColor'=>'white','borderTopColor'=>'white','borderTopSize'=>1,'borderLeftColor'=>'white','borderLeftSize'=>1])->addText('If yes, please specify:',['bold' => true]);

        if ($observation->damaged_products == 'no') {
            $innerTable->addRow(300,['exactHeight'=>true]);
            $innerTable->addCell(9500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('');
        }else{
            $innerTable->addRow(50);
            $innerTable->addCell(9500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addImage($observation_product_photo,['width'=>690, 'height'=>600]);
        }


        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000','unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
            'width' => 100 * 50,'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1,'borderLeftSize'=>1,'borderBottomColor'=>'white','borderTopColor'=>'white','borderTopSize'=>1,'borderLeftColor'=>'white','borderLeftSize'=>1])->addText('Other Observations: ',['bold' => true]);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($observation->other_obsetvations);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center','bgcolor'=>'white','align'=>'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1,'borderLeftSize'=>1,'borderBottomColor'=>'white','borderTopColor'=>'white','borderTopSize'=>1,'borderLeftColor'=>'white','borderLeftSize'=>1])->addText(' ');

        $section->addTextBreak();

        /* 8. Loading Pictures */
        $section->addPageBreak();
        //$phpWord->addTableStyle('Loading Pictures', $tableStyle, ['bgColor' => 'gray']);
        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(9500, ['gridSpan'=>'4', 'bgColor'=>'gray'])->addText('8. Loading Pictures', $headerTextStyle,$removeCellBottomPadding);
        //$productInfo->addCell(9500, ['gridSpan'=>'4'])->addText('8. Loading Pictures', $headerTextStyle,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2','align' => 'center','bgColor' => 'white'])->addText('Container:', $labelStyle);
        $productInfo->addCell(4750, ['gridSpan'=>'2','align' => 'center','bgColor' => 'white'])->addText($cargo->container_number, $labelStyle);
        //$productInfo->addRow(50);

        $headercellStyleContFull = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'borderLeftColor'=>'white', 'borderRightColor'=>'white', 'borderTopColor'=>'white', 'borderBottomColor'=>'white','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];

        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Container Number Photo', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Empty Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_number_photo, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->empty_container,$imageCellDimensions);

        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('25% Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Half Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->quarter_loaded_container, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->half_loaded_container,$imageCellDimensions);

        /*       $productInfo->addCell(4750, $headercellStyleContFull)->addText('25% Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
              $productInfo->addCell(4750, $headercellStyleContFull)->addText('Half Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
              $productInfo->addRow(50);
              $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->quarter_loaded_container, $imageCellDimensions);
              $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->half_loaded_container,$imageCellDimensions); */

        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('75% Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Full Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->threefourth_loaded_container, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->full_loaded_container,$imageCellDimensions);

        /*   $productInfo->addRow(50);
          $productInfo->addCell(4750, $headercellStyleContL)->addText('75% Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
          $productInfo->addCell(4750, $headercellStyleContR)->addText('Full Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
          $productInfo->addRow(50);
          $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->threefourth_loaded_container, $imageCellDimensions);
          $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->full_loaded_container,$imageCellDimensions); */

        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Container Closed Seals', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Shipping Seal Number', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number,$imageCellDimensions);


        /* $productInfo->addRow(50);        
        $productInfo->addCell(4750, $headercellStyleContL)->addText('Container Closed Seals', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContR)->addText('Shipping Seal Number', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number,$imageCellDimensions); */

        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Shipping Seal number', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Warehouse', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->sera_seal_number, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->warehouse,$imageCellDimensions);


        /*  $productInfo->addRow(50);
         $productInfo->addCell(4750, $headercellStyleContL)->addText('Shipping Seal number', $headerTextStyleCont,$removeCellBottomPaddingCont);
         $productInfo->addCell(4750, $headercellStyleContR)->addText('Warehouse', $headerTextStyleCont,$removeCellBottomPaddingCont);
         $productInfo->addRow(50);

         $productInfo->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->sera_seal_number, $imageCellDimensions);
         $productInfo->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->warehouse,$imageCellDimensions); */

        $section->addTextBreak();



        //create table for 9. detailed product pictures
        //$phpWord->addTableStyle('Detailed Photos', $tableStyle, ['bgColor' => 'FF0000']);
        $detailed_photos = $section->addTable($max_width_table_style);
        $detailed_photos->addRow(50);
        $detailed_photos->addCell(9500, $tableHeaderCellStyle)->addText('9. Detailed Pictures', $headerTextStyle,$removeCellBottomPadding);

        $photos = DetailedPhoto::distinct()->select('photo_count')->where('report_number',$inpect_info->reference_number)->orderBy('photo_count', 'asc')->groupBy('photo_count')->get();


        foreach ($photos as $key => $value) {
            $images = DetailedPhoto::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->orderByRaw('cast(SUBSTRING_INDEX(SUBSTRING_INDEX(image_data, "-", -2), "-", 1) as unsigned) ASC')->get();
            $descr = DetailedPhotoDescription::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->first();

            $length = count($images);
            $section->addTextBreak();
            //$phpWord->addTableStyle($descr->product_description, $tableStyle, ['bgColor' => 'FFFFFF']);
            //$key = $section->addTable($descr->product_description);
            $key = $section->addTable($max_width_table_style);
            $key->addRow(50);
            $key->addCell(9500, ['gridSpan'=>'8','align' => 'center'])->addText('Description: '. $descr->product_description, $labelStyle,$cellStyle);
            foreach ($images as $k => $image) {
                if ($k % 2 === 0) {
                    $key->addRow(50);
                    //$productInfo->addCell(4750, $headercellStyleContL)->addText('Container Closed Seals', $headerTextStyleCont,$removeCellBottomPaddingCont);
                    //$productInfo->addCell(4750, $headercellStyleContR)->addText('Shipping Seal Number', $headerTextStyleCont,$removeCellBottomPaddingCont);

                    $headercellStyleContFullSpanFour = ['gridSpan'=>'4','bgColor'=>'FFFFFFF', 'borderSize'=>1,'borderLeftColor'=>'white', 'borderTopColor'=>'white','borderRightColor'=>'white'];
                    if ($k < $length) {
                        $key->addCell(4750, $headercellStyleContFullSpanFour)->addText($images[$k]->photo_label, $headerTextStyleCont,$removeCellBottomPaddingCont);
                    }
                    if ($k+1 < $length) {
                        $key->addCell(4750, $headercellStyleContFullSpanFour)->addText($images[$k+1]->photo_label, $headerTextStyleCont,$removeCellBottomPaddingCont);
                    }

                    $key->addRow(50);
                    if ($k < $length) {
                        $key->addCell(4750, ['gridSpan'=>'4','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k]->photo_count.'/'.$images[$k]->image_data, $imageCellDimensions);
                    }
                    if ($k+1 < $length) {
                        $key->addCell(4750, ['gridSpan'=>'4','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k+1]->photo_count.'/'.$images[$k+1]->image_data,$imageCellDimensions);
                    }
                }
            };

        }

        $section->addPageBreak();

        //create table for inspection checklist
        //$phpWord->addTableStyle('Checklist Table', $tableStyle, ['bgColor' => 'FF0000']);
        $checklistTable = $section->addTable($max_width_table_style);
        $checklistTable->addRow(50);
        $checklistTable->addCell(9500, $tableHeaderCellStyle)->addText('10. Inspection Checklist', $headerTextStyle,$removeCellBottomPadding);
        $checklistTable->addRow(50);
        $checklistTable->addCell(9500, ['gridSpan'=>'4','spaceAfter' => 0,'cellMargin'=> 0,'spacing' => 0])->addImage('images/reports/'.$checklist->report_number.'/checklist/'.$checklist->image_path,['width'=>700,'height'=>620,'cellMargin'=>0,'spaceAfter' => 0, 'spacing' => 0,'align'=>'center','valign'=>'center']);



        $file = $inpect_info->reference_number.'.docx';
        // Saving the document as HTML file...
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');

    }

    public function testCount()
    {
        $photos = DetailedPhoto::distinct()->select('photo_count')->where('report_number','SR12345')->orderBy('photo_count', 'asc')->groupBy('photo_count')->get();
        $images = DetailedPhoto::where('report_number','SR12345')->where('photo_count',0)->get();
        $length = count($images);

        return response()->json([
            'photo'=> $photos,
            'images'=> $images,
            'length'=>$length
        ]);
    }
}
