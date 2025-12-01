<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-50">
            <div class="col-md-4 col-sm-12 col-xs-12 hidden-xs hidden-sm">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Checkout</span></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                <div class="box-main-s">
                    <p class="Poppins-Semi-Bold mega-n3 f-s">Checkout</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$config_data = $this->common_model->get_site_config();
$service_tax_per = $config_data['service_tax'];
$tax_name = $config_data['tax_name'];

$event_array = array();
$event_array = $this->session->userdata('event_data_session');

$total_amount = $no_of_ticket *$event_data['ticket'];
if(isset($total_amount) && $total_amount !=''){
	$service_tax_amt = ($total_amount * $service_tax_per) / 100;
	$total_payment = $service_tax_amt + $total_amount;
	$event_array['total_amount'] = $total_payment;
}
$this->session->set_userdata('event_data_session',$event_array);
?>
    <div class="container-fluid new-width">
        <div class="row mr-top-26">
            <div class="col-md-8 col-sm-12 col-xs-12 pr-0 pr-15">
                <div class="mega-box-new padding-20-zero">
                    <div class="checkout-in-box">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center padding-0">
                            <p class="calibri-Bold-font f-22 color-31 t-transform-ue checkout-c1">Order
                                <span class="color-d">Details</span></p>
                            <hr class="checkout-hr">
                        </div>
                    </div>
                    <!--for Desktop Table Start-->
                    <table class="table table-bordered table-cstm hidden-xs">
                        <thead>
                            <tr class="Poppins-Bold f-18 color-31">
                                <th scope="col">Events</th>
                                <th scope="col">Tickets</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Total </th>
                                <th scope="col"><?php echo $tax_name;?>(<?php echo $service_tax_per;?>%)</th>
                                <th scope="col">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="Poppins-Regular f-14 color-9d">
                                <td><?php echo $event_data['title']; ?></td>
                                <td><?php if(isset($no_of_ticket) && $no_of_ticket!=''){echo $no_of_ticket;}?></td>
                                <td><?php echo $event_data['ticket_currency'].' '.$event_data['ticket'];?></td>
                                <td><?php $total = $no_of_ticket *$event_data['ticket'];
									echo $event_data['ticket_currency'].' '.$total;?></td>
                                <td><?php  $service_tax_amt = ($total * $service_tax_per) / 100;
									echo $event_data['ticket_currency'].' '.$service_tax_amt;?></td>
                                <td class="color-3cb Poppins-Semi-Bold"><?php $total_payment = $service_tax_amt + $total;
									echo $event_data['ticket_currency'].' '.$total_payment;?></td>
                            </tr>
                        </tbody>
                    </table>
                    <!--for Desktop Table End-->
                    <!--for Mobile Device Table Start-->
                    <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                        <div class="table-for-mobile">
                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="Poppins-Semi-Bold f-20 color-31">Event</p>
                                </div>
                                <div class="col-xs-6">
                                    <p class="Poppins-Regular f-16 color-31"><?php echo $event_data['title']; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="Poppins-Semi-Bold f-20 color-31">Tickets</p>
                                </div>
                                <div class="col-xs-6">
                                    <p class="Poppins-Regular f-16 color-31"><?php if(isset($no_of_ticket) && $no_of_ticket!=''){echo $no_of_ticket;}?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="Poppins-Semi-Bold f-20 color-31">Unit Price</p>
                                </div>
                                <div class="col-xs-6">
                                    <p class="Poppins-Regular f-16 color-31"><?php echo $event_data['ticket_currency'].' '.$event_data['ticket'];?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="Poppins-Semi-Bold f-20 color-31">Total</p>
                                </div>
                                <div class="col-xs-6">
                                    <p class="Poppins-Regular f-16 color-31"><?php $total = $no_of_ticket *$event_data['ticket'];echo $event_data['ticket_currency'].' '.$total;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="Poppins-Semi-Bold f-20 color-31"><?php echo $tax_name;?>(<?php echo $service_tax_per;?>%)</p>
                                </div>
                                <div class="col-xs-6">
                                    <p class="Poppins-Regular f-16 color-31"><?php  $service_tax_amt = ($total * $service_tax_per) / 100;echo $event_data['ticket_currency'].' '.$service_tax_amt;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="Poppins-Semi-Bold f-20 color-31">Payment</p>
                                </div>
                                <div class="col-xs-6">
                                    <p class="color-3cb Poppins-Semi-Bold f-16"><?php $total_payment = $service_tax_amt + $total;echo $event_data['ticket_currency'].' '.$total_payment;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--for Mobile Device Table End-->
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <p class="calibri-Bold-font f-22 color-31 t-transform-ue pt-4">Confirmation <span class="color-d">Details</span></p>
                    </div>
                    <div class="confirmation-box">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="alert alert-warning">Event Tickets information will be send to this email id</div>
                            	<form action="<?php echo $base_url; ?>event/pay_now" name="event_transaction_form" method="post" id="event_transaction_form">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <p class="Poppins-Medium f-16 color-31 ad-name">E-mail *:</p>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="add-input">
                                            <input type="email" class="form-control ni-input" required name="confirm_email" placeholder="Enter Your Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <p class="Poppins-Medium f-16 color-31 ad-name">Contact No *:</p>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <select name="country_code" id="country_code" class="mdb-select md-form md-outline colorful-select dropdown-primary ni-input2 event-box-t l-17">
											<?php echo $this->common_model->country_code_opt($val);?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="add-input">
                                            <input type="text" class="form-control ni-input" required name="confirm_mobile" id="confirm_mobile" minlength="8" maxlength="12" placeholder="Enter Your Contact Number">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="three" value="">
                                <div class="row pt-4">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <p class="Poppins-Medium f-16 color-31 ad-name">Hear about us?:</p>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="add-input">
                                            <select data-placeholder="Please Select" class="chosen-select form-control new-chosen-height" required name="user_how_hear" tabindex="4" >
                                                <option value="">Please select</option>
                                                <option value="google">Google</option>
                                                <option value="flyer">Flyer</option>
                                                <option value="word of mouth">Word of Mouth</option>
                                                <option value="search engine">Search Engine</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <div class="col-md-offset-3 col-sm-12 col-xs-12 text-center-sm">
                                        <div class="mt-3">
                                            <input type="submit" class="add-w-btn Poppins-Medium color-f f-18" value="Continue">
                                        </div>
                                    </div>
                                </div>
                                <?php $event_id = $event_data['event_id'];
								$event_date = $this->common_model->displayDate($event_data['event_date'],' jS F - Y');
								$event_title = $event_data['title'];
								$location = $event_data['location'];
								$unit_price = $event_data['ticket'];
								$no_of_tickets = $no_of_ticket;
								$ticket_currency = $event_data['ticket_currency'];
								$total_amount = $total_payment;			
								$data_array = array('event_id'=> $event_id,'event_date'=>$event_date,'title'=>$event_title,'location'=>$location,'unit_price'=>$unit_price,'no_of_tickets'=>$no_of_tickets,'tax_name'=>$tax_name,'service_tax_per'=>$service_tax_per,'service_tax_amt'=>$service_tax_amt,'total_amount'=>$total_amount,'ticket_currency'=>$ticket_currency);
								
								$this->session->set_userdata('event_payment_session',$data_array);?>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
							</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-sm hidden-xs pr-pro-0">
                <div class="event-checkout-add">
                    <div class="line-dot222">
                        <ul class="checkout-sidebar">
                            <li class="Poppins-Medium f-18 color-f check-shape">
                                <a href="javascript:void(0);">Send Emails directly</a>
                            </li>
                            <li class="Poppins-Medium f-18 color-f check-shape mt-2">
                                <a href="javascript:void(0);">Connect instantly via Shaadi Chat</a>
                            </li>
                            <li class="Poppins-Medium f-18 color-f check-shape mt-2">
                                <a href="javascript:void(0);">Initiate Calls / Send SMS</a>
                            </li>
                            <li class="Poppins-Medium f-18 color-f check-shape mt-2">
                                <a href="javascript:void(0);">Access detailed Profiles</a>
                            </li>
                            <li class="Poppins-Medium f-18 color-f check-shape mt-2">
                                <a href="javascript:void(0);">Get Noticed by more Members</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php echo $this->common_model->display_advertise('Level 1');?>
            </div>
        </div>
    </div>
<?php
$this->common_model->js_extra_code_fr.="
if($('#event_transaction_form').length > 0)
{
	$('#event_transaction_form').validate({
		rules: {
			confirm_mobile: {
			  required: true,
			  number: true
			},
		 },	
		submitHandler: function(form)
		{
			return true;
		}
	});
}";?>