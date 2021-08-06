<?php
function flattenWithKeys(array $array, $result = array()) {
    foreach($array as $k => $v) {
        if(is_array($v) || is_object($v)) $result = flattenWithKeys( (array) $v, $result);
        else {
            if(array_key_exists($k,$result)) {
                if(is_string($result[$k])){
                    $content = $result[$k];
                    $result[$k] = [$content];
                }
                array_push($result[$k], $v);
            }
            else
                $result[$k] = $v;
        }
    }

    return $result;
}

function outerHTML($e) {
    $doc = new DOMDocument();
    $doc->appendChild($doc->importNode($e, true));

    return $doc->saveHTML();
}

function cloneNode($node,$doc){
    $nd=$doc->createElement($node->nodeName);

    $nd->setAttribute('rowspan','continue');

    if(!$node->childNodes)
        return $nd;

    foreach($node->childNodes as $child) {
        if($child->nodeName=="#text")
            $nd->appendChild($doc->createTextNode($child->nodeValue));
        else
            $nd->appendChild(cloneNode($child,$doc));
    }

    return $nd;
}

function outputProgress($current, $total) {
    echo round($current / $total * 100) . ',';
    myFlush();
    sleep(1);
}

function myFlush() {
    if (@ob_get_contents()) {
        @ob_end_flush();
    }
    flush();
}

function tableClone($node,$doc,$ct){
    $nd=$doc->createElement($node->nodeName);

    foreach($node->attributes as $value){
        if($value->nodeName === 'id')
            $nd->setAttribute($value->nodeName,$value->value . $ct);
        else if($value->nodeName === 'tic-input')
            $nd->setAttribute($value->nodeName,'cloned-table');
        else
            $nd->setAttribute($value->nodeName,$value->value);
    }

    if(!$node->childNodes)
        return $nd;

    foreach($node->childNodes as $child) {
        if($child->nodeName=="#text")
            $nd->appendChild($doc->createTextNode($child->nodeValue));
        else
            $nd->appendChild(tableClone($child,$doc,$ct));
    }

    return $nd;
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function translate_text($crawler, $key) {
	
	$key = substr($key, 0, 7);
	
	$label = $crawler->filterXPath("//div[@id = '$key']")->getNode(0);
	
	return $label->getAttribute('label');
	
}

function translate_cb($crawler, $key, $value, $options, $custom_table = false) {
	if($custom_table)
		$key = substr($key, 0, 7);
	
	$index = 0;
	
	foreach($options as $k => $v){
		if($v->option == $value)
			$index = $k;
	}

	$label = $crawler->filterXPath("//div[@id = '$key']")->children()->each(function($nod) use ($index) {
		return $nod->getNode(0)->getAttribute('label');
	});
	
	return $label[$index];
	
}

function get_src($id, $section, $label, $filename) {
	return 'https://tic-service.company/images/reports/' . trim($id) . '/' . clean_section($section) . '/' . clean_label($label) . '-' . $filename;
}

function clean_section($section) {
	$section = trim($section);
	$section = str_replace(' / ', '_or_', $section);
	$section = str_replace('/', '_or_', $section);
	$section = str_replace(' & ', '_and_', $section);
	$section = str_replace('&', '_and_', $section);
	$section = str_replace(' ', '_', $section);
	$section = str_replace(' &amp;', '', $section);
	$section = str_replace('&amp; ', '', $section);
	$section = str_replace('&amp;', '', $section);
	
	return $section;
}

function clean_label($label) {
	$label = str_replace(' &amp;', '-', $label);
	$label = str_replace('&amp; ', '-', $label);
	$label = str_replace('&amp;', '-', $label);
	$label = str_replace(' &amp; ', '-', $label);
	$label = str_replace(' & ', '-', $label);
	$label = str_replace('&', '-', $label);
	$label = str_replace(' / ', '-', $label);
	$label = str_replace('/', '-', $label);

	$label = str_slug($label, '-');
	$label = trim($label);
	
	return $label;
}

function list_all_files($base_path, &$result = null)
{
	if(!$result) $result = [];
	$files = array_diff(scandir($base_path), array('.', '..'));
	collect($files)->each(function($file, $key) use ($base_path, &$result) {
		if(is_dir($base_path . '/' . $file)){
			list_all_files($base_path . '/' . $file, $result);
		} else {
			$data = explode('-', $file);
			if (strpos($data[count($data) - 1], 'jpg') !== false) {
				$result[] = $data[count($data) - 1];
			}
		}
	});
	return $result;
}

function list_all_files_full_path($base_path, &$result = null)
{
	if(!$result) $result = [];
	$files = array_diff(scandir($base_path), array('.', '..'));
	collect($files)->each(function($file, $key) use ($base_path, &$result) {
		if(is_dir($base_path . '/' . $file)){
			list_all_files_full_path($base_path . '/' . $file, $result);
		} else {
			$ext = pathinfo($base_path . '/' . $file, PATHINFO_EXTENSION);
			if($ext === 'jpg') {
				$result[] = $base_path . '/' . $file;
			}
		}
	});
	return $result;
}

function resize_images($images)
{
	$result = [];
	
	if(!empty($images))
	{
		foreach($images as $image) {
			list($width, $height) = getimagesize($image);
			
			if(($width == 3000 or $width == 4000) and ($height == 3000 or $height == 4000)) {
				continue;
			}
			
			$img = Intervention\Image\Facades\Image::make($image);
			
			if($width > $height) $img->resize(4000, 3000);
			else $img->resize(3000, 4000);
			
			$img->save();
			
			$result[] = [
				'image' => $image,
				'width' => $width,
				'height' => $height
			];
		}
	}
	
	return $result;
}

function getimagesize_curl( $url ) {
	$headers = array( 'Range: bytes=0-131072' );
	
	// Get remote image
	$data = file_get_contents($url);
		
	// Process image
	$image = imagecreatefromstring( $data );
	$dims = [ imagesx( $image ), imagesy( $image ) ];
	imagedestroy($image);
	
	return $dims;
}

function getGenInfo($info, $inspection) {
	if ($info === 'date_now') {
		return date("F j, Y");
	} elseif ($info === 'company-name') {
		$client = App\Client::where('client_code', $inspection->client_id)->first();
		return htmlspecialchars($client->Company_Name);
	}
	
	return $info;
}

function getjpegsize($img_loc) {
	return getimagesize($img_loc);
	/*
    $handle = fopen($img_loc, "rb") or die("Invalid file stream.");
    $new_block = NULL;
    if(!feof($handle)) {
        $new_block = fread($handle, 32);
        $i = 0;
        if($new_block[$i]=="\xFF" && $new_block[$i+1]=="\xD8" && $new_block[$i+2]=="\xFF" && $new_block[$i+3]=="\xE0") {
            $i += 4;
            if($new_block[$i+2]=="\x4A" && $new_block[$i+3]=="\x46" && $new_block[$i+4]=="\x49" && $new_block[$i+5]=="\x46" && $new_block[$i+6]=="\x00") {
                // Read block size and skip ahead to begin cycling through blocks in search of SOF marker
                $block_size = unpack("H*", $new_block[$i] . $new_block[$i+1]);
                $block_size = hexdec($block_size[1]);
                while(!feof($handle)) {
                    $i += $block_size;
                    $new_block .= fread($handle, $block_size);
                    if($new_block[$i]=="\xFF") {
                        // New block detected, check for SOF marker
                        $sof_marker = array("\xC0", "\xC1", "\xC2", "\xC3", "\xC5", "\xC6", "\xC7", "\xC8", "\xC9", "\xCA", "\xCB", "\xCD", "\xCE", "\xCF");
                        if(in_array($new_block[$i+1], $sof_marker)) {
                            // SOF marker detected. Width and height information is contained in bytes 4-7 after this byte.
                            $size_data = $new_block[$i+2] . $new_block[$i+3] . $new_block[$i+4] . $new_block[$i+5] . $new_block[$i+6] . $new_block[$i+7] . $new_block[$i+8];
                            $unpacked = unpack("H*", $size_data);
                            $unpacked = $unpacked[1];
                            $height = hexdec($unpacked[6] . $unpacked[7] . $unpacked[8] . $unpacked[9]);
                            $width = hexdec($unpacked[10] . $unpacked[11] . $unpacked[12] . $unpacked[13]);
                            return array($width, $height);
                        } else {
                            // Skip block marker and read block size
                            $i += 2;
                            $block_size = unpack("H*", $new_block[$i] . $new_block[$i+1]);
                            $block_size = hexdec($block_size[1]);
                        }
                    } else {
                        return FALSE;
                    }
                }
            }
        }
    }
    return FALSE;
	*/
}