<?php

namespace App\Http\Controllers\Employee;

use App\PageMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:employee');
	}

	public function index()
	{
		return view('employee.home');
	}

	public function pageHeader(Request $request)
	{
		if(!empty($request->all())){

			$validatedData = $request->validate([
				'title' => 'required',
				'android_app_link' => 'required',
                'ios_app_link' => 'required',
                'image' => 'required_without:exist_image|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $filename = '';
			if ($file = $request->file('image')){
				$filename = time().'.'.$file->extension();
				$file->move(public_path().'/images/pagemeta/', $filename);  
			}elseif($request->has('exist_image') && $request->exist_image!=''){
				$filename = $request->exist_image;
			}

			PageMeta::updateOrCreate(
				['meta_key' => 'header_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'header_android_app_link'],
				['meta_value' => $request->android_app_link]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'header_ios_app_link'],
				['meta_value' => $request->ios_app_link]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'header_image'],
				['meta_value' => $filename]
			);

			return redirect()->route('pagemeta.header')
                        ->with('success','Header content has been saved.');
		}

		$header = PageMeta::where('meta_key', 'header_title')
			->orWhere('meta_key', 'header_android_app_link')
			->orWhere('meta_key', 'header_ios_app_link')
			->orWhere('meta_key', 'header_image')
			->pluck('meta_value', 'meta_key')->all();

		return view('employee.header', compact('header'));
	}

	public function about(Request $request)
	{
		if(!empty($request->all())){

			$validatedData = $request->validate([
				'title' => 'required',
                'description' => 'required',
                'image' => 'required_without:exist_image|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $filename = '';
			if ($file = $request->file('image')){
				$filename = time().'.'.$file->extension();
				$file->move(public_path().'/images/pagemeta/', $filename);  
			}elseif($request->has('exist_image') && $request->exist_image!=''){
				$filename = $request->exist_image;
			}

			PageMeta::updateOrCreate(
				['meta_key' => 'about_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'about_description'],
				['meta_value' => $request->description]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'about_image'],
				['meta_value' => $filename]
			);

			return redirect()->route('pagemeta.about')
                        ->with('success','About us content has been saved.');
		}

		$about = PageMeta::where('meta_key', 'about_title')
			->orWhere('meta_key', 'about_description')
			->orWhere('meta_key', 'about_image')
			->pluck('meta_value', 'meta_key')->all();

		return view('employee.about', compact('about'));
	}

	public function vendors(Request $request)
	{
		if(!empty($request->all())){

			$content = [];
            $vendors_content = $request->vendors;
            $i = 1;
            foreach ($vendors_content as $value) {
            	
            	$filename = '';
            	if(isset($value['image'])){
	            	$file = $value['image'];
					$filename = time().'-'.$i.'.'.$file->extension();
					$file->move(public_path().'/images/pagemeta/', $filename);  
            	}elseif(isset($value['exist_image'])){
            		$filename = $value['exist_image'];
            	}
            	$content[] = array(
            		'id' => $i,
            		'name' => $value['name'],
            		'image' => $filename
             	);
             	$i++;
            }

            PageMeta::updateOrCreate(
				['meta_key' => 'vendors_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'vendors_description'],
				['meta_value' => $request->description]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'vendors_content'],
				['meta_value' => json_encode($content)]
			);

			return redirect()->route('pagemeta.vendors')
                        ->with('success','Vendors has been saved.');
		}

		$vendors_title = PageMeta::select('meta_value')->where('meta_key', 'vendors_title')->first();
		$vendors_description = PageMeta::select('meta_value')->where('meta_key', 'vendors_description')->first();
		$vendors_content = PageMeta::select('meta_value')->where('meta_key', 'vendors_content')->first();
		$vendors['title'] = isset($vendors_title->meta_value) ? $vendors_title->meta_value : '';
		$vendors['description'] = isset($vendors_description->meta_value) ? $vendors_description->meta_value : '';
		$vendors['content'] = isset($vendors_content->meta_value) ? json_decode($vendors_content->meta_value) : array();
		
		return view('employee.vendors', compact('vendors'));
	}

	public function removeVendors($id)
	{
		$vendors_content = PageMeta::select('meta_value')->where('meta_key', 'vendors_content')->first();
		$content = json_decode($vendors_content->meta_value);
		
		foreach ($content as $i => $v) {
			if ($v->id == $id) {
				if($v->image!='') {
					unlink(public_path('images/pagemeta') . '/' . $v->image);
				}
				unset($content[$i]);
			}
		}
		PageMeta::where('meta_key', 'vendors_content')
            ->update(['meta_value' => json_encode($content)]);
		
        return response()->json(['status' => 200, 'msg' => 'Vendor has been deleted.']);
	}

	public function features(Request $request)
	{
		if(!empty($request->all())){

            $content = [];
            $features_content = $request->features;
            $i = 1;
            foreach ($features_content as $value) {
            	
            	$filename = '';
            	if(isset($value['image'])){
	            	$file = $value['image'];
					$filename = time().'-'.$i.'.'.$file->extension();
					$file->move(public_path().'/images/pagemeta/', $filename);  
            	}elseif(isset($value['exist_image'])){
            		$filename = $value['exist_image'];
            	}
            	$content[] = array(
            		'id' => $i,
            		'title' => $value['title'],
            		'description' => $value['description'],
            		'image' => $filename
             	);
             	$i++;
            }

            PageMeta::updateOrCreate(
				['meta_key' => 'features_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'features_content'],
				['meta_value' => json_encode($content)]
			);

			return redirect()->route('pagemeta.features')
                        ->with('success','Features has been saved.');
		}

		$features_title = PageMeta::select('meta_value')->where('meta_key', 'features_title')->first();
		$features_content = PageMeta::select('meta_value')->where('meta_key', 'features_content')->first();
		$features['title'] = isset($features_title->meta_value) ? $features_title->meta_value : '';
		$features['content'] = isset($features_content->meta_value) ? json_decode($features_content->meta_value) : array();
		
		return view('employee.features', compact('features'));
	}

	public function removeFeature($id)
	{
		$features_content = PageMeta::select('meta_value')->where('meta_key', 'features_content')->first();
		$content = json_decode($features_content->meta_value);
		
		foreach ($content as $i => $v) {
			if ($v->id == $id) {
				if($v->image!='') {
					unlink(public_path('images/pagemeta') . '/' . $v->image);
				}
				unset($content[$i]);
			}
		}
		PageMeta::where('meta_key', 'features_content')
            ->update(['meta_value' => json_encode($content)]);
		
        return response()->json(['status' => 200, 'msg' => 'Feature has been deleted.']);
	}

	public function faq(Request $request)
	{
		if(!empty($request->all())){

			$content = [];
            $faq_content = $request->faq;
            $i = 1;
            foreach ($faq_content as $value) {
            	
            	$content[] = array(
            		'id' => $i,
            		'question' => $value['question'],
            		'answer' => $value['answer'],
             	);
             	$i++;
            }

            PageMeta::updateOrCreate(
				['meta_key' => 'faq_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'faq_content'],
				['meta_value' => json_encode($content)]
			);

			return redirect()->route('pagemeta.faq')
                        ->with('success','FAQ\'s has been saved.');
		}

		$faq_title = PageMeta::select('meta_value')->where('meta_key', 'faq_title')->first();
		$faq_content = PageMeta::select('meta_value')->where('meta_key', 'faq_content')->first();
		$faq['title'] = isset($faq_title->meta_value) ? $faq_title->meta_value : '';
		$faq['content'] = isset($faq_content->meta_value) ? json_decode($faq_content->meta_value) : array();
		
		return view('employee.faq', compact('faq'));
	}

	public function removeFaq($id)
	{
		$faq_content = PageMeta::select('meta_value')->where('meta_key', 'faq_content')->first();
		$content = json_decode($faq_content->meta_value);
		
		foreach ($content as $i => $v) {
			if ($v->id == $id) {
				unset($content[$i]);
			}
		}
		PageMeta::where('meta_key', 'faq_content')
            ->update(['meta_value' => json_encode($content)]);
		
        return response()->json(['status' => 200, 'msg' => 'FAQ has been deleted.']);
	}

	public function downloads(Request $request)
	{
		if(!empty($request->all())){

			$validatedData = $request->validate([
				'title' => 'required',
                'description' => 'required',
                'android_app_link' => 'required',
                'ios_app_link' => 'required'
                //'android_app_link' => 'required|url',
                //'ios_app_link' => 'required|url'
            ]);

			PageMeta::updateOrCreate(
				['meta_key' => 'downloads_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'downloads_description'],
				['meta_value' => $request->description]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'downloads_android_app_link'],
				['meta_value' => $request->android_app_link]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'downloads_ios_app_link'],
				['meta_value' => $request->ios_app_link]
			);

			return redirect()->route('pagemeta.downloads')
                        ->with('success','Downloads content has been saved.');
		}

		$downloads = PageMeta::where('meta_key', 'downloads_title')
			->orWhere('meta_key', 'downloads_description')
			->orWhere('meta_key', 'downloads_android_app_link')
			->orWhere('meta_key', 'downloads_ios_app_link')
			->pluck('meta_value', 'meta_key')->all();

		return view('employee.downloads', compact('downloads'));
	}

	public function clientFeedback(Request $request)
	{
		if(!empty($request->all())){

			/*$validatedData = $request->validate([
				'title' => 'required',
                'image.*' => 'required_with:name.*,description.*',
                'name.*' => 'required_with:image.*,description.*',
                'description.*' => 'required_with:image.*,name.*'
            ]);*/

            //echo '<pre>';
            //print_r($request->all());
            $content = [];
            $client_feedback_content = $request->client_feedback;
            $i = 1;
            foreach ($client_feedback_content as $value) {
            	//print_r($value);
            	$filename = '';
            	if(isset($value['image'])){
	            	$file = $value['image'];
					$filename = time().'-'.$i.'.'.$file->extension();
					$file->move(public_path().'/images/pagemeta/', $filename);  
            	}elseif(isset($value['exist_image'])){
            		$filename = $value['exist_image'];
            	}
            	$content[] = array(
            		'id' => $i,
            		'name' => $value['name'],
            		'state' => $value['state'],
            		'description' => $value['description'],
            		'image' => $filename
             	);
             	$i++;
            }

            //print_r(json_encode($content)); exit();
            PageMeta::updateOrCreate(
				['meta_key' => 'client_feedback_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'client_feedback_content'],
				['meta_value' => json_encode($content)]
			);

			return redirect()->route('pagemeta.client-feedback')
                        ->with('success','Client feedback has been saved.');
		}

		$client_feedback_title = PageMeta::select('meta_value')->where('meta_key', 'client_feedback_title')->first();
		$client_feedback_content = PageMeta::select('meta_value')->where('meta_key', 'client_feedback_content')->first();
		$client_feedback['title'] = isset($client_feedback_title->meta_value) ? $client_feedback_title->meta_value : '';
		$client_feedback['content'] = isset($client_feedback_content->meta_value) ? json_decode($client_feedback_content->meta_value) : array();
		
		return view('employee.client-feedback', compact('client_feedback'));
	}

	public function removeClentFeedback($id)
	{
		$client_feedback_content = PageMeta::select('meta_value')->where('meta_key', 'client_feedback_content')->first();
		$content = json_decode($client_feedback_content->meta_value);
		
		foreach ($content as $i => $v) {
			if ($v->id == $id) {
				if($v->image!='') {
					unlink(public_path('images/pagemeta') . '/' . $v->image);
				}
				unset($content[$i]);
			}
		}
		PageMeta::where('meta_key', 'client_feedback_content')
            ->update(['meta_value' => json_encode($content)]);
		
        return response()->json(['status' => 200, 'msg' => 'Feedback has been deleted.']);
	}

	public function dmca(Request $request)
	{
		if(!empty($request->all())){

			$content = [];
            $dmca_content = $request->dmca;
            $i = 1;
            foreach ($dmca_content as $value) {
            	
            	$content[] = array(
            		'id' => $i,
            		'title' => $value['title'],
            		'description' => $value['description'],
             	);
             	$i++;
            }

            PageMeta::updateOrCreate(
				['meta_key' => 'dmca_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'dmca_description'],
				['meta_value' => $request->description]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'dmca_content'],
				['meta_value' => json_encode($content)]
			);

			return redirect()->route('pagemeta.dmca')
                        ->with('success','DMCA has been saved.');
		}

		$dmca_title = PageMeta::select('meta_value')->where('meta_key', 'dmca_title')->first();
		$dmca_description = PageMeta::select('meta_value')->where('meta_key', 'dmca_description')->first();
		$dmca_content = PageMeta::select('meta_value')->where('meta_key', 'dmca_content')->first();
		$dmca['title'] = isset($dmca_title->meta_value) ? $dmca_title->meta_value : '';
		$dmca['description'] = isset($dmca_description->meta_value) ? $dmca_description->meta_value : '';
		$dmca['content'] = isset($dmca_content->meta_value) ? json_decode($dmca_content->meta_value) : array();
		
		return view('employee.dmca', compact('dmca'));
	}

	public function removeDmca($id)
	{
		$dmca_content = PageMeta::select('meta_value')->where('meta_key', 'dmca_content')->first();
		$content = json_decode($dmca_content->meta_value);
		
		foreach ($content as $i => $v) {
			if ($v->id == $id) {
				unset($content[$i]);
			}
		}
		PageMeta::where('meta_key', 'dmca_content')
            ->update(['meta_value' => json_encode($content)]);
		
        return response()->json(['status' => 200, 'msg' => 'DMCA content has been deleted.']);
	}

	public function termsConditions(Request $request)
	{
		if(!empty($request->all())){

			$content = [];
            $terms_conditions_content = $request->terms_conditions;
            $i = 1;
            foreach ($terms_conditions_content as $value) {
            	
            	$content[] = array(
            		'id' => $i,
            		'title' => $value['title'],
            		'description' => $value['description'],
             	);
             	$i++;
            }

            PageMeta::updateOrCreate(
				['meta_key' => 'terms_conditions_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'terms_conditions_description'],
				['meta_value' => $request->description]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'terms_conditions_content'],
				['meta_value' => json_encode($content)]
			);

			return redirect()->route('pagemeta.terms-conditions')
                        ->with('success','Terms & Conditions has been saved.');
		}

		$terms_conditions_title = PageMeta::select('meta_value')->where('meta_key', 'terms_conditions_title')->first();
		$terms_conditions_description = PageMeta::select('meta_value')->where('meta_key', 'terms_conditions_description')->first();
		$terms_conditions_content = PageMeta::select('meta_value')->where('meta_key', 'terms_conditions_content')->first();
		$terms_conditions['title'] = isset($terms_conditions_title->meta_value) ? $terms_conditions_title->meta_value : '';
		$terms_conditions['description'] = isset($terms_conditions_description->meta_value) ? $terms_conditions_description->meta_value : '';
		$terms_conditions['content'] = isset($terms_conditions_content->meta_value) ? json_decode($terms_conditions_content->meta_value) : array();
		
		return view('employee.terms-conditions', compact('terms_conditions'));
	}

	public function removeTermsConditions($id)
	{
		$terms_conditions_content = PageMeta::select('meta_value')->where('meta_key', 'terms_conditions_content')->first();
		$content = json_decode($terms_conditions_content->meta_value);
		
		foreach ($content as $i => $v) {
			if ($v->id == $id) {
				unset($content[$i]);
			}
		}
		PageMeta::where('meta_key', 'terms_conditions_content')
            ->update(['meta_value' => json_encode($content)]);
		
        return response()->json(['status' => 200, 'msg' => 'Terms & Conditions has been deleted.']);
	}

	public function privacyPolicy(Request $request)
	{
		if(!empty($request->all())){

			$content = [];
            $privacy_policy_content = $request->privacy_policy;
            $i = 1;
            foreach ($privacy_policy_content as $value) {
            	
            	$content[] = array(
            		'id' => $i,
            		'title' => $value['title'],
            		'description' => $value['description'],
             	);
             	$i++;
            }

            PageMeta::updateOrCreate(
				['meta_key' => 'privacy_policy_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'privacy_policy_description'],
				['meta_value' => $request->description]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'privacy_policy_content'],
				['meta_value' => json_encode($content)]
			);

			return redirect()->route('pagemeta.privacy-policy')
                        ->with('success','Privacy policy has been saved.');
		}

		$privacy_policy_title = PageMeta::select('meta_value')->where('meta_key', 'privacy_policy_title')->first();
		$privacy_policy_description = PageMeta::select('meta_value')->where('meta_key', 'privacy_policy_description')->first();
		$privacy_policy_content = PageMeta::select('meta_value')->where('meta_key', 'privacy_policy_content')->first();
		$privacy_policy['title'] = isset($privacy_policy_title->meta_value) ? $privacy_policy_title->meta_value : '';
		$privacy_policy['description'] = isset($privacy_policy_description->meta_value) ? $privacy_policy_description->meta_value : '';
		$privacy_policy['content'] = isset($privacy_policy_content->meta_value) ? json_decode($privacy_policy_content->meta_value) : array();
		
		return view('employee.privacy-policy', compact('privacy_policy'));
	}

	public function removePrivacyPolicy($id)
	{
		$privacy_policy_content = PageMeta::select('meta_value')->where('meta_key', 'privacy_policy_content')->first();
		$content = json_decode($privacy_policy_content->meta_value);
		
		foreach ($content as $i => $v) {
			if ($v->id == $id) {
				unset($content[$i]);
			}
		}
		PageMeta::where('meta_key', 'privacy_policy_content')
            ->update(['meta_value' => json_encode($content)]);
		
        return response()->json(['status' => 200, 'msg' => 'Privacy policy has been deleted.']);
	}

	public function pageFooter(Request $request)
	{
		if(!empty($request->all())){

			$validatedData = $request->validate([
				'title' => 'required',
				'description' => 'required',
				'facebook_link' => 'required|url',
                'twitter_link' => 'required|url',
                'linkedin_link' => 'required|url',
                'instagram_link' => 'required|url'
            ]);

            PageMeta::updateOrCreate(
				['meta_key' => 'footer_title'],
				['meta_value' => $request->title]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'footer_description'],
				['meta_value' => $request->description]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'footer_facebook_link'],
				['meta_value' => $request->facebook_link]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'footer_twitter_link'],
				['meta_value' => $request->twitter_link]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'footer_linkedin_link'],
				['meta_value' => $request->linkedin_link]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'footer_instagram_link'],
				['meta_value' => $request->instagram_link]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'footer_pinterest_link'],
				['meta_value' => $request->pinterest_link]
			);

			PageMeta::updateOrCreate(
				['meta_key' => 'footer_tiktok_link'],
				['meta_value' => $request->tiktok_link]
			);

			return redirect()->route('pagemeta.footer')
                        ->with('success','Footer content has been saved.');
		}

		$footer = PageMeta::where('meta_key', 'footer_title')
			->orWhere('meta_key', 'footer_description')
			->orWhere('meta_key', 'footer_facebook_link')
			->orWhere('meta_key', 'footer_twitter_link')
			->orWhere('meta_key', 'footer_linkedin_link')
			->orWhere('meta_key', 'footer_instagram_link')
			->orWhere('meta_key', 'footer_pinterest_link')
			->orWhere('meta_key', 'footer_tiktok_link')
			->pluck('meta_value', 'meta_key')->all();

		return view('employee.footer', compact('footer'));
	}
}
