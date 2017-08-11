
<?php include_once PATH_APP.'/application/views/includes/header_auth.php'; ?>

            <div class="block small center login">

                <div class="block_head">
                    <div style="padding-left:1em;"><h1><?php echo 'FREE - Admin Login'; ?></h1></div>
                    <div class="bheadr"></div>

                    
                    <ul>
                        <li><a href="/free/">Home</a></li>
                    </ul>
                </div>      <!-- .block_head ends -->


                <div class="block_content">

<?= (ENVIRONMENT != 'production')? "<div class='message warning'><p>You are in ".strtoupper(ENVIRONMENT)."</p></div>": ''; ?>
<?= validation_errors(); ?>
<?= ( isset( $authentication_error ) ) ? $authentication_error : '<div class="message info"><p>Use your Campus ID (or MyCSULB login).</p></div>'; ?>
<?= ( isset( $framework_error ) ) ? $framework_error : ''; ?>
<?= ( isset( $nouser_error ) ) ? $nouser_error : ''; ?>
                   

                    <?= form_open( 'authenticate' ); ?>

                        <p>
                            <label for="username">Campus ID:<span style="color:red">(required)</span></label> <br />
                            <input type="text" class="text" id ="username" name="username" value="<?= set_value( 'username' ); ?>" aria-required required />
                        </p>

                        <p>
                            <label for="password">Password: <span style="color:red">(required)</span></label> <br />
                            <input type="password" class="text" id="password" name="password" value="<?= set_value( 'password' ); ?>" aria-required required />
                        </p>

                        <p>
                            <input type="submit" class="submit" value="Login" /> &nbsp;
                        </p>

                    <?= form_close(); ?>

                </div>      <!-- .block_content ends -->

                <div class="bendl"></div>
                <div class="bendr"></div>

            </div>      <!-- .login ends -->
<? include_once PATH_APP.'/application/views/includes/auth_footer.php';?>
