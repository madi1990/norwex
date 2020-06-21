<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    private $page;
    private $pages = array(
      
    );

    public function home(){
      return view('home');
    }
    
    public function display(Request $request, $page = ''){
        if(empty($page)) return $this->home();
        $this->page = $page;
        // Check if page exists or throw a 404
		    if(!in_array($this->page, $this->pages)){
			    return $this->notFound($request);
        }
        return view('pages.'. $this->page);
    }

    public function notFound(Request $request){
      $data['errorMessage'] = "Sorry, the page you're looking for can't be found.";
      $data['pageTitle'] = '404';
      return view('errors.404')->with(array('data' => $data));
	}
}
