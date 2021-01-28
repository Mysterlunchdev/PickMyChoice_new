<?php

namespace App\Helpers;
use Mail;
use DB;

class LayoutHelper
{
    public static function load_menus(string $string)
    {
       $html ='';
       $mainmenu = DB::table('module')->where('status','Active')->orderBy('priority','ASC')->get();
       if($mainmenu->count()>0)
       {
         foreach($mainmenu as $menu)
         {
            $html .='<li class="active">
                        <a href="javascript:void[0]">
                        <i class='.$menu->icon.'></i>
                        <span class="title">'.$menu->name.'</span></a>';
            $submenu = DB::table('pages')->where('status','Active')->where('module_id',$menu->id)->orderBy('priority','ASC')->get();
            if($submenu->count()>0)
            {
                $html .='<ul>';
                foreach($submenu as $smenu)
                {
                    $html .='<li>
                                <a href="'.url('/default/'.base64_encode($smenu->script_name)).'">
                                    <span class="title">'.str_replace('_', ' ', ucfirst($smenu->name)).'</span>
                                </a>
                            </li>';
                }
                $html .='</ul>';
            }
            $html .='</li>';
         }
       }
       return $html;
    }


    

    public static function addmenu(string $string)
    {
       $respo ='';
       $mainmenu = DB::table('menu')->where('status','Active')->where('parent_id',0)->get();
       $respo .='<ul id="tree" style="height: 150px;overflow: auto;margin-left: 100px;">';
       if($mainmenu->count()>0)
       {
        foreach($mainmenu as $menu)
        {
           $respo .='<li class=""> <a href="javascript:void[0]">'.$menu->name.'</a>';
           $submenu = DB::table('menu')->where('status','Active')->where('parent_id',$menu->id)->where('status','Active')->where('parent_id','!=',0)->get();
           if($submenu->count()>0)
           {
            $respo .='<ul>';
            foreach($submenu as $smenu)
            {
                $respo .='<li class=""> <a href="javascript:void[0]">'.$smenu->name.'</a>';

                $subsubmenu = DB::table('menu')->where('status','Active')->where('parent_id',$smenu->id)->where('status','Active')->where('parent_id','!=',0)->get();
                if($subsubmenu->count()>0)
                {
                    $respo .='<ul>';
                    foreach($subsubmenu as $ssmenu)
                    {
                        $respo .='<li class=""> <a href="javascript:void[0]">'.$ssmenu->name.'</a>';
                    }
                    $respo .='</ul>';
                }
            }
            $respo .='</ul>';
           }
           $respo .='</li>';
        }
       }
       $respo .='</ul>';

       return $respo;
       
    }

    public static function sizeFilter( $bytes )
    {
        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
        return( round( $bytes, 2 ) . " " . $label[$i] );
    }

    public static function userdata(string $string)
    {
        if(isset(session()->get('userdata')[0]->id) && !empty(session()->get('userdata')[0]->id))
        {
            $userdata = DB::table('user')->where('id',session()->get('userdata')[0]->id)->get();
            if($userdata->count()>0)
            {
                return $userdata;
            }
        }
        
    }


    public static function status($bytes)
    {
      $status = DB::table('header')->where('id',1)->get();
      return $status;
    }
    
    public static function fetch_task_status($task_id)
    {
      $data = DB::table('task_status')->select('status')->where('task_id',$task_id)->orderBy('log_date_created','DESC')->limit(1)->get();
      return $data;
    }

    public static function fetch_task_quote_status($task_id)
    {
      $data = DB::table('task_quote')->select('status')->where('task_id',$task_id)->orderBy('log_date_created','DESC')->limit(1)->get();
      return $data;
    }

     public static function fetch_quote_history($task_id)
    {
      $data = DB::table('task_status')->where('task_id',$task_id)->orderBy('log_date_created','ASC')->get();
      return $data;
    }
}