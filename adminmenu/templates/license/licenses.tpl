<section>
    <div class="tecSee-overlay-licenses fade show">
        <form class="tecSee-licenses-container d-flex flex-column justify-center" autocomplete="off">
            <div class="content">
            {$licensesFile}
                <div class="form-group">
                    <a class="form-control btn btn-primary btn-icon home"><i class="fas fa-home"></i></a>
                </div>
                <div class="text-center">
                    <h1>Please Enter Your licenses Credentails For Active</h1>
                </div>
                <div class="form-group">
                    <label for='email'>E-mail</label>
                    <input name='email' type="email" class="form-control"  required/>
                </div>
                <div class="form-group">
                    <label for='license'>License</label>
                    <input name='licensekey' type="text" class="form-control" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="form-control btn btn-primary" value="Enable">
                </div>
            </div>
        </form>
    </div>
</section>