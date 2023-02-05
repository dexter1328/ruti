<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\Menu;
use App\Page;
use Auth;

class MenuController extends Controller
{
    use Permission;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if(!$this->hasPermission(Auth::user())){
                return redirect('admin/home');
            }
            return $next($request);
        });
    }
    
    public function index()
    {
        $pages = Page::all();
        return view('admin/menu/index',compact('pages'));
    }

    public function getMenus($position)
    {
        $menu_list = Menu::where('position', $position)->orderBy('sort')->get()->toArray();
        $ref   = [];
        $items = [];
        if(!empty($menu_list)){
            foreach ($menu_list as $key => $value) {
                
                $thisRef = &$ref[$value['id']];
                $thisRef['parent'] = $value['parent'];
                $thisRef['label'] = $value['label'];
                $thisRef['id'] = $value['id'];
                if($value['parent'] == 0) {
                    $items[$value['id']] = &$thisRef;
                } else {
                    $ref[$value['parent']]['child'][$value['id']] = &$thisRef;
                }
            }
        }
        $menus = $this->getHierarchy($items);
        return $menus;
    }

    public function getHierarchy($items)
    {
        $str = '<ol class="dd-list" id="list-items">';
        foreach($items as $key=>$value) {
            $str .= '<li class="dd-item dd3-item" data-id="'.$value['id'].'" >';
                $str .= '<div class="dd-handle"><i class="fa fa-bars" aria-hidden="true"></i></div>';
                $str .= '<div class="dd3-content">'.$value['label'];
                    $str .= '<span class="span-right">';
                        $str .= '<a class="del-button" onclick="deleteMenu('.$value['id'].')" style="float:right;"><i class="fa fa-trash"></i></a>';
                    $str .= '</span>';
                $str .= '</div>';
                if(array_key_exists('child',$value)) {
                    $str .= $this->getHierarchy($value['child']);
                }
            $str .= '</li>';
        }
        $str .= '</ol>';
        return $str;
    }

    public function parseJsonArray($jsonArray, $parentID = 0) {

        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray->children)) {
                $returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
            }

            $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }
        return $return;
    }

    public function addHierarchy($menus)
    {
        $str = '';
        foreach ($menus as $key => $value) {
            $str .= '<li class="dd-item dd3-item" data-id="'.$value['id'].'" >';
                $str .= '<div class="dd-handle"><i class="fa fa-bars" aria-hidden="true"></i></div>';
                $str .= '<div class="dd3-content">'.$value['label'];;
                    $str .= '<span class="span-right">';
                        $str .= '<a class="del-button" onclick="deleteMenu('.$value['id'].')" style="float:right;"><i class="fa fa-trash"></i></a>';
                    $str .= '</span>';
                $str .= '</div>';
            $str .= '</li>';
        }
        return $str;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //print_r($request->all());exit();
        $menus = array();
        if($request->type == 'page'){

            foreach ($request->page_slug as $key => $value) {

                $menu = new Menu;
                $menu->label = $request->page_title[$key];
                $menu->link = $value;
                $menu->type = $request->type;
                $menu->target = '_self';
                $menu->position = $request->position;
                $menu->parent = 0;
                $menu->sort = 0;
                $menu->created_by = Auth::user()->id;
                $menu->updated_by = Auth::user()->id;
                $menu->save();
                $menus[] = $menu;
            }
            $menus = $this->addHierarchy($menus); 
        }else if($request->type == 'custom'){ 

            $menu = new Menu;
            $menu->label = $request->custom_title;
            $menu->link = $request->custom_link;
            $menu->type = $request->type;
            $menu->target = ($request->has('custom_target') ? $request->custom_target : '_self');
            $menu->position = $request->position;
            $menu->parent = 0;
            $menu->sort = 0;
            $menu->created_by = Auth::user()->id;
            $menu->updated_by = Auth::user()->id;
            $menu->save();
            $menus[] = $menu;
            $menus = $this->addHierarchy($menus);
        }else{

            $data = json_decode($request->get('data'));
            $readbleArray = $this->parseJsonArray($data);
            $i=0;
            foreach ($readbleArray as $row) {

                $i++;
                $menu = Menu::findOrFail($row['id']);
                $menu->parent = $row['parentID'];
                $menu->sort = $i;
                $menu->save();
            }
        }
        
        return response()->json(array('menu'=>$menus));
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Menu  $menu
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->json($menu);
    }
}
