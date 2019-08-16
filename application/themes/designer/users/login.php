<section class="flat-row">
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-container">
                    <div class="login-logo">
                        <img class="rounded img-responsive" src="<?php echo loadAsset('img/loginlogo.png') ?>" />
                    </div>
                    <div class="login-img-circle">
                        <img class="img-responsive circle-img" src="<?php echo loadAsset('img/loginicon1.png') ?>" />
                    </div>
                    <form class="form-signin" method="post">
                        <div class="form-group">
                            <input name="identity" type="email" class="form-control" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <input name="password" type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group form-check">
                            <input name="remember" type="checkbox" class="form-check-input">
                            <label class="form-check-label">Remember me</label>
                        </div>
                        <button class="btn btn-lg btn-block btn-login" type="submit">LOGIN</button>
                        <p class="pt-3 black-text">
                          <a href="#">Need help signin?</a>
                        </p>
                    </form>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</section>