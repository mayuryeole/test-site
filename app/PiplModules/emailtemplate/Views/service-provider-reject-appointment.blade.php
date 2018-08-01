<body>
	<section class="email" style="border: 1px solid #e5e5e5; box-shadow: 0 0 10px #e5e5e5; margin: 50px auto; padding: 10px 10px 15px; width: 50%;">
    	<table class="table" width="100%" cellspacing="0">
        	<tr>
            	<td style="padding:5px 10px; height:50px; border-bottom:1px solid #e5e5e5;">
                    <img src="../img/logo.png" alt="logo" width="150px" style="position: absolute;left: 0px;right: 0px;margin: 0px auto;top: 70px;" >
                </td>
                <td style="padding:5px 10px; height:50px; border-bottom:1px solid #e5e5e5;">
                	<h3 style="margin:0; text-align:right; font-size:22px; color:#28A948; text-transform:uppercase;">
                    </h3>
                </td>
            </tr>
        </table>
       
        <table class="table" width="100%" cellspacing="0" cellpadding="0" style="margin:30px 0 0; padding:0px 0px;">
        	<tr>
            	<td>
                	<div class="feedback">
                    	<div class="in-feedback"style="padding: 0px 10px;">
                    	
                        <div class="feedback-cust" style=" position: relative;top: 0px;">
                        	<p style=" line-height: 24px;color: #333;position: relative; top: -30px;text-align:center;">
                            	<span class="dear" style="font-weight:bold;">Hello {{$FIRST_NAME}} {{$LAST_NAME}},</span>
 				Your appointment is rejected by your counselor  {{$COUNSELOR_NAME}},<br />
                                
    
				Booking Id - {{$APPOINTMENT_ID}} <br />
                                
                                Counselor - {{$COUNSELOR_NAME}} <br />

				Date - {{$APPOINTMENT_DATE}}<br />
                                
				Time slot- {{$TIME_SLOT}}<br />

				Wishing you an exhilarating experience<br />

				Warm regards
				
				Thanks,&nbsp; 
				{{$SITE_TITLE}}
				</p>
                            
                        </div>
                        </div>
                    </div>
                </td>
            </tr>
           
            </tr>
        </table>
        
        
        
    </section>
</body>



