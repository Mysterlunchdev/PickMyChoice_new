<?php
namespace App\Http\Controllers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use View;


class HomeController extends Controller
{
    public function __construct()
    {
        
    }

    public function index(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }
        
        $customerdata1 = DB::table('user')->where('department_id','4')->get();
        $customerdata2 = DB::table('user')->where('department_id','3')->get();
        $taskdata1 = DB::table('task')->get();
        $completedtasksdata1 = DB::table('task_status')->where('task_status.status','Completed')->get();
        $acceptedtasksdata1 = DB::table('task_status')->where('task_status.status','Accepted')->get();
        $pendingtasksdata1 = DB::table('task_status')->where('task_status.status','Pending')->get();
        $startedtasksdata1 = DB::table('task_status')->where('task_status.status','Started')->get();
        $rejectedtasksdata1 = DB::table('task_status')->where('task_status.status','Rejected')->get();
        $paidtasksdata1 = DB::table('task_status')->where('task_status.status','Paid')->get();
       
			return view('index')->with('customerdata1',$customerdata1)->with('customerdata2',$customerdata2)->with('taskdata1',$taskdata1)->with('completedtasksdata1',$completedtasksdata1)->with('acceptedtasksdata1',$acceptedtasksdata1)->with('pendingtasksdata1',$pendingtasksdata1)->with('startedtasksdata1',$startedtasksdata1)->with('rejectedtasksdata1',$rejectedtasksdata1)->with('paidtasksdata1',$paidtasksdata1);
    }

    public function default(Request $request)
    {
        $loginStatus = $request->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }
        
        $data = $request->data;
        if (base64_encode(base64_decode($data, true)) === $data)
        {
            $page_id = DB::table('pages')->where('script_name',base64_decode($request->data))->get();
            if($page_id->count()>0)
            {
                $page_access = DB::table('access_management')->where('pages_id',$page_id[0]->id)->where('user_id',$request->session()->get('userdata')[0]->id)->get();
                if($page_access->count()>0)
                {
                    $page_access = $page_access;
                }
                else
                {
                    $page_access = array();
                }
            }
            else
            {
                return view('errors/404');
            }
			
			
			
			   if(base64_decode($request->data)=='category')
            {
				$categorydata = DB::table(base64_decode($request->data))->get();
				 return view('Category.category')->with('categorydata',$categorydata)->with('page_access',$page_access);
                
            }
			
			 elseif(base64_decode($request->data)=='subcategory')
            {
				$subcategorydata = DB::table(base64_decode($request->data))->select('category.name as cat_name',base64_decode($request->data).'.*')->leftJoin('category','category.id','=',base64_decode($request->data).'.category_id')->get();
				 return view('Subcategory.subcategory')->with('subcategorydata',$subcategorydata)->with('page_access',$page_access);
                
            }
			
			   elseif(base64_decode($request->data)=='banner')
            {
				$bannerdata = DB::table(base64_decode($request->data))->get();
				 return view('Banners.banner')->with('bannerdata',$bannerdata)->with('page_access',$page_access);
                
            }
			
			 if(base64_decode($request->data)=='emailsettings')
            {
				$email_settingsdata = DB::table(base64_decode($request->data))->get();
				 return view('Emailsettings.emailsettings')->with('email_settingsdata',$email_settingsdata)->with('page_access',$page_access);
            }
			
			 if(base64_decode($request->data)=='smssettings')
            {
				$sms_settingsdata = DB::table(base64_decode($request->data))->get();
				 return view('Smssettings.smssettings')->with('sms_settingsdata',$sms_settingsdata)->with('page_access',$page_access);
            }


               elseif(base64_decode($request->data)=='blog')
            {
                $blog = DB::table(base64_decode($request->data))->get();
                return view('Blog.blog')->with('blog',$blog)->with('page_access',$page_access);
            }
			
			    elseif(base64_decode($request->data)=='blog_category')
            {
                $blog_category = DB::table(base64_decode($request->data))->get();
                return view('Blog_category.blog_category')->with('blog_category',$blog_category)->with('page_access',$page_access);
            }
            
              elseif(base64_decode($request->data)=='blog_comments')
            {
                $blog_comments = DB::table('blog_comments')->select('blog_comments.*','blog_comments.id as b_id','blog.*','user.*','blog_comments.status as b_status')->leftJoin('blog','blog.id','=','blog_comments.blog_id')
                                                                         ->leftJoin('user','user.id','=','blog_comments.user_id')
                                                                         ->get();
                                                                         
                return view('Blog_comment.blogcomment')->with('blog_comments',$blog_comments)->with('page_access',$page_access);
            }
         
			
			   elseif(base64_decode($request->data)=='testimonial')
            {
                $testimonial = DB::table(base64_decode($request->data))->get();
                return view('Testimonial.testimonial')->with('testimonial',$testimonial)->with('page_access',$page_access);
            }
			 elseif(base64_decode($request->data)=='user')
            {
                $userdata = DB::table(base64_decode($request->data))->where('department_id','2')->get();
                return view('User.user')->with('userdata',$userdata)->with('page_access',$page_access);
            }
			
			elseif(base64_decode($request->data)=='customer')
            {
                $customerdata = DB::table('user')->where('department_id','4')->get();
				//print_r($customerdata);exit;
                return view('Customer.customer')->with('customerdata',$customerdata)->with('page_access',$page_access);
            }
			
				elseif(base64_decode($request->data)=='vendor')
            {
                $vendordata = DB::table('user')->where('department_id','3')->get();
                $vendordata1 = DB::table('task')->select('category.name as cat_name')
                                                ->leftJoin('category','category.id','=','task.category_id')
                                                ->get();
                return view('Vendor.vendor')->with('vendordata',$vendordata)->with('vendordata1',$vendordata1)->with('page_access',$page_access);
            }
			
			elseif(base64_decode($request->data)=='task')
            {
            $taskdata = DB::table(base64_decode($request->data))->select('user.name as user_name','task.*','category.name as cat_name','subcategory.name as sub_cat_name')
                                                                ->leftJoin('user','user.id','=','task.user_id')
				                                                ->leftJoin('category','category.id','=','task.category_id')
											                    ->leftJoin('subcategory','subcategory.id','=','task.sub_category_id')
											                    ->get();
											 
                return view('Task.task')->with('taskdata',$taskdata)->with('page_access',$page_access);
				
            }
			
			elseif(base64_decode($request->data)=='completedtasks')
            {
                $completedtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')->leftJoin('user','user.id','=','task_status.user_id')->where('task_status.status','Completed')->get();
		                   
				 //print_r($completedtasksdata);exit;                     
                return view('Task.completedtasks')->with('completedtasksdata',$completedtasksdata)->with('page_access',$page_access);
				
            }
			
			//->select('task_quote.*','task.id as taskid','task_quote.*','user.name as username')
			
			elseif(base64_decode($request->data)=='inprocesstasks')
            {
     $inprocesstasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')->leftJoin('user','user.id','=','task_status.user_id')->where('task_status.status','Inprocess')->get();
				                      
                return view('Task.inprocesstasks')->with('inprocesstasksdata',$inprocesstasksdata)->with('page_access',$page_access);
				
            }
			
			elseif(base64_decode($request->data)=='acceptedtasks')
            {
          $acceptedtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')->leftJoin('user','user.id','=','task_status.user_id')->where('task_status.status','Accepted')->get();
                return view('Task.acceptedtasks')->with('acceptedtasksdata',$acceptedtasksdata)->with('page_access',$page_access);
                //print_r($acceptedtasksdata);exit;
				
            }
			
		elseif(base64_decode($request->data)=='paidtasks')
            {
          $paidtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')->leftJoin('user','user.id','=','task_status.user_id')->where('task_status.status','Paid')->get();
											
                return view('Task.paidtasks')->with('paidtasksdata',$paidtasksdata)->with('page_access',$page_access);
				
            }
            
          
            elseif(base64_decode($request->data)=='pendingtasks')
            {
          $pendingtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')->leftJoin('user','user.id','=','task_status.user_id')->where('task_status.status','Pending')->get();
				//print_r($pendingtasksdata);exit;							
                return view('Task.pendingtasks')->with('pendingtasksdata',$pendingtasksdata)->with('page_access',$page_access);
				
            }
            
             elseif(base64_decode($request->data)=='startedtasks')
            {
          $startedtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')->leftJoin('user','user.id','=','task_status.user_id')->where('task_status.status','Started')->get();
											
                return view('Task.startedtasks')->with('startedtasksdata',$startedtasksdata)->with('page_access',$page_access);
				
            }
            
        
				 	elseif(base64_decode($request->data)=='paymentreports')
            {
                $paymentreportsdata = DB::table('task_payment')->leftJoin('task','task.id','=','task_payment.task_id')
                                                               ->leftJoin('user','user.id','=','task_payment.user_id')
                                                               ->get();
                 
				//print_r($customerdata);exit;
                return view('Reports.paymentreports')->with('paymentreportsdata',$paymentreportsdata)->with('page_access',$page_access);
            }
			
				elseif(base64_decode($request->data)=='settlementreports')
            {
                $settlementreportsdata = DB::table('settlement')->leftJoin('user','user.id','=','settlement.user_id')->where('department_id','3')
                                                                 ->get();
                 
                return view('Reports.settlementreports')->with('settlementreportsdata',$settlementreportsdata)->with('page_access',$page_access);
            }
            
            elseif(base64_decode($request->data)=='refundrequestreports')
            {
                $refundrequestreportsdata = DB::table('refund_request')->select('refund_request.*','refund_request.id as ref_id','user.*','task.*')->leftJoin('user','user.id','=','refund_request.user_id')
                                                                       ->leftJoin('task','task.id','=','refund_request.task_id')
                                                                       ->get();
                         // print_r($refundrequestreportsdata);exit;                                             
                 
                return view('Reports.refundrequestreports')->with('refundrequestreportsdata',$refundrequestreportsdata)->with('page_access',$page_access);
            }
			
			
        } 
        else
        {
            return view('errors/404');
        }

    }


    //////////////////////////video gallery///////////////////////////////////

    public function changestatus(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }
        elseif($req->input('t')=='d')
        {
            $table = 'department';
        }
        elseif($req->input('t')=='b')
        {
            $table = 'banner';
        }
        elseif($req->input('t')=='u')
        {
            $table = 'user';
        }
        elseif($req->input('t')=="sm")
        {
            $table ='side_menus';
        }
        elseif($req->input('t')=="cat")
        {
            $table ='category';
        }
		
		 elseif($req->input('t')=="subcat")
        {
            $table ='subcategory';
        }
		
		 elseif($req->input('t')=="blog")
        {
            $table ='blog';
        }
		 elseif($req->input('t')=="blg_cat")
        {
            $table ='blog_category';
        }
        elseif($req->input('t')=="blg_com")
        {
            $table ='blog_comments';
        }
		 elseif($req->input('t')=="email")
        {
            $table ='smailsettings';
        }
		
		 elseif($req->input('t')=="sms")
        {
            $table ='smssettings';
        }
		 elseif($req->input('t')=="testi")
        {
            $table ='testimonial';
        }
		
      
		
        if($req->input('ai')!="" && $req->input('s')!="")
        {
            if($req->input('s')=='I')
            {
                $us = array('status'=>'Inactive');
            }
            else
            {
              $us = array('status'=>'Active');
            }
          $status = DB::table($table)->where('id',$req->input('ai'))->update($us);
          if($status){ echo 'Status Changed Successfully'; }else{ echo 0; }
        }
        elseif($req->input('ai')!="")
        {
           $selectfile = DB::table($table)->where('id',$req->input('ai'))->get();
           if($selectfile->count()>0)
           {
            foreach($selectfile as $file)
            {
                if(isset($file->attachment) && !empty($file->attachment))
                {
                    unlink('assets/portal/'.$table.'/'.$file->attachment);
                }
            }
           }
            
           $dstatus = DB::table($table)->where('id',$req->input('ai'))->delete();
           if($dstatus){ echo 'Record Deleted Successfully'; }else{ echo 0; }
        }
    }
	
	
	////////////////////////// start category///////////////////////////////////

public function addcategory(Request $req)
    {
		$_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
			{
         $postdata['name'] = $_POST['name'];
		 $postdata['description'] = $_POST['description'];
		 $postdata['meta_title'] = $_POST['meta_title'];
		 $postdata['meta_description'] = $_POST['meta_description'];
		 $postdata['meta_keywords'] = $_POST['meta_keywords'];
		 
		   if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
            {
                $name = $_FILES['attachment']['name'];
                $size = $_FILES['attachment']['size'];
                $file_type = $_FILES['attachment']['type'];
                $tmp_name = $_FILES['attachment']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                    $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/category/'.$file_name))
                    {
                        $postdata['attachment'] = $file_name;
                    }
                }
                else
                {
                    session()->put('err','Please select only Image format file');
                    return view('Category.add_category');
                }
            }
		 
		  $insertstatus = DB::table('category')->insert($postdata);
                        if($insertstatus)
                        {
                            session()->put('msg','Record Created Successfully');
                            return view('Category.add_category');
                        }
						
		}
       return view('Category.add_category');
      }


 public function editcategory(Request $req)
    {
       {
            if(!empty(base64_decode($req->data)))
        {
            $fetchcategorydata = DB::table('category')->where('id',base64_decode($req->data))->get();
            return view('Category.edit_category')->with('categorydata',$fetchcategorydata);
        }
        }
	  
      }
 
   public function updatecategory(Request $req)
    {
     $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
			
        {  
         $postdata['name'] = $_POST['name'];
		 $postdata['description'] = $_POST['description'];
		 $postdata['meta_title'] = $_POST['meta_title'];
		 $postdata['meta_description'] = $_POST['meta_description'];
		 $postdata['meta_keywords'] = $_POST['meta_keywords'];
		 
		 
		 
		   if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
            {
                $name = $_FILES['attachment']['name'];
                $size = $_FILES['attachment']['size'];
                $file_type = $_FILES['attachment']['type'];
                $tmp_name = $_FILES['attachment']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                    $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/category/'.$file_name))
                    {
                        $postdata['attachment'] = $file_name;
                    }
                }
                else
                {
                    session()->put('err','Please select only Image format file');
                    return view('Category.add_category');
                }
            }
		 
         $updatestatus = DB::table('category')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)
            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
		}
   
       return view('Category.category');
    }
////////////////////////////////end category///////////////////////////////////

////////////////////////// start subcategory///////////////////////////////////


public function addsubcategory(Request $req)
    {
		
      $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))

			{
							
		 $postdata['category_id'] =$_POST['category_id'];
         $postdata['name'] = $_POST['name'];
		 $postdata['description'] = $_POST['description'];
		 $postdata['instruction'] = $_POST['instruction'];
		 $postdata['meta_title'] = $_POST['meta_title'];
		 $postdata['meta_description'] = $_POST['meta_description'];
		 $postdata['meta_keywords'] = $_POST['meta_keywords'];
		 
     
	 if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
		
            {
				$name = $_FILES['attachment']['name'];
                $size = $_FILES['attachment']['size'];
                $file_type = $_FILES['attachment']['type'];
                $tmp_name = $_FILES['attachment']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                   $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/subcategory/'.$file_name))
                    {
                      $postdata['attachment'] = $file_name;
                    }
                }
                else
                {
                    session()->put('err','Please select image format file');
                    return view('Subcategory.add_subcategory');
                }
            }
            
            
           if(isset($_FILES['attachment2']) && !empty($_FILES['attachment2']['name']))
            {
                $name = $_FILES['attachment2']['name'];
                $size = $_FILES['attachment2']['size'];
                $file_type = $_FILES['attachment2']['type'];
                $tmp_name = $_FILES['attachment2']['tmp_name'];

                    $file_name2 = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/subcategory/'.$file_name2))
                    {
                        $postdata['big_image'] = $file_name2;
                        
                    }
            }
                 $insertstatus = DB::table('subcategory')->insert($postdata);
            
                        if($insertstatus)
                        {
                            session()->put('msg','Record Created Successfully');
                            return redirect()->back();
                        }
						
		}
		  $categorydata = DB::table('category')->get();
       return view('Subcategory.add_subcategory')->with('category',$categorydata);
      }


 public function editsubcategory(Request $req)
    
       {
            if(!empty(base64_decode($req->data)))
        {
            $fetchsubcategorydata = DB::table('subcategory')->where('id',base64_decode($req->data))->get();
			$cat = DB::table('category')->get();
			
            return view('Subcategory.edit_subcategory')->with('subcategorydata',$fetchsubcategorydata)->with('category',$cat);
        }
        }
	  
      
public function updatesubcategory(Request $req)
    {
     
        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
			
        {
         $postdata['category_id'] = $_POST['category_id'];	
         $postdata['name'] = $_POST['name'];
         $postdata['description'] = $_POST['description'];
		 $postdata['instruction'] = $_POST['instruction'];
		 $postdata['meta_title'] = $_POST['meta_title'];
		 $postdata['meta_description'] = $_POST['meta_description'];
		 $postdata['meta_keywords'] = $_POST['meta_keywords'];
		 
		 
        if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
            {
                $name = $_FILES['attachment']['name'];
                $size = $_FILES['attachment']['size'];
                $file_type = $_FILES['attachment']['type'];
                $tmp_name = $_FILES['attachment']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                    $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/subcategory/'.$file_name))
                    {
                        $postdata['attachment'] = $file_name;
                    }
                }
                else
                {
                   session()->put('err','Please select image format file');
                   return redirect()->back();
                }
            }
            
		 if(isset($_FILES['attachment2']) && !empty($_FILES['attachment2']['name']))
            {
                $name = $_FILES['attachment2']['name'];
                $size = $_FILES['attachment2']['size'];
                $file_type = $_FILES['attachment2']['type'];
                $tmp_name = $_FILES['attachment2']['tmp_name'];

                    $file_name2 = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/subcategory/'.$file_name2))
                    {
                        $postdata['big_image'] = $file_name2;
                        
                    }
            }


            $updatestatus = DB::table('subcategory')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)

            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
		}
		$subcategorydata = DB::table('subcategory')->get();
		 
		 return view('Subcategory.subcategory')->with('subcategory',$subcategorydata);
    } 

/////////////////////////end subcategory////////////////////////////////////////	


//////////////////////////////add blog category////////////////////////////////	
	  public function addblog_category(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();

        if(isset($_POST) && !empty($_POST))
        {
            $postdata['name'] = $_POST['name'];
			$postdata['log_date_created'] = date('Y-m-d h:i:s');
         

            $insertstatus = DB::table('blog_category')->insert($postdata);
            
           if($insertstatus)
           {
            session()->put('msg','Record Created Successfully');
            return redirect()->back();
           }
           
        }
        return view('Blog_category.add_blog_category');
    }
     public function editblog_category(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        if(!empty(base64_decode($req->data)))
        {
            $blog_category = DB::table('blog_category')->where('id',base64_decode($req->data))->get();
            return view('Blog_category.edit_blog_category')->with('blog_categorydata',$blog_category);
        }
    }
    public function updateblog_category(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }
        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
             $postdata['name'] = $_POST['name'];
			$postdata['log_date_created'] = date('Y-m-d h:i:s');

            $updatestatus = DB::table('blog_category')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)
            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
        }

        return redirect()->back();
    }
//////////////////////////end blogcategory////////////////////////////////////////	
	


/////////////////////////addblog////////////////////////////////////////////////
  public function addblog(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();

        if(isset($_POST) && !empty($_POST))
        {
           
            $postdata['title'] = $_POST['title'];
			$postdata['description'] = $_POST['description'];
			$postdata['meta_title'] = $_POST['meta_title'];
		    $postdata['meta_description'] = $_POST['meta_description'];
		    $postdata['meta_keywords'] = $_POST['meta_keywords'];
            $postdata['tags'] = $_POST['tags'];
			$postdata['category'] = $_POST['category_id'];
			$postdata['log_date_created'] = date('Y-m-d h:i:s');
			$postdata['created_by'] = $req->session()->get('userdata')[0]->id;
			 
			if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
		
            {
				$name = $_FILES['attachment']['name'];
                $size = $_FILES['attachment']['size'];
                $file_type = $_FILES['attachment']['type'];
                $tmp_name = $_FILES['attachment']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                   $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/blog/'.$file_name))
                    {
                      $postdata['attachment'] = $file_name;
                      $insertstatus = DB::table('blog')->insert($postdata);
					  
					   
                        if($insertstatus)
                        {
                            session()->put('msg','Record Created Successfully');
                            return redirect()->back();
                        }
                    }
                }
                else
                {
                    session()->put('err','Please select image format file');
                    return view('Subcategory.add_subcategory');
                }
            }
				
            $insertstatus = DB::table('blog')->insert($postdata);
            
           if($insertstatus)
           {
            session()->put('msg','Record Created Successfully');
            return redirect()->back();
           }
           
        }
       
		$category = DB::table('blog_category')->where('status','Active')->get();
        return view('Blog.add_blog')->with('category',$category);
    }
	
	
     public function editblog(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        if(!empty(base64_decode($req->data)))
        {
            $blog = DB::table('blog')->where('id',base64_decode($req->data))->get();
			$category = DB::table('blog_category')->where('status','Active')->get();
            return view('Blog.edit_blog')->with('blogdata',$blog)->with('category',$category);
        }
    }
    public function updateblog(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }
        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
             $postdata['category'] = $_POST['category_id'];
             $postdata['title'] = $_POST['title'];
			 $postdata['description'] = $_POST['description'];
			 $postdata['meta_title'] = $_POST['meta_title'];
		     $postdata['meta_description'] = $_POST['meta_description'];
		     $postdata['meta_keywords'] = $_POST['meta_keywords'];
             $postdata['tags'] = $_POST['tags'];
             $postdata['log_date_created'] = date('Y-m-d h:i:s');
			 $postdata['created_by'] = $req->session()->get('userdata')[0]->id;
			
			 
			 if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
		
            {
				$name = $_FILES['attachment']['name'];
                $size = $_FILES['attachment']['size'];
                $file_type = $_FILES['attachment']['type'];
                $tmp_name = $_FILES['attachment']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                   $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/blog/'.$file_name))
                    {
                      $postdata['attachment'] = $file_name;
                      $insertstatus = DB::table('blog')->insert($postdata);
					  
					   
                        if($insertstatus)
                        {
                            session()->put('msg','Record Created Successfully');
                            return redirect()->back();
                        }
                    }
                }
                else
                {
                    session()->put('err','Please select image format file');
                    return view('Blog.add_blog');
                }
            }
				
		  $updatestatus = DB::table('blog')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)
            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
        }
           $category = DB::table('blog_category')->where('status','Active')->get();
           return view('Blog.blog')->with('category',$category);
    }
////////////////////////////////////end blog///////////////////////////////////	
	
/////////////Testimonials////////////////////////////////////////////////////////
	  public function addtestimonial(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();

        if(isset($_POST) && !empty($_POST))
        {
            $postdata['title'] = $_POST['title'];
            $postdata['description'] = $_POST['description'];
            $postdata['posted_date'] = date('Y-m-d H:i:s');
			
		  
            $insertstatus = DB::table('testimonial')->insert($postdata);
            if($insertstatus)
            {
                session()->put('msg','Record Created Successfully');
                return redirect()->back();
            }
        }
        return view('Testimonial.add_testimonial');
    }
     public function edittestimonial(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        if(!empty(base64_decode($req->data)))
        {
            $testimonial = DB::table('testimonial')->where('id',base64_decode($req->data))->get();
            return view('Testimonial.edit_testimonial')->with('testimonialdata',$testimonial);
        }
    }
    public function updatetestimonial(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }
        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $postdata['title'] = $_POST['title'];
            $postdata['description'] = $_POST['description'];
            $postdata['posted_date'] = date('Y-m-d H:i:s');
           
            $updatestatus = DB::table('testimonial')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)
            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
        }

        return redirect()->back();
    }
	
    /////////////end Testimonials ////////////////////////////////////////////
    
    //////////////////////Add vendor /////////////////////////////////
    
     public function addsettlementreports(Request $req)
    {
       
        $_POST = $req->all();
       

        if(isset($_POST) && !empty($_POST))
        {
            $postdata['user_id'] = $_POST['user_id'];
            $postdata['amount_paid'] = $_POST['amount_paid'];
            $postdata['transaction_no'] = $_POST['transaction_no'];
            $postdata['paid_date'] = $_POST['paid_date'];
            $postdata['narration'] = $_POST['narration'];
            
            $insertstatus = DB::table('settlement')->insert($postdata);
            
         
            if($insertstatus)
            {
                session()->put('msg','Record Created Successfully');
                return redirect()->back();
            }
        }
         $userdat = DB::table('user')->where('department_id','3')->get();
         //$settlementreportsdata = DB::table('settlement')->leftJoin('user','user.id','=','settlement.user_id')
                                                                
       
        return view('Reports.add_settlementreports')->with('user',$userdat);
    }
    
    //////////////////////End vendor/////////////////////////////////
    
    

    //////////////////////////Department//////////////////////////////////////
    
    public function adddepartment(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $file_name = '';
            $postdata['name'] = $_POST['name'];
            $postdata['description'] = $_POST['description'];
            
            $postdata['created_by'] = $req->session()->get('userdata')[0]->id;
            $postdata['log_date_created'] = date('Y-m-d h:i:s');


            $insertstatus = DB::table('department')->insert($postdata);
            if($insertstatus)
            {
                session()->put('msg','Record Created Successfully');
                return view('Department.add_department');
            }
        }

        return view('Department.add_department');
    }

    public function editdepartment(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        if(!empty(base64_decode($req->data)))
        {
            $fetchdeptdata = DB::table('department')->where('id',base64_decode($req->data))->get();
            return view('Department.edit_department')->with('deptdata',$fetchdeptdata);
        }
    }

     public function updatedepartment(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $postdata['name'] = $_POST['name'];
            $postdata['description'] = $_POST['description'];

            $updatestatus = DB::table('department')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)
            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
        }
        session()->put('msg','Record Updated Successfully');
        return redirect()->back();
    }
    //////////////////////////end Department//////////////////////////////////////

    //////////////////////////Banners////////////////////////////////////////////
    public function addbanner(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $file_name = '';
          
            $postdata['type'] = $_POST['type'];
			$postdata['user_type'] = $_POST['user_type'];
            $postdata['file_type'] = $_POST['file_type'];
			$postdata['description'] = $_POST['description'];
            $postdata['created_by'] = $req->session()->get('userdata')[0]->id;
            $postdata['log_date_created'] = date('Y-m-d h:i:s');

            if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
            {
                $name = $_FILES['attachment']['name'];
                $size = $_FILES['attachment']['size'];
                $file_type = $_FILES['attachment']['type'];
                $tmp_name = $_FILES['attachment']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                   $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/banners/'.$file_name))
                    {
                        $postdata['attachment'] = $file_name;
                        $insertstatus = DB::table('banner')->insert($postdata);
                        if($insertstatus)
                        {
                            session()->put('msg','Record Created Successfully');
                            return redirect()->back();
                        }
                    }
                }
                else
                {
                    session()->put('err','Please select image format file');
                    return redirect()->back();
                }
            }
        }

        $banner = DB::table('banner')->get();

        return view('Banners.add_banner')->with('banner',$banner);
    }

	
	public function editbanner(Request $req)
    {
		
       
            if(!empty(base64_decode($req->data)))
        {
            $fetchbannerdata = DB::table('banner')->where('id',base64_decode($req->data))->get();
            return view('Banners.edit_banner')->with('bannerdata',$fetchbannerdata);
        }
    }
 
	

    public function updatebanner(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $file_name = '';
            $postdata['type'] = $_POST['type'];
			$postdata['user_type'] = $_POST['user_type'];
            $postdata['file_type'] = $_POST['file_type'];
			$postdata['description'] = $_POST['description'];
            $postdata['created_by'] = $req->session()->get('userdata')[0]->id;
            $postdata['log_date_created'] = date('Y-m-d h:i:s');

            if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name']))
            {
                $name = $_FILES['attachment']['name'];
                $size = $_FILES['attachment']['size'];
                $file_type = $_FILES['attachment']['type'];
                $tmp_name = $_FILES['attachment']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                    $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/banners/'.$file_name))
                    {
                        $postdata['attachment'] = $file_name;
                    }
                }
                else
                {
                   session()->put('err','Please select image format file');
                   return redirect()->back();
                }
            }
            else
            {
                $getvideo = DB::table('banner')->select('attachment')->where('id',$_POST['id'])->get();
                foreach($getvideo as $video)
                {
                    $file_name = $video->attachment;
                    $postdata['attachment'] = $file_name;
                }
            }


            $updatestatus = DB::table('banner')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)
            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
        }

        return redirect()->back();
    }
    //////////////////////////end Banners////////////////////////////////////////////


    //////////////////////////User//////////////////////////////////////////////////
    public function adduser(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $file_name = '';
            $postdata['name'] = $_POST['name'];
            $postdata['last_name'] = $_POST['last_name'];
            $postdata['email'] = $_POST['email'];
            $postdata['mobile'] = $_POST['mobile'];
            $postdata['password'] = HASH::make($_POST['password']);
            $postdata['department_id'] = $_POST['department_id'];
            //$postdata['location'] = $_POST['location'];
            $postdata['address'] = $_POST['address'];
            $postdata['created_by'] = $req->session()->get('userdata')[0]->id;
            $postdata['log_date_created'] = date('Y-m-d h:i:s');

            if(isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo']['name']))
            {
                $name = $_FILES['profile_photo']['name'];
                $size = $_FILES['profile_photo']['size'];
                $file_type = $_FILES['profile_photo']['type'];
                $tmp_name = $_FILES['profile_photo']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                    $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/user/'.$file_name))
                    {
                        $postdata['profile_photo'] = $file_name;
                        $insertstatus = DB::table('user')->insert($postdata);
                        if($insertstatus)
                        {
                            session()->put('msg','Record Created Successfully');
                            return redirect()->back();
                        }
                    }
                }
                else
                {
                    session()->put('err','Please select only Image format file');
                    return redirect()->back();
                }
            }
        }

       
        return view('User.add_user');
    }


    public function edituser(Request $request)
    {
        $loginStatus = $request->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        if(!empty(base64_decode($request->data)))
        {
            $fetchuserdata = DB::table('user')->where('id',base64_decode($request->data))->get();
            $dept = DB::table('department')->get();

            return view('User.edit_user')->with('userdata',$fetchuserdata)->with('department',$dept);
        }
    }


    public function updateuser(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }
        
        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $file_name = '';
            $postdata['name'] = $_POST['name'];
            $postdata['last_name'] = $_POST['last_name'];
            $postdata['email'] = $_POST['email'];
            $postdata['mobile'] = $_POST['mobile'];
            $postdata['department_id'] = $_POST['department_id'];
            //$postdata['location'] = $_POST['location'];
            $postdata['address'] = $_POST['address'];
            $postdata['modified_by'] = $req->session()->get('userdata')[0]->id;
            $postdata['log_date_modified'] = date('Y-m-d h:i:s');

            if(isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo']['name']))
            {
                $name = $_FILES['profile_photo']['name'];
                $size = $_FILES['profile_photo']['size'];
                $file_type = $_FILES['profile_photo']['type'];
                $tmp_name = $_FILES['profile_photo']['tmp_name'];

                if(($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png"))
                {
                    $file_name = rand(1000,9999).'_'.time().'_'.$name;
                    if(move_uploaded_file($tmp_name, '../uploads/user/'.$file_name))
                    {
                        $postdata['profile_photo'] = $file_name;
                    }
                }
                else
                {
                   session()->put('err','Please select image format file');
                   return redirect()->back();
                }
            }
            else
            {
                $getvideo = DB::table('user')->select('profile_photo')->where('id',$_POST['id'])->get();
                foreach($getvideo as $video)
                {
                    $file_name = $video->profile_photo;
                    $postdata['profile_photo'] = $file_name;
                }
            }

            $updatestatus = DB::table('user')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)
            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
        }

        return redirect()->back();
    }
    /////////////////////////end user//////////////////////////////////////////////
	
	
	
	//////////////////////////task///////////////////////////////////

		   public function edittask(Request $req)
    {
        if(!empty(base64_decode($req->data)))
        {
              $taskdata = DB::table('task')->where('id',base64_decode($req->data))->get();
	  
			   $taskdata = DB::table('task')->select('user.name as user_name','task.*','category.name as cat_name','category.*','subcategory.*','task.id as taskid')
			                                ->leftJoin('user','user.id','=','task.user_id')
				                            ->leftJoin('category','category.id','=','task.category_id')
											->leftJoin('subcategory','subcategory.id','=','task.sub_category_id')
											->where('task.id',base64_decode($req->data))
											->get();
              //print_r(base64_decode($req->data));exit;
				
				$taskquotedata = DB::table('task_quote')->select('task_quote.*','task.id as taskid','task_quote.*','user.name as username')->leftJoin('task','task.id','=','task_quote.task_id')->leftJoin('user','user.id','=','task_quote.user_id')->where('task_quote.task_id',base64_decode($req->data))->get();
			
		//	print_r($taskquotedata);exit;
                $taskpaymentdata = DB::table('task_payment')->leftJoin('task','task.id','=','task_payment.task_id')->leftJoin('user','user.id','=','task_payment.user_id')->where('task_payment.task_id',base64_decode($req->data))->get();					
               
	  //echo  base64_decode($req->data);exit;
           return view('Task.edittask')->with('taskdata',$taskdata)->with('taskquotedata',$taskquotedata)->with('taskpaymentdata',$taskpaymentdata);
        }
    }
	
	//////////////////////////end task///////////////////////////////
	
	//////////////////////////task///////////////////////////////////

		   public function editinprocesstasks(Request $req)
       {
        if(!empty(base64_decode($req->data)))
        {
               $editinprocesstasksdata = DB::table('task_status')->leftJoin('user','user.id','=','task_status.user_id')->where('task_status.status','Inprocess')->get();
	  //echo  base64_decode($req->data);exit;
           return view('Task.editinprocesstasks')->with('editinprocesstasksdata',$editinprocesstasksdata);
        }
    }
	
	
	//////////////////////////task///////////////////////////////////
	
	
		/*elseif(base64_decode($request->data)=='completedtasks')
            {
                $completedtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')->leftJoin('user','user.id','=','task_status.user_id')->where('task_status.status','Completed')->get();
		                   
				 //print_r($completedtasksdata);exit;                     
                return view('Task.completedtasks')->with('completedtasksdata',$completedtasksdata)->with('page_access',$page_access);
				
            }*/
	

		   public function editcompletedtasks(Request $req)
       {
        if(!empty(base64_decode($req->data)))
        {
              
                $editcompletedtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')
                                                                  ->leftJoin('user','user.id','=','task_status.user_id')
                                                                  ->leftJoin('task','task.id','=','task_status.task_id')
                                                                  ->where('task_status.id',base64_decode($req->data))
                                                                  ->where('task_status.status','Completed')
                                                                  ->get();
                       $taskdata = DB::table('task')->select('user.name as user_name','task.*','category.name as cat_name','category.*','subcategory.*')
			                                ->leftJoin('user','user.id','=','task.user_id')
				                            ->leftJoin('category','category.id','=','task.category_id')
											->leftJoin('subcategory','subcategory.id','=','task.sub_category_id')
											->where('task.id',base64_decode($req->data))
											->get();                                            
        
           return view('Task.editcompletedtasks')->with('editcompletedtasksdata',$editcompletedtasksdata)->with('taskdata',$taskdata);
        }
    }
    
    
		   public function editpendingtasks(Request $req)
       {
        if(!empty(base64_decode($req->data)))
        {
              
                $editpendingtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')
                 ->leftJoin('user','user.id','=','task_status.user_id')
                 ->where('task_status.id',base64_decode($req->data))
                 ->where('task_status.status','Pending')
                 ->get();
                 
                  $taskdata = DB::table('task')->select('user.name as user_name','task.*','category.name as cat_name','category.*','subcategory.*')
			                                ->leftJoin('user','user.id','=','task.user_id')
				                            ->leftJoin('category','category.id','=','task.category_id')
											->leftJoin('subcategory','subcategory.id','=','task.sub_category_id')
											->where('task.id',base64_decode($req->data))
											->get();        
        
	     // print_r($editpendingtasksdata);exit;
           return view('Task.editpendingtasks')->with('editpendingtasksdata',$editpendingtasksdata)->with('taskdata',$taskdata);
        }
    }
    
     public function editacceptedtasks(Request $req)
    {
        if(!empty(base64_decode($req->data)))
        {
               $editacceptedtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')->leftJoin('user','user.id','=','task_status.user_id')->where('task_status.id',base64_decode($req->data))->where('task_status.status','Accepted')->get();
	//print_r($editacceptedtasksdata);exit;
	 $taskdata = DB::table('task')->select('user.name as user_name','task.*','category.name as cat_name','category.*','subcategory.*')
			                                ->leftJoin('user','user.id','=','task.user_id')
				                            ->leftJoin('category','category.id','=','task.category_id')
											->leftJoin('subcategory','subcategory.id','=','task.sub_category_id')
											->where('task.id',base64_decode($req->data))
											->get();  
           return view('Task.editacceptedtasks')->with('editacceptedtasksdata',$editacceptedtasksdata)->with('taskdata',$taskdata);
        }
    }
    
    
    
		   public function editstartedtasks(Request $req)
    {
        if(!empty(base64_decode($req->data)))
        {
              
                $editstartedtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')
                 ->leftJoin('user','user.id','=','task_status.user_id')
                 ->where('task_status.id',base64_decode($req->data))
                 ->where('task_status.status','Started')
                 ->get();
                 
                 $taskdata = DB::table('task')->select('user.name as user_name','task.*','category.name as cat_name','category.*','subcategory.*')
			                                ->leftJoin('user','user.id','=','task.user_id')
				                            ->leftJoin('category','category.id','=','task.category_id')
											->leftJoin('subcategory','subcategory.id','=','task.sub_category_id')
											->where('task.id',base64_decode($req->data))
											->get();  
        
	     // print_r($editpendingtasksdata);exit;
           return view('Task.editstartedtasks')->with('editstartedtasksdata',$editstartedtasksdata)->with('taskdata',$taskdata);
        }
    }
	
	
	
		   public function editpaidtasks(Request $req)
       {
        if(!empty(base64_decode($req->data)))
        {
              
                $editpaidtasksdata = DB::table('task_status')->select('task_status.*','task_status.status as statusname','user.*','user.name as user_name','task_status.*','task_status.id as task_id')
                 ->leftJoin('user','user.id','=','task_status.user_id')
                 ->where('task_status.id',base64_decode($req->data))
                 ->where('task_status.status','Paid')
                 ->get();
                 
                 $taskdata = DB::table('task')->select('user.name as user_name','task.*','category.name as cat_name','category.*','subcategory.*')
			                                ->leftJoin('user','user.id','=','task.user_id')
				                            ->leftJoin('category','category.id','=','task.category_id')
											->leftJoin('subcategory','subcategory.id','=','task.sub_category_id')
											->where('task.id',base64_decode($req->data))
											->get();  
        
	     // print_r($editpendingtasksdata);exit;
           return view('Task.editpaidtasks')->with('editpaidtasksdata',$editpaidtasksdata)->with('taskdata',$taskdata);
        }
    }
	
	//////////////////////customer/////////////////////////////
	   public function editcustomer(Request $req)
    {
        if(!empty(base64_decode($req->data)))
        {
              $userdata = DB::table('user')->where('id',base64_decode($req->data))->where('department_id','4')->get();
              
               $taskdata = DB::table('task')->where('id',base64_decode($req->data))->get();
	  
			   $taskdata = DB::table('task')->select('user.name as user_name','task.*','category.name as cat_name','category.*','subcategory.*')
			                                ->leftJoin('user','user.id','=','task.user_id')
				                            ->leftJoin('category','category.id','=','task.category_id')
											->leftJoin('subcategory','subcategory.id','=','task.sub_category_id')
											->where('task.id',base64_decode($req->data))
											->get();

	  //echo  base64_decode($req->data);exit;
           return view('Customer.editcustomer')->with('userdata',$userdata)->with('taskdata',$taskdata);
        }
    }
	
	//////////////////////end customer/////////////////////////////
	
	
	
		//////////////////////vendor/////////////////////////////
	  public function editvendor(Request $req)
    {
        if(!empty(base64_decode($req->data)))
        {
              $userdata = DB::table('user')->where('id',base64_decode($req->data))->where('department_id','3')->get();
              $user_uploaddata = DB::table('user_upload')->where('id',base64_decode($req->data))->get();

			  $bankdetailsdata = DB::table('user_bank_details')->where('user_id',base64_decode($req->data))->leftJoin('user','user.id','=','user_bank_details.user_id')->get();
			  
           return view('Vendor.editvendor')->with('userdata',$userdata)->with('user_uploaddata',$user_uploaddata)->with('bankdetailsdata',$bankdetailsdata);
        }
    }
	
	//////////////////////end vendor/////////////////////////////
	public function  send_message($target,$message,$flag)
    {
            $url = 'https://fcm.googleapis.com/fcm/send';
            $server_key = 'AAAAs0Blfnc:APA91bEs72lPifdweFw1C-SEHggOrsZZd3yTOx-DKQ1FMm-xQkynKQ56q0Mh1d_3HwSebkPEJ4MxIhCHH5JEBEw473OpS7u7bpNflQ9GAT35K_D143MC6NY6uf_cTyCqlypgnkVJZhG5';
            			
            //$fields = array();
            
            //$target="ecWV664YKnU:APA91bFZ7t9_ZjyAOC_iCFrwQWV4BQ8DrdE1G0NBM2jDIJMLgL826nhUzq3HT6h6fuxlJJgtnpadKWpIpnuCrYcO5gNtOmIfe3eePDSEWXgisLHXWlaAMVJkojCncS0fKxLhbor14hZq";
            //$fields['data'] = $data;
             $dt=date('Y-m-d h:m a');
             $data = array();
             $title=ucwords($flag);
             $data['title'] = ucwords($flag);
             $data['time']= date("d-m-Y h:m a", strtotime($dt));
             $data['is_background']='false';
             $data['body'] = $message;
             $fields['data'] = $data;
             
             $notification= array();
             $notification['body'] = $message;
             $notification['title']= ucwords($flag);
             $notification['icon']='true';
            // $notification['smallIcon']='http://pickmychoice.co.uk/dev505/dynamic/images/logo-icon.png';
             $fields['notification'] = $notification;
            
             $fields['to'] = $target;
            
             $headers = array(
              'Content-Type:application/json',
              'Authorization:key='.$server_key
            );
            			
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
           
            if ($result === FALSE) 
            {
            	die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            return true;
    }
	//////////////////////Vendor Status//////////////////////////
	 public function change_vendor_status(Request $req)
     {
	  $_POST = $req->all();
	  if(isset($_POST) && !empty($_POST))
	  {
	      $userdata = DB::table('user')->where('id',$_POST['id'])->where('department_id','3')->get();
	      //print_r($userdata);
	      if($userdata->count()>0)
          {
            foreach($userdata as $userdata)
            {
    	      $fcm_token=$userdata->fcm_token;
    	      $device_id=$userdata->device_id;
    	      if($fcm_token!='' && $device_id=='Android')
    	      {
    	           $message="Dear Vendor, Your Verification Process Successfully Completed.You Can Take Services from PickMyChoice.Thank you.";
                   $vid=$_POST['id'];
                   $dt=date('Y-m-d H:i:s');
                    $postdata1['user_id'] = $vid;
                    $postdata1['title'] = 'Verification';
                    $postdata1['message'] = $message;
                    $postdata1['is_read'] = 'No';
                    $postdata1['recieved_date'] = $dt;
                    $postdata1['sent_date'] = $dt;
                    $postdata1['log_date_created'] = $dt;
                    $insertstatus1 = DB::table('notification')->insert($postdata1);
                    if($insertstatus1)
                    {
                    $this->send_message($fcm_token,$message,'Verification');
                    }
    	      }
            }
          }
	      
		  $postdata['is_verified'] = $_POST['is_verified'];
          //$postdata['log_date_modified'] = $_POST['log_date_modified'];
		  //->where('id',$_POST['id'])
		  $insertstatus = DB::table('user')->where('id',$_POST['id'])->update($postdata);
		  if($insertstatus)
            {
                session()->put('msg','Record Created Successfully');
                return redirect()->back();
            }
		   
        }
    }
	
	
	//////////////////////End Vendor Status//////////////////////////
	
	

	//////////////////////Quote Status//////////////////////////
	 public function change_order_status(Request $req)
  {
	  $_POST = $req->all();
	  if(isset($_POST) && !empty($_POST))
	  {
	
		  $postdata['status'] = $_POST['status'];
          $postdata['log_date_modified'] = $_POST['log_date_modified'];
		 // ->where('id',$_POST['id'])
		  
		  $insertstatus = DB::table('task_quote')->update($postdata);
		  if($insertstatus)
                        {
                            session()->put('msg','Record Created Successfully');
                            return redirect()->back();
                        }
		   
        }
    }
	
	
	//////////////////////End Quote Status//////////////////////////
	
	
	
	///////////////////Close Ticket/////////////////////////
		 public function change_vendor_ticket(Request $req)
  {
	  $_POST = $req->all();
	  if(isset($_POST) && !empty($_POST))
	  {
	
		  $postdata['solution'] = $_POST['solution'];
          $postdata['log_date_modified'] = $_POST['log_date_modified'];
          
        
		  
		  $insertstatus = DB::table('refund_request')->where('id',$_POST['id'])->update($postdata);
		    //print_r ($insertstatus);exit;
		  if($insertstatus)
                        {
                            session()->put('msg','Record Created Successfully');
                            return redirect()->back();
                        }
		   
        }
    }
	
		///////////////////End Ticket/////////////////////////
	
	
	////////////////////////vendor details/////////////////////////////////
		 public function vendor_details(Request $req)
  {
      $userid =$_POST['id']; 
	  $html = '';
	  $total=0;
	  $waived=0;
	  $commission=0;
 	  $settlementreportsdata1 = DB::table('settlement')->select('user.id','user.city','user.postcode','user.log_date_created','settlement.paid_date','settlement.amount_paid')
                                                       ->leftJoin('user','user.id','=','settlement.user_id')->where('user.department_id','3')
                                                       ->where('user.id',$userid)
                                                       ->get();
                 //$settlementreportsdata2 = DB::table('task_payment')->select('task_payment.*','task_payment.amount as amt','task_payment.waived_amount as waamt')->get();
                 $settlementreportsdata2 = DB::table('task_payment')->select('task_payment.id','task_payment.amount','task_payment.waived_amount','task_payment.commission')->get();
                 //print_r($settlementreportsdata2);exit;
                 
                 
      
      if($settlementreportsdata1->count()>0)
      {
          foreach($settlementreportsdata1 as $da)
           foreach($settlementreportsdata2 as $das)
          {
              
              
              $html .='<td>
			                    <span>Location: '.$da->city.'</span> <br>
			                    <span>Reg Date: '.$da->log_date_created.'</span> <br>
			                    <span>Total Amount: £'.$das->amount.' </span> <br>
			                    <span>Waived Amount: £'.$das->waived_amount.'</span> <br>
			                    <span>Commission Amount: £ </span> <br>
			                    <span>Total Tobe Paid: £ </span> <br>
			                    <span>Paid Amount: £'.$da->amount_paid.'</span> <br>
			                    <span>Last Paid Date: '.$da->paid_date.'</span> <br>
			                    <span>Balance: £ </span> <br>
					 </td>';
          }
        }
      
      else
      {
          $html = '';
      }
      echo $html;
                 
               
  }
////////////////////////end vendor details//////////////////////////////////////

    ////////////////////////Email Settings/////////////////////////////////////////
   
     public function editemailsettings(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        if(!empty(base64_decode($req->data)))
        {
            $emailsettings = DB::table('emailsettings')->where('id',base64_decode($req->data))->get();
            //print_r($circuler);
            return view('Emailsettings.edit_emailsettings')->with('emailsettingsdata',$emailsettings);
        }
    }
    public function updateemailsettings(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }
        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $postdata['host'] = $_POST['host'];
			$postdata['port'] = $_POST['port'];
			$postdata['email'] = $_POST['email'];
		    $postdata['to_email'] = $_POST['to_email'];
          
           
            $updatestatus = DB::table('emailsettings')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)
            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
        }

        return redirect()->back();
    }
    ///////////////////////end email settings//////////////////////////////////////////////
	
	 ////////////////////////Smssettings/////////////////////////////////////////////////
   
     public function editsmssettings(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        if(!empty(base64_decode($req->data)))
        {
            $smssettings = DB::table('smssettings')->where('id',base64_decode($req->data))->get();
           
            return view('Smssettings.edit_smssettings')->with('smssettingsdata',$smssettings);
        }
    }
    public function updatesmssettings(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }
        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $postdata['company'] = $_POST['company'];
			$postdata['url'] = $_POST['url'];
			$postdata['username'] = $_POST['username'];
		    $postdata['sender_id'] = $_POST['sender_id'];
          
           
            $updatestatus = DB::table('smssettings')->where('id',$_POST['id'])->update($postdata);
            if($updatestatus)
            {
                session()->put('msg','Record Updated Successfully');
                return redirect()->back();
            }
        }

        return redirect()->back();
    }
	
    ////////////////////////Access  Management///////////////////////////////////////////////////

    public function access_management(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

       $department = DB::table('department')->where('id','!=',1)->get();
       return view('access_management')->with('department',$department);
    }

    public function user_by_dept_id(Request $req)
    {
       $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        if(!empty($req->input('did')))
        {
            $html = '';

            $getusers = DB::table('user')->where('department_id',$req->input('did'))->get();
            if($getusers->count()>0)
            {
                $html ='<option value="">Select User</option>';
                foreach($getusers as $user)
                {
                   $html .='<option value='.$user->id.'>'.ucfirst($user->name).' ('.$user->mobile.')'.'</option>';
                }
            }
            else
            {
                $html .='<option value="">Select User</option>';
            }
            echo $html;
        }
    }


    public function page_data(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $html = '';

        $dept_id = $req->input('dept');
        $user_id = $req->input('user');

        if(!empty($dept_id) && !empty($user_id))
        {
                $edit = '';
                $pages = DB::table('pages')->where('status','Active')->get();

                if($pages->count()>0)
                {
                    foreach($pages as $page)
                    {
                        $html .='<div class="col-md-4">
                                 <label>'.str_replace('_', ' ', ucfirst($page->name)).'</label>
                                 </div>
                                 <br>
                                 <br>';

                        $access = DB::table('access_management')->where('department_id',$dept_id)->where('user_id',$user_id)->where('user_id',$user_id)->where('pages_id',$page->id)->get();

                         $add_v = '0';$edit_v = '0';$delete_v = '0';$view_v = '0';
                         if($access->count()>0)
                         {
                            foreach($access as $acc)
                            {
                                 if($acc->can_edit==1)
                                 {
                                    $edit = 'checked';
                                    $edit_v = '1';
                                 }
                                 else
                                 {
                                   $edit = '';$edit_v = '0';
                                 }

                                 if($acc->can_add==1)
                                 {
                                    $add = 'checked';$add_v = '1';
                                 }
                                 else
                                 {
                                    $add = '';$add_v = '0';
                                 }

                                 if($acc->can_delete==1)
                                 {
                                    $delete = 'checked';$delete_v = '1';
                                 }
                                 else
                                 {
                                    $delete = '';$delete_v = '0';
                                 }
                                 if($acc->can_view==1)
                                 {
                                    $view = 'checked';$view_v = '1';
                                 }
                                 else
                                 {
                                    $view = '';$view_v = '0';
                                 }
                                                                
                            }
                         }
                         else
                         {
                            $edit ='';
                            $add = '';
                            $delete = '';
                            $view = '';
                         }

                         $html.='<div class="col-md-2">
                                 <input type="hidden"  value="0"  name="'.$page->id.'_add" >
                                 <input type="checkbox" '.$add.' value="'.$add_v.'" onclick="check(this)"  name="'.$page->id.'_add" >
                                 </div>
                                 <div class="col-md-2">
                                 <input type="hidden"  value="0"  name="'.$page->id.'_edit" >
                                 <input type="checkbox" '.$edit.' value="'.$edit_v.'" onclick="check(this)"  name="'.$page->id.'_edit" >
                                 </div>
                                 <div class="col-md-2">
                                 <input type="hidden"  value="0"  name="'.$page->id.'_delete" >
                                 <input type="checkbox" '.$delete.' value="'.$delete_v.'" onclick="check(this)" name="'.$page->id.'_delete">
                                 </div>
                                 <div class="col-md-2">
                                 <input type="hidden"  value="0"  name="'.$page->id.'_view" >
                                 <input type="checkbox" '.$view.' value="'.$view_v.'" onclick="check(this)"  name="'.$page->id.'_view">
                                 </div>';
                    }

                }
        }
         echo $html;
    }


    public function update_permission(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST) && !empty($_POST['department_id']) && !empty($_POST['user_id']))
        {
         foreach($_POST as $key => $value)
         {
            
            $edit = str_replace('_edit', '', $key);
            if($key==$edit.'_edit')
            {
                $check = DB::table('access_management')->where('pages_id',$edit)->where('department_id',$_POST['department_id'])->where('user_id',$_POST['user_id'])->get();
                if($check->count()>0)
                {

                   $status = array('can_edit'=>$value);
                   $pagesid = array('pages_id'=>$edit);

                   $editstatus = DB::table('access_management')->where($pagesid)->where('department_id',$_POST['department_id'])->where('user_id',$_POST['user_id'])->update($status);                    
                }
                else
                {
                    $insertdata = array('pages_id'=>$edit,'department_id'=>$_POST['department_id'],'user_id'=>$_POST['user_id'],'can_edit'=>$value,'created_by'=>$req->session()->get('userdata')[0]->id,'log_date_created'=>date('Y-m-d h:i:s'));
                    $update = DB::table('access_management')->insert($insertdata);
                }
            }

            $view = str_replace('_view', '', $key);
            if($key==$view.'_view')
            {
                $check = DB::table('access_management')->where('pages_id',$view)->where('department_id',$_POST['department_id'])->where('user_id',$_POST['user_id'])->get();
                if($check->count()>0)
                {

                   $status = array('can_view'=>$value);
                   $pagesid = array('pages_id'=>$view);

                   $viewstatus = DB::table('access_management')->where($pagesid)->where('department_id',$_POST['department_id'])->where('user_id',$_POST['user_id'])->update($status);
                }
                else
                {
                    $insertdata = array('pages_id'=>$view,'department_id'=>$_POST['department_id'],'user_id'=>$_POST['user_id'],'can_view'=>$value,'created_by'=>$req->session()->get('userdata')[0]->id,'log_date_created'=>date('Y-m-d h:i:s'));
                    $view1status = DB::table('access_management')->insert($insertdata);
                }
            }

            $add = str_replace('_add', '', $key);
            if($key==$add.'_add')
            {
                $check = DB::table('access_management')->where('pages_id',$add)->where('department_id',$_POST['department_id'])->where('user_id',$_POST['user_id'])->get();
                if($check->count()>0)
                {

                   $status = array('can_add'=>$value);
                   $pagesid = array('pages_id'=>$add);

                   $addstatus = DB::table('access_management')->where($pagesid)->where('department_id',$_POST['department_id'])->where('user_id',$_POST['user_id'])->update($status);                    
                }
                else
                {
                   $insertdata = array('pages_id'=>$add,'department_id'=>$_POST['department_id'],'user_id'=>$_POST['user_id'],'can_add'=>$value,'created_by'=>$req->session()->get('userdata')[0]->id,'log_date_created'=>date('Y-m-d h:i:s'));
                    $add1status = DB::table('access_management')->insert($insertdata);
                }
            }

            $delete = str_replace('_delete', '', $key);
            if($key==$delete.'_delete')
            {
                $check = DB::table('access_management')->where('pages_id',$delete)->where('department_id',$_POST['department_id'])->where('user_id',$_POST['user_id'])->get();
                if($check->count()>0)
                {

                   $status = array('can_delete'=>$value);
                   $pagesid = array('pages_id'=>$delete);

                   $deletestatus = DB::table('access_management')->where($pagesid)->where('department_id',$_POST['department_id'])->where('user_id',$_POST['user_id'])->update($status);
                }
                else
                {
                    $insertdata = array('pages_id'=>$edit,'department_id'=>$_POST['department_id'],'user_id'=>$_POST['user_id'],'can_delete'=>$value,'created_by'=>$req->session()->get('userdata')[0]->id,'log_date_created'=>date('Y-m-d h:i:s'));
                    $delete1status = DB::table('access_management')->insert($insertdata);
                }
            }
                           
          }
            $req->session()->put('msg','1');
            return redirect()->back();
        }
    }
    ////////////////////////end Access  Management////////////////////////////////////////////////

    ////////////////////////latest updates////////////////////////////////////////////////////////
    
    public function latest_updates(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

       $latest_updates = DB::table('latest_updates')->get();
       return view('Latest_update.latest_updates')->with('latest_updates',$latest_updates);
    }


    public function addupdate(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
            $postdata['name'] = $_POST['name'];
            $postdata['created_by'] = $req->session()->get('userdata')[0]->id;
            $postdata['log_date_created'] = date('Y-m-d h:i:s');

            $insertstatus = DB::table('latest_updates')->insert($postdata);
            if($insertstatus)
            {
                session()->put('msg','Record Created Successfully');
                return redirect()->back();
            }            
        }
        return view('Latest_update.add_latest_updates');
    }

    ////////////////////////end latest updates ///////////////////////////////////////////////////

    ///////////////////////side menus////////////////////////////////////////////////////////////

    public function sidemenu(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $sidemenu = DB::table('side_menus')->select('side_menus.*','menu.*','side_menus.id as sid','side_menus.status as sstatus')->leftJoin('menu','menu.id','=','side_menus.main_menu')->get();
       
        return view('Side_menu.sidemenus')->with('sidemenu',$sidemenu);
    }

    public function addsidemenu(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();

        if(isset($_POST) && !empty($_POST))
        {
           foreach($_POST['side_menu'] as $value)
           {
            $postdata['main_menu'] = $_POST['main_menu'];
            $postdata['side_menu'] = $value;
            $postdata['created_by']= $req->session()->get('userdata')[0]->id;
            $postdata['log_date_created'] = date('Y-m-d H:i:s');

            $insertstatus = DB::table('side_menus')->insert($postdata);
            
           }
           if($insertstatus)
           {
            session()->put('msg','Record Created Successfully');
            return redirect()->back();
           }
        }
        $menus = DB::table('menu')->where('status','Active')->where('parent_id','!=',0)->get();
        return view('Side_menu.add_side_menu')->with('menus',$menus);
    }

    public function editsidemenu(Request $request)
    {
        $loginStatus = $request->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        if(!empty(base64_decode($request->data)))
        {
            $sidemenu = DB::table('side_menus')->where('id',base64_decode($request->data))->get();
            $menus = DB::table('menu')->where('status','Active')->where('parent_id','!=',0)->get();
            return view('Side_menu.edit_side_menu')->with('sidemenu',$sidemenu)->with('menus',$menus);
        }
    }

    public function updatesidemenu(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }

        $_POST = $req->all();

        if(isset($_POST) && !empty($_POST))
        {
           foreach($_POST['side_menu'] as $value)
           {
            $postdata['main_menu'] = $_POST['main_menu'];
            $postdata['side_menu'] = $value;
            $postdata['modified_by']= $req->session()->get('userdata')[0]->id;
            $postdata['log_date_modified'] = date('Y-m-d H:i:s');

            $insertstatus = DB::table('side_menus')->where('id',$_POST['id'])->update($postdata);
            
           }
           if($insertstatus)
           {
            session()->put('msg','Record Update Successfully');
            return redirect()->back();
           }
           
        }
        $menus = DB::table('menu')->where('status','Active')->where('parent_id','!=',0)->get();
        return view('Side_menu.add_side_menu')->with('menus',$menus);
    }

    ///////////////////////end side menus////////////////////////////////////////////////////////

   
    public function headstatus(Request $req)
    {
        $_POST = $req->all();

        if(isset($_POST) && !empty($_POST))
        {
            if($_POST['status']==1)
            {
                $update = array('collapse'=>0);
            }
            else
            {
                $update = array('collapse'=>1);
            }

            $ustatus = DB::table('header')->where('id',1)->update($update);
            if($ustatus)
            {
                echo 1;
            }
        }
    }
}

