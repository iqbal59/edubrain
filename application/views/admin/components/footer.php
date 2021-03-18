
    <script src="<?php print $this->RES_ROOT;?>js/vertical-responsive-menu.min.js<?php print $this->FILE_VERSION;?>"></script>
    <script src="<?php print $this->RES_ROOT;?>js/jquery-3.5.1.min.js<?php print $this->FILE_VERSION;?>"></script>
    <script src="<?php print $this->RES_ROOT;?>vendor/bootstrap/js/bootstrap.bundle.min.js<?php print $this->FILE_VERSION;?>"></script>
    <script src="<?php print $this->RES_ROOT;?>vendor/OwlCarousel/owl.carousel.js<?php print $this->FILE_VERSION;?>"></script>
    <script src="<?php print $this->RES_ROOT;?>vendor/semantic/semantic.min.js<?php print $this->FILE_VERSION;?>"></script>
    <script src="<?php print $this->RES_ROOT;?>js/custom.js<?php print $this->FILE_VERSION;?>"></script>  
    <script src="<?php print $this->RES_ROOT;?>js/night-mode.js<?php print $this->FILE_VERSION;?>"></script>  
    <script src="<?php print $this->RES_ROOT;?>js/datepicker.min.js<?php print $this->FILE_VERSION;?>"></script>
    <script src="<?php print $this->RES_ROOT;?>js/i18n/datepicker.en.js<?php print $this->FILE_VERSION;?>"></script>
    
    <script type="text/javascript">
    function showWait(){
      document.getElementById("wait-message").style.visibility = "visible";
    }
    //check key down
    document.onkeydown = function(e) {
        
        //ctrl+p
        if (e.ctrlKey && e.keyCode === 80) {
            publish();
            // your code here
            return false;
        }
    };
    //print function
    function publish(){
            $("#printing-content").printMe({
                    "path" : ["<?php print $this->RES_ROOT;?>css/bootstrap.css","<?php print $this->RES_ROOT;?>css/print.css"],
                });
    }
    tinymce.init({
      selector: '.editor',
      forced_root_block : 'div',
      statusbar: false,
      plugins: '',
      toolbar: '',
      branding: false,
      height: 130,   
      width: '100%'  
    });
    tinymce.init({
      selector: '.editor2',
      forced_root_block : 'div',
      statusbar: false,
      plugins: '',
      toolbar: '',
      branding: false,
      height: 250,   
      width: '100%'  
    });
    tinymce.init({
      selector: '.editor3',
      forced_root_block : 'div',
      statusbar: false,
      plugins: '',
      toolbar: '',
      branding: false,
      height: 350,   
      width: '100%'  
    });
    </script>
</body>

</html>