<section id="authPage">

<div class="wrap">

	<div id="icon-users" class="icon32 icon32-posts-post"><br></div>
	<h2>Welcome! please login to your account</h2>
	<br/>

    <div class="metabox-holder">
        <div class="postbox-container">
            <div class="postbox">
                <h3 class="hndle">Login</h3>

                <div class="inside">
                    <form id="notelr-login-form">
                        <ul>
                            <li>
                                <label for="notelr-login-email">Email:</label>
                                <input type="email" id="notelr-login-email" name="notelr-login-email"/>
                            </li>
                            <li>
                                <label for="notelr-login-password">Password:</label>
                                <input type="password" id="notelr-login-password" name="notelr-login-password"/>
                            </li>
                            <li>
                                <input type="submit" name="submit" value="Login" class="button-primary submit"/>
                            </li>
                        </ul>
                    </form>
                    <p>If you already have an account on <a href="http://notelr.com" target="_blank">notelr.com</a> you can use it here too</p>
                </div>
            </div>
        </div>
    </div>

    <div style="display:block; clear:both;"></div>

    <div class="metabox-holder">
        <div class="postbox-container">
            <div class="postbox">
                <h3 class="hndle">Sign-up</h3>

                <div class="inside">

                    <form
                        id="notelr-send-email-form"  <?php if (!empty($this->userId)) {
                        echo 'style="display: none"';
                    } ?>>
                        <p>Don't have an account yet?<br/>Sign-up only takes 2 minutes...</p>
                        <ul>
                            <li>
                                <label for="notelr-send-email">Email:</label>
                                <input required type="email" id="notelr-send-email" name="notelr-send-email"/>
                            </li>
                            <li>
                                <input type="submit" name="submit" value="Submit" class="button-primary submit"/>
                            </li>
                        </ul>
                    </form>

                    <form id="notelr-create-user-form" <?php if (empty($this->userId)) {
                        echo 'style="display: none"';
                    } ?>>

                        <div id="notelr-email-options" <?php if (empty($this->email)) {
                            echo 'style="display: none"';
                        } ?>>
                            <p>Email sent to <span id="notelr-email"><?php echo $this->email; ?></span></p>
                            <a id="notelr-resend-email" class="button-secondary">Resend email</a>
                            <a id="notelr-change-email" class="button-secondary">Change email</a>
                        </div>
                        <p>Please check your email and fill-in the details below to create your account</p>
                        <ul>
                            <li>
                                <label for="notelr-register-key">Confirmation code:</label>
                                <input type="text" id="notelr-register-key" name="notelr-register-key"/>
                            </li>
                            <li>
                                <label for="notelr-register-username">Username:</label>
                                <input type="text" id="notelr-register-username" name="notelr-register-username"/>
                            </li>
                            <li>
                                <label for="notelr-register-name">Name:</label>
                                <input type="text" id="notelr-register-name" name="notelr-register-name"/>
                            </li>
                            <li>
                                <label for="notelr-register-password">Password:</label>
                                <input type="password" id="notelr-register-password" name="notelr-register-password"/>
                            </li>
                            <li>
                                <input type="submit" name="submit" value="Sign-up" class="button-primary submit"/>
                            </li>
                        </ul>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</section>