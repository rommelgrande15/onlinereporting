<?php

use Illuminate\Database\Seeder;
use App\Page;
class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = array(
  array('id' => '1','name' => 'Home','description' => 'home page','slug' => '','created_at' => '2017-07-18 05:53:07','updated_at' => '2017-07-18 05:53:07'),
  array('id' => '2','name' => 'About','description' => 'about page','slug' => 'about','created_at' => '2017-07-18 05:53:17','updated_at' => '2017-07-18 05:53:17'),
  array('id' => '3','name' => 'Quality Standard','description' => 'our quality standard','slug' => 'our quality standard','created_at' => '2017-07-18 05:59:57','updated_at' => '2017-07-18 05:59:57'),
  array('id' => '4','name' => 'Locations','description' => 'our locations','slug' => 'locations','created_at' => '2017-07-18 06:00:18','updated_at' => '2017-07-18 06:00:18'),
  array('id' => '5','name' => 'Testimonials','description' => 'testimonials','slug' => 'testimonials','created_at' => '2017-07-18 06:00:29','updated_at' => '2017-07-18 06:00:29'),
  array('id' => '6','name' => 'Terms and Conditions','description' => 'terms and conditions page','slug' => 'terms-and-conditions','created_at' => '2017-07-18 06:00:44','updated_at' => '2017-07-18 06:00:44'),
  array('id' => '7','name' => 'Frequently Asked Questions','description' => 'frequently asked questions','slug' => 'faqs','created_at' => '2017-07-18 06:00:59','updated_at' => '2017-07-18 06:00:59'),
  array('id' => '8','name' => 'Inspection Services','description' => 'inspection services','slug' => 'inspection-services','created_at' => '2017-07-18 06:01:15','updated_at' => '2017-07-18 06:01:15'),
  array('id' => '9','name' => 'Incoming Quality Inspection','description' => 'incoming quality inspection','slug' => 'incoming-quality-inspection','created_at' => '2017-07-18 06:01:29','updated_at' => '2017-07-18 06:01:29'),
  array('id' => '10','name' => 'During Production Inspection','description' => 'dupro page','slug' => 'dupro','created_at' => '2017-07-18 06:01:45','updated_at' => '2017-07-18 06:01:45'),
  array('id' => '11','name' => 'Pre Shipment Inspection','description' => 'PSI page','slug' => 'pre-shipment-inspection','created_at' => '2017-07-18 06:02:04','updated_at' => '2017-07-18 06:02:04'),
  array('id' => '12','name' => 'Container Loading','description' => 'container loading','slug' => 'container-loading','created_at' => '2017-07-18 06:02:18','updated_at' => '2017-07-18 06:02:18'),
  array('id' => '13','name' => 'Setting up production lines','description' => 'Setting up production lines page','slug' => 'production-lines','created_at' => '2017-07-18 06:02:42','updated_at' => '2017-07-18 06:02:42'),
  array('id' => '14','name' => 'Audit Services','description' => 'our audit services page','slug' => 'audit-services','created_at' => '2017-07-18 06:02:54','updated_at' => '2017-07-18 06:02:54'),
  array('id' => '15','name' => 'Physical Audit','description' => 'physical audit page','slug' => 'physical-audit','created_at' => '2017-07-18 06:03:05','updated_at' => '2017-07-18 06:03:05'),
  array('id' => '16','name' => 'Detailed Company Audit','description' => 'detailed company audit page','slug' => 'detailed-audit','created_at' => '2017-07-18 06:03:19','updated_at' => '2017-07-18 06:03:19'),
  array('id' => '17','name' => 'Social Audit','description' => 'social audit page','slug' => 'social-audit','created_at' => '2017-07-18 06:03:31','updated_at' => '2017-07-18 06:03:31'),
  array('id' => '18','name' => 'Contact','description' => 'contact page','slug' => 'contact','created_at' => '2017-07-18 06:04:05','updated_at' => '2017-07-18 06:04:05'));

	  	foreach ($pages as $i => $page) {
	    	$p[$i] = new Page();
	        $p[$i]->name = $page['name'];
	        $p[$i]->description = $page['description'];
	        $p[$i]->slug = $page['slug'];
	        $p[$i]->save();
	    }
    }

}
