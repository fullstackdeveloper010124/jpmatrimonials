								<p class="small text-right"><span class="red-only">*</span> All fields are mandatory</p>
								<div class="xxl-16 xl-16 s-16 m-16 xs-16 l-16 margin-top-30 margin-bottom-30 padding-lr-zero-xs margin-top-0-xs" style="">
									<form class="margin-top-30" method="post" id="advertisement_form" name="advertisement_form" enctype="multipart/form-data">		
										<div class="form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-lr-zero-xs">
											<label class="xxl-4 xl-6 m-16 l-6 s-16 xs-16 margin-top-5px">
												Advertise Name <span class="font-red">* </span>:
											</label>
											<div class="xxl-12 xl-10 s-16 xs-16 m-16 l-10">
												<div class="input-group"> <span class="input-group-addon"><i class="fa fa-feed"></i></span>
													<input placeholder="Enter Advertisement Name" id="txt_adname" name="txt_adname" type="text" style="border:1px solid #dfe0e3;z-index:0;" class="form-control input-md" required>
												</div>
											</div>
										</div>
										
										<div class="form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 margin-top-20 padding-lr-zero-xs">
											<label class="xxl-4 xl-6 m-16 l-6 s-16 xs-16 margin-top-5px">
												Advertise Link <span class="font-red">* </span>:
											</label>
											<div class="xxl-12 xl-10 s-16 xs-16 m-16 l-10">
												<div class="input-group"> <span class="input-group-addon"><i class="fa fa-link"></i></span>
													<input type="text" name="link" id="link" style="border:1px solid #dfe0e3;z-index:0;" class="form-control input-md" required>
												</div>
											</div>
										</div>
										
										<div class="form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 margin-top-20 padding-lr-zero-xs">
											<label class="xxl-4 xl-6 m-16 l-6 s-16 xs-16 margin-top-5px">
												Contact Person <span class="font-red">* </span>:
											</label>
											<div class="xxl-12 xl-10 s-16 xs-16 m-16 l-10">
												<div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
													<input type="text" name="contact_person" id="contact_person" style="border:1px solid #dfe0e3;z-index:0;" class="form-control input-md" required>
												</div>
											</div>
										</div>
										
										<div class="form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 margin-top-20 padding-lr-zero-xs">
											<label class="xxl-4 xl-6 m-16 l-6 s-16 xs-16 margin-top-5px">
												Phone <span class="font-red">* </span>:
											</label>
											<div class="xxl-12 xl-10 s-16 xs-16 m-16 l-10">
												<div class="input-group"> <span class="input-group-addon"><i class="fa fa-phone"></i></span>
													<input type="text"  name="phone" id="phone" style="border:1px solid #dfe0e3;z-index:0;" class="form-control input-md" required>
												</div>
											</div>
										</div>
										
										<div class="form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 margin-top-20 padding-lr-zero-xs">
											<label class="xxl-4 xl-6 m-16 l-6 s-16 xs-16 margin-top-5px">
												Advertise Image <span class="font-red">* </span>:
											</label>
											<div class="xxl-12 xl-10 s-16 xs-16 m-16 l-10">
												<input type="file" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" class="form-control" style="padding:5px;" name="file" id="file" />
												<div class="margin-top-10"></div>
												<img id="blah" src="#" class="blah border img-responsive" alt="your image" width="250" height="250" />
											</div>
										</div>
										<div class="clearfix"></div>
										<hr>
										<div class="form-group margin-top-30">
											<div class="text-center">
												<a href="#" class="btn btn-info margin-right-20 margin-right-0-xs" style="box-shadow:3px 3px 0 0 #e2e2e2;">Submit <span class=""></span></a>
												<a href="#" class="btn btn-danger margin-top-15-xs" style="box-shadow:3px 3px 0 0 #e2e2e2;">Cancel <span class=""></span></a>	
											</div>
										</div>
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />                                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                        						   <input type="hidden" name="is_post" id="is_post" value="1"/>
									</form>
									<div class="clearfix"></div>
								</div>
							