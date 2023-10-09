    <div class="modal modal-login" <?php if(isset($_REQUEST["error"])&&($_REQUEST["error"]=="login"||$_REQUEST["error"]=="none")) echo ' style="display:block"';?> id="login-modal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="javascript:document.getElementById('login-modal').style.display='none'" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="loginModalLabel" class="modal-title text-center"><?php echo $M_CLICK_LOGIN_ADMIN;?></h4>
                </div>
                <div class="modal-body">
                 
                    <div class="login-form-container">
                 

						<form class="login-form" action="loginaction.php" method="post" onsubmit="return ValidateLoginForm(this)">
							<input type="hidden" name="mod" value="login"/>
						
							<?php
							if(isset($MULTI_LANGUAGE_SITE))
							{
							?>
								<input type="hidden" name="lang" value="<?php echo $this->lang;?>">
							<?php
							}
							
							if(isset($_REQUEST["return_url"]))
							{
							?>
								<input type="hidden" name="return_url" value="<?php echo $_REQUEST["return_url"];?>">
							<?php
							}
							?>

			
                            <div class="form-group email">
                                <label class="sr-only" for="login-email"><?php echo $M_YOUR_EMAIL;?></label>
								<img src="images/icon-user.gif" alt="" class="login-icon"/>
                                <input id="login-email" name="Email" type="text" class="form-control login-email" placeholder="<?php echo $M_YOUR_EMAIL;?>">
                            </div>
                            <div class="form-group password">
                                <label class="sr-only" for="login-password"><?php echo $M_PASSWORD;?></label>
								<img src="images/icon-password.gif" alt="" class="login-icon"/>
                                <input id="login-password" name="Password" type="password" class="form-control login-password" placeholder="<?php echo $M_PASSWORD;?>">
                                <p class="forgot-password">
                                   <a class="underline-link" href="<?php echo $this->mod_link("forgotten_password");?>"><?php echo $FORGOTTEN_PASSWORD;?></a> 
                                </p>
                            </div>
                            <button type="submit" class="btn btn-block btn-green custom-back-color"><?php echo $M_LOGIN;?></button>
                        
                        </form>
                    </div>
					
					<br/>
					
					<?php
					if($this->GetParam("ENABLE_FACEBOOK_LOGIN")==1||$this->GetParam("ENABLE_TWITTER_LOGIN")==1||$this->GetParam("ENABLE_LINKEDIN_LOGIN")==1)
					{
					?>
						<div class="divider"><span><?php echo $M_OR;?></span></div>
					<?php
					}
					?>
					
					<div class="text-center">
						<?php
						if($this->GetParam("ENABLE_FACEBOOK_LOGIN")==1)
						{
						?>
							<a href="index.php?mod=login-facebook<?php if($MULTI_LANGUAGE_SITE) echo "&lang=".$this->lang;?>"><img src="images/facebook-signin.png" height="22" alt=""/></a>
						<?php
						}
						
						if($this->GetParam("ENABLE_TWITTER_LOGIN")==1)
						{
						?>
						
							<a href="<?php echo $this->mod_link("login-twitter");?>"><img src="images/twitter-signin.png" height="22" class="l-margin-10" alt=""/></a>
						<?php
						}
						
						
						if($this->GetParam("ENABLE_LINKEDIN_LOGIN")==1)
						{
						?>
						
							<a href="<?php echo $this->mod_link("login-linkedin");?>"><img src="images/linkedin-signin.png" height="22" class="l-margin-10" alt=""/></a>
						<?php
						}
						?>
					</div>

	
	
                </div>
				
				<br/>
                <div class="modal-footer">
                    <p>
						<strong><?php echo $M_STILL_NO_ACCOUNT;?></strong>
						<br/><br/>
						<a class="underline-link" href="<?php echo $this->mod_link("jobseekers");?>"><?php echo $M_CREATE_JOBSEEKER_ACCOUNT_SHORT;?></a>
						 <?php echo $M_OR;?> 
						<a class="underline-link" href="<?php echo $this->mod_link("employers_registration");?>"><?php echo $M_SIGNUP_EMPLOYER_SHORT;?></a>
					
					</p>                    
                </div>
            </div>
        </div>
    </div>