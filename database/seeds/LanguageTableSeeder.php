<?php

use Illuminate\Database\Seeder;
use App\Language;
class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = [["short_name"=>"AF","name"=>"Afrikanns"],
				["short_name"=>"SQ","name"=>"Albanian"],
				["short_name"=>"AR","name"=>"Arabic"],
				["short_name"=>"HY","name"=>"Armenian"],
				["short_name"=>"EU","name"=>"Basque"],
				["short_name"=>"BN","name"=>"Bengali"],
				["short_name"=>"BG","name"=>"Bulgarian"],
				["short_name"=>"CA","name"=>"Catalan"],
				["short_name"=>"KM","name"=>"Cambodian"],
				["short_name"=>"ZH","name"=>"Chinese (Mandarin)"],
				["short_name"=>"HR","name"=>"Croation"],
				["short_name"=>"CS","name"=>"Czech"],
				["short_name"=>"DA","name"=>"Danish"],
				["short_name"=>"NL","name"=>"Deutsch"],
				["short_name"=>"EN","name"=>"English"],
				["short_name"=>"ET","name"=>"Estonian"],
				["short_name"=>"FJ","name"=>"Fiji"],
				["short_name"=>"FI","name"=>"Finnish"],
				["short_name"=>"FR","name"=>"French"],
				["short_name"=>"KA","name"=>"Georgian"],
				["short_name"=>"DE","name"=>"German"],
				["short_name"=>"EL","name"=>"Greek"],
				["short_name"=>"GU","name"=>"Gujarati"],
				["short_name"=>"HE","name"=>"Hebrew"],
				["short_name"=>"HI","name"=>"Hindi"],
				["short_name"=>"HU","name"=>"Hungarian"],
				["short_name"=>"IS","name"=>"Icelandic"],
				["short_name"=>"ID","name"=>"Indonesian"],
				["short_name"=>"GA","name"=>"Irish"],
				["short_name"=>"IT","name"=>"Italian"],
				["short_name"=>"JA","name"=>"Japanese"],
				["short_name"=>"JW","name"=>"Javanese"],
				["short_name"=>"KO","name"=>"Korean"],
				["short_name"=>"LA","name"=>"Latin"],
				["short_name"=>"LV","name"=>"Latvian"],
				["short_name"=>"LT","name"=>"Lithuanian"],
				["short_name"=>"MK","name"=>"Macedonian"],
				["short_name"=>"MS","name"=>"Malay"],
				["short_name"=>"ML","name"=>"Malayalam"],
				["short_name"=>"MT","name"=>"Maltese"],
				["short_name"=>"MI","name"=>"Maori"],
				["short_name"=>"MR","name"=>"Marathi"],
				["short_name"=>"MN","name"=>"Mongolian"],
				["short_name"=>"NE","name"=>"Nepali"],
				["short_name"=>"NO","name"=>"Norwegian"],
				["short_name"=>"FA","name"=>"Persian"],
				["short_name"=>"PL","name"=>"Polish"],
				["short_name"=>"PT","name"=>"Portuguese"],
				["short_name"=>"PA","name"=>"Punjabi"],
				["short_name"=>"QU","name"=>"Quechua"],
				["short_name"=>"RO","name"=>"Romanian"],
				["short_name"=>"RU","name"=>"Russian"],
				["short_name"=>"SM","name"=>"Samoan"],
				["short_name"=>"SR","name"=>"Serbian"],
				["short_name"=>"SK","name"=>"Slovak"],
				["short_name"=>"SL","name"=>"Slovenian"],
				["short_name"=>"ES","name"=>"Spanish"],
				["short_name"=>"SW","name"=>"Swahili"],
				["short_name"=>"SV","name"=>"Swedish "],
				["short_name"=>"TA","name"=>"Tamil"],
				["short_name"=>"TT","name"=>"Tatar"],
				["short_name"=>"TE","name"=>"Telugu"],
				["short_name"=>"TH","name"=>"Thai"],
				["short_name"=>"BO","name"=>"Tibetan"],
				["short_name"=>"TO","name"=>"Tonga"],
				["short_name"=>"TR","name"=>"Turkish"],
				["short_name"=>"UK","name"=>"Ukranian"],
				["short_name"=>"UR","name"=>"Urdu"],
				["short_name"=>"UZ","name"=>"Uzbek"],
				["short_name"=>"VI","name"=>"Vietnamese"],
				["short_name"=>"CY","name"=>"Welsh"],
				["short_name"=>"XH","name"=>"Xhosa"]];

				foreach ($lang as $i => $l) {
	  				$la[$i] = new Language();
	  				$la[$i]->short_name = $l['short_name'];
	  				$la[$i]->name = $l['name'];
	  				$la[$i]->save();
				}


    }
}
