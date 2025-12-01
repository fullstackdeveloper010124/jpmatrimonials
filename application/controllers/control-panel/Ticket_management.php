<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Ticket_management extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
		$this->common_model->status_arr = array('Open'=>'Open','Resolve'=>'Resolve','Reopen'=>'Reopen','Close'=>'Close');
		$this->common_model->status_arr_change = array('Close'=>'Close','Reopen'=>'Reopen');
	}
	public function index()
	{
		redirect($this->common_model->data['base_url_admin'].'ticket-management/ticket-list');
		//$this->ticket_list();
	}
	public function ticket_list($status ='ALL', $page =1)
	{
		$ele_array = array(
            'subject'=>array('is_required'=>'required'),
			'priority'=>array('is_required'=>'required','placeholder'=>'','type'=>'dropdown','value_arr'=>array('Low'=>'Low','Medium'=>'Medium','High'=>'High')),
			'description'=>array('type'=>'textarea'),
			'alias'=>array('type'=>'hidden'),
			'attachment_1'=>array('type'=>'file','path_value'=>$this->common_model->path_ticket,'extension'=>'doc|docx|pdf|rtf|txt|jpg|png|jpeg|gif','display_img'=>'No'),
			'attachment_2'=>array('type'=>'file','path_value'=>$this->common_model->path_ticket,'extension'=>'doc|docx|pdf|rtf|txt|jpg|png|jpeg|gif','display_img'=>'No'),
			'attachment_3'=>array('type'=>'file','path_value'=>$this->common_model->path_ticket,'extension'=>'doc|docx|pdf|rtf|txt|jpg|png|jpeg|gif','display_img'=>'No'),
			
		);
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
        $this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
        $this->common_model->filed_notdisp = array('description','attachment_1','attachment_2','attachment_3');	
		
		$this->common_model->js_extra_code = " if($('#content').length > 0) { $('.page_content_edit').removeClass(' col-lg-7 ');
			$('.page_content_edit').addClass(' col-lg-10 ');
            CKEDITOR.replace( 'content' ); }";
            $btn_arr = array(
                //array('url'=>'#id#','class'=>'info','label'=>'View Replay'),
                array('onClick'=>"return display_add_comments(#id#)",'label'=>'Add Reply'),
                array('onClick'=>"return display_comments(#id#)",'class'=>'success','label'=>'View Reply'),
                
                array('url'=>'ticket-management/view-detail/#id#','class'=>'warning','label'=>'View Ticket'),
                
            );
		// $btn_arr = array(
		// 	array('url'=>'ticket-management/view-detail/#id#','class'=>'info','label'=>'View Detail'),
		// );
		$other_config = array('enctype'=>'enctype="multipart/form-data"','data_tab_btn'=>$btn_arr,'default_order'=>'desc','editAllow'=>'no');
		$this->common_model->data_tabel_filedIgnore = array('id','is_deleted','content');
		$this->common_model->common_rander('ticket_table', $status, $page , 'ticket List',$ele_array,'created_on',0,$other_config);
	}
	public function view_detail($id='')
	{
		if($id !='')
		{
			$data = array();
			$data['id'] = $id; // current row id for view detail
			// $image_arra = array(
			// array(
			// 	'filed_arr' => array('ticket_image'),
			// 	'path_value'=>$this->common_model->path_ticket,
			// 	'title'=>'Ticket Image',
			// 	'class_width'=>' col-lg-3 col-md-4 col-sm-6  col-xs-12 ',
			// 	'img_class'=>'img-responsive img-thumbnail',
            //     'inline_style'=>''
                
			// ));
	
        $field_main_array = array(				
            array(
                'title'=>'Ticket Detail',
                'class_width'=>' col-lg-6 col-md-12 col-sm-12 col-xs-4 ',
        'field_array'=>array(
                    'subject'=>'',
                    'priority'=>'',
                    'status'=>'',
                    'created_on'=>array('type'=>'date'),
                ),
    ),
            array(
                'title'=>'Description',
                'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
                'is_single'=>'yes',
                'field_array'=>array(
                        'description'=>''			
                ),		
            ),
        array(
                'title'=>'Ticket Attachment',
                'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
                'field_array'=>array(
                    'attachment_1'=>array('type'=>'link_attachment','label'=>'Attachment-1'),
                    'attachment_2'=>array('type'=>'link_attachment','label'=>'Attachment-2'),
                    'attachment_3'=>array('type'=>'link_attachment','label'=>'Attachment-3')

                ),
            ),
        );
			//$data['img_list_arr'] = $image_arra;
			$data['img_position'] = 'bottom';
			$data['field_list'] = $field_main_array;			
			$this->common_model->table_name = 'ticket_table'; // set table name for get data from wich table 
			$this->common_model->common_view_detail('Ticket Detail',$data);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'ticket-management/ticket-list');
		}
    }
    public function view_comment($page=1)
	{
		$data['page_number'] = $page;
		$data['limit_per_page'] = '10';
		$data['user_id']=$this->input->post('user_id');
		$data['base_url'] = $this->common_model->base_url;
		$this->load->view('back_end/view_comments',$data);
	}
	public function add_comment()
	{
		$data['user_id']=$this->input->post('user_id');
		$data['base_url'] = $this->common_model->base_url;
		$this->load->view('back_end/add_comments',$data);
	}
	public function save_comment()
	{
		//$this->member_model->save_comment();
		
		$user_type = $this->common_model->get_session_user_type();		
		$member_comment = '';
		$hidd_user_id = '';
		if($this->input->post('member_comment'))
		{
			$member_comment = $this->input->post('member_comment');
		}
		if($this->input->post('hidd_user_id'))
		{
			$hidd_user_id = $this->input->post('hidd_user_id');
		}
		$user_data = $this->common_model->get_count_data_manual('ticket_table',array('id'=>$hidd_user_id),1,'* ','',0,'',0);
		$ticket_number = '';
		if(isset($user_data['ticket_number']) && $user_data['ticket_number'] !='')
		{
			$ticket_number = $user_data['ticket_number'];
		}
		if($member_comment =='')
		{
			$this->session->set_flashdata('error_message',"Please enter comment");
			return;
		}
		if($hidd_user_id == '')
		{
			$this->session->set_flashdata('error_message',$this->common_model->success_message['error']);
			return;
		}
		$CurrentDate = $this->common_model->getCurrentDate();
		$user_type = 'C';
		$data_array = array(
			'ticket_number'=>$ticket_number,
			'user_type'=>$user_type,
			'user_id'=>317,
			'comment'=>$member_comment,
			'created_on'=>$CurrentDate,
		);
		
		$response = $this->common_model->update_insert_data_common("ticket_history_reply",$data_array,'',0);
		if($response)
		{
			$this->session->set_flashdata('success_message',"Comment Added Successfully");
			$data_array['client_id'] = $this->common_model->client_id;
			$data_array['web_key'] = $this->common_model->web_appkey;
			$data_array['create_reply'] = 'Yes';
			$this->common_model->curl_call_ticket($data_array);
		//$this->common_model->common_send_email
		}
		else
		{
			$this->session->set_flashdata('error_message', $this->common_model->success_message['error']);
		}
		
		$data['data'] = $this->common_model->getjson_response();
		$this->load->view('common_file_echo',$data);
	}
}