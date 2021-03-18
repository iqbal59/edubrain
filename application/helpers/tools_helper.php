<?php


	//security of input , already implemented in input library
	function secure_input($string){
        return htmlspecialchars(stripslashes(trim($string)));    
	}
	///////////////////////////////////////////////////
	//seo friendly url
	function seo_url($string,$dash_separated=true){
        //Lower case everything
        $string = strtolower(trim($string));
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/\s-+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        //finally convert multiple dashes to single dash
        $string = preg_replace("/-+/", "-", $string);
        if($dash_separated==false){
            //remove dashes from the string
            $string = preg_replace("-", "", $string);        
        }
        return $string;
	}
	//create file from an array
	function save_array_file($file_name,$array,$save_path,$mode=''){
        file_put_contents($file_name,serialize($array));
        copy($file_name,$save_path.$file_name);unlink($file_name);
        clearstatcache();   
	}

	//create file from an array
	function get_file_array($file_name,$path,$mode=''){
        $file=$path.$file_name;
        return unserialize(file_get_contents($file));   
	}

	// Checks if a folder exist and return canonicalized absolute pathname (long version)
	function is_dir_exist($folder){ 
        // Get canonicalized absolute pathname
        $path = realpath($folder);
        // If it exist, check if it's a directory
        if($path !== false AND is_dir($path))
        {   // Return canonicalized absolute pathname
            return $path;
        }
        // Path/folder does not exist
        return false;
	}
    //check directory size
    function get_dir_size($directory,$file_ext='*',$format=''){
        //onle-liner solution. Result in bytes.
        // this funcation can be used insted $size=array_sum(array_map('filesize', glob("{$dir}/*.*")));
        //Added bonus: can simply change the file mask to whatever, and count only certain files (eg by extension).
        $size = 0;
        $formatedsize=0;
        $files= glob($directory.'/*.'.$file_ext);
        foreach($files as $path){
            is_file($path) && $size += filesize($path);
            is_dir($path) && get_dir_size($path);
        }
        switch(strtolower($format)){
            case 'k' : $formatedsize=number_format($size/(1024),0); break;
            case 'm' : $formatedsize=number_format($size/(1024*1024),1); break;
            case 'g' : $formatedsize=number_format($size/(1024*1024*1024),3); break;
            default : $formatedsize=number_format($size,0); break;
        }
        return $formatedsize;
    }
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Copy a file, or recursively copy a folder and its contents
	function xcopy($source, $dest, $permissions = 0755){
        // Check for symlinks
        if (is_link($source)) {        return symlink(readlink($source), $dest);    }
        // Simple copy for a file
        if (is_file($source)) {        return copy($source, $dest);    }
        // Make destination directory
        if (!is_dir($dest)) {        mkdir($dest, $permissions);    }
        // Loop through the folder
        $dir = dir($source);    
        while (false !== ($entry = $dir->read())) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {   continue;        }
            // Deep copy directories
            xcopy("$source/$entry", "$dest/$entry", $permissions);
        }	
        // Clean up
        $dir->close();
        return $source.' copied.<br>';
	}
    //remove directory & file and files in the directory recursively.
    function xdelete($target) {
        if(is_dir($target)){
            if(file_exists($target.'.htaccess')){unlink( $target.'.htaccess' );  }
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
            foreach( $files as $file ){xdelete( $file ); }
            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );  
        }
    }
    //remove directory & file and files in the session directory recursively.
    function xdeleteSession($target,$ignore) {
        $dirs = glob( $target . '*', GLOB_MARK ); //GLOB_MARK add slash directories returned
        foreach( $dirs as $dir ){
            if(is_dir($dir)){
                if (strpos($dir, $ignore) !== false){continue;}
                $files = glob( $dir . '*', GLOB_MARK ); //GLOB_MARK add slash directories returned
                foreach( $files as $file ){
                    unlink($file); 
                }
                rmdir($dir);
            }
        }
    }
	//Detect the server protocol
	function get_server_protocol(){
        $protocol = 'http://';    
        if (isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        }    
        return $protocol;
	}

	//GET BASE64_ENCODE(D) STRING
	function encode64($string) {
        $string=  base64_encode($string);
        //convert = to whitespace
        $string = preg_replace("/=+/", "", $string);
        return $string;
	}
 
	//GET BASE64_DECODE(D) STRING
	function decode64($string) {
        $string= base64_decode($string, TRUE);
        return $string;
	}
	//get random hax color
	function get_random_hax_color($shade=''){
        switch ($shade) {
            case 'dark': {
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a');
                $len=count($rand)-1;
                $color = '#'.$rand[rand(0,$len)].$rand[rand(0,$len)].$rand[rand(0,$len)].$rand[rand(0,$len)].$rand[rand(0,$len)].$rand[rand(0,$len)];
                return $color;
            }
            break;
            case 'light': {
                $rand = array('8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $len=count($rand)-1;
                $color = '#'.$rand[rand(0,$len)].$rand[rand(0,$len)].$rand[rand(0,$len)].$rand[rand(0,$len)].$rand[rand(0,$len)].$rand[rand(0,$len)];
                return $color;
            }
            break;
            
            default:{
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                return $color;
            }
            break;
        }
	}
    //get month number
    function get_month_number($month=1,$year=2017){
        $total_months=intval($year-1)*12;
        $total_months+=intval($month);
        return $total_months;
    }
    //get week number number
    function get_week_of_year($day='',$month='',$year=''){
        empty($day) ? $day =intval(date('d')) : $day=intval($day);
        empty($month) ? $month =intval(date('m')) : $month=intval($month);
        empty($year) ? $year =intval(date('m')) : $year=intval($year);
        return intval(date("W", strtotime("$year-$month-$day")));
    }
	// GET ARRAY FROM STRING  
	function string_to_array($string, $opt=','){return explode($opt, $string);}
	// GET STRING FROM ARRAY
	function array_to_string($array, $opt=','){$string='';        
        foreach ($array as $var){if(is_array($var)){$string.=array_to_string($var,$opt);}else{$string.=$var.$opt.' ';}}        
        return $string;
        //alternatively return implode($opt, $array);
	}

	//get month string by providing the the month number
	function month_string($key=1, $short=false){
    	$month=array();	$short_month=array();
    	$month[1]="January";$month[2]="Febraury";$month[3]="March";$month[4]="April";$month[5]="May";$month[6]="June";
    	$month[7]="July";$month[8]="August";$month[9]="September";$month[10]="October";$month[11]="November";$month[12]="December";
    	$short_month[1]="Jan";$short_month[2]="Feb";$short_month[3]="Mar";$short_month[4]="Apr";$short_month[5]="May";
    	$short_month[6]="June";$short_month[7]="Jul";$short_month[8]="Aug";$short_month[9]="Sep";$short_month[10]="Oct";
    	$short_month[11]="Nov";$short_month[12]="Dec";
    	if($short){return $short_month[intval($key)];}else{return $month[intval($key)];}	
	}
	//GET FUTURE DATE BY ADDING DAYS TO CURRENT DATE
	function get_future_date($days){
		$date=date('d-M-Y');
		$future_date=date('d-M-Y',strtotime($date.'+'.$days.' days'));
		return $future_date;		
	}
	//GET FUTURE JD BY ADDING DAYS TO CURRENT JD
	function get_future_jd($days){
		$today=juliantojd(date('m'), date('d'), date('Y'));
		return $today+$days;	
	}
	//GET JD FROM DATE
	function get_jd_from_date($dd_MM_YYYY, $opt="-", $str_month=true){
            if(empty($dd_MM_YYYY)){return 0;}
            $date=$dd_MM_YYYY;
            $arr=explode($opt,$date);
            $day=intval($arr[0]);$month=intval($arr[1]);$year=intval($arr[2]);
            if($str_month){$month_str=$arr[1];$month=intval(date("n",strtotime($month_str)) );}
            return juliantojd($month,$day,$year);	
	}
	//GET FUTURE DATE FROM JD
	function get_date_from_jd($jd){
            $date=jdtojulian($jd);  //date=mm/dd/YYYY
            $arr=explode("/",$date);
            $month=date("M", mktime(null, null, null, $arr[0], 1)); //arr[0]=month
            return $arr[1].'-'.$month.'-'.$arr[2]; //   dd-MM-YYYY
	}
    //GET AGE FROM DATA
    function get_age($date,$result='all',$output='string'){
            $diff=date_diff(date_create($date), date_create('now'));
            switch (strtolower($result)) {
                case 'years':
                    if($output=='string'){return $diff->y.' years';}else{return $diff->y;}
                    break;
                case 'months':
                    if($output=='string'){return $diff->m.' months';}else{return $diff->m;}
                    break;
                case 'days':
                    if($output=='string'){return $diff->d.' days';}else{return $diff->d;}
                    break;
                
                default:{
                    return $diff->y.' years, '.$diff->m.' months, '.$diff->d.' days';
                }
                break;
            }
    }
	//GET DAY OF MONTH FROM DATE
	function get_day_from_date($dd_MM_YYYY, $opt="-"){
            if(empty($dd_MM_YYYY)){return 0;}
            $date=$dd_MM_YYYY;$arr=explode($opt,$date);$day=intval($arr[0]);
            return $day;	
	}	
	//GET MONTH FROM DATE
	function get_month_from_date($dd_MM_YYYY, $opt="-", $str_month=true){
            if(empty($dd_MM_YYYY)){return 0;}
            $date=$dd_MM_YYYY;$arr=explode($opt,$date);$month=intval($arr[1]);
            if($str_month){$month_str=$arr[1];$month=intval(date("n",strtotime($month_str)) );}
            return $month;	
	}
	//GET YEAR FROM DATE
	function get_year_from_date($dd_MM_YYYY, $opt="-"){
            if(empty($dd_MM_YYYY)){return 0;}
            $date=$dd_MM_YYYY;$arr=explode($opt,$date);$year=intval($arr[2]);
            return $year;	
	}
	//calculate seconds of days
	function cal_seconds($days){
            $oneday=60*60*24;
            return $days*$oneday;
	}
	//get unix day count
	function get_unix_day_count($year="",$month="",$day=""){
            $y=intval(date('Y'));$m=intval(date('m'));$d=intval(date('d'));
            if(!empty($year) && $year>0 && !empty($month) && $month>0 && !empty($day) && $day>0){
                $y=intval($year);$m=intval($month);$d=intval($day);                
            }
            $unix_date=new DateTime("1970-01-01");
            $date=new DateTime($y."-".$m."-".$d);
            $difference=$unix_date->diff($date);
            return intval($difference->days);
	}	

    //get unix day count
    function get_unix_timestamp($date="",$time=""){
            if(empty($date)){$date=date('Y-m-d');}
            if(empty($time)){$time=date('H:i:s');}else{$time.=':00';}
            $d = new DateTime($date.' '.$time, new DateTimeZone(date_default_timezone_get()));
            return $d->getTimestamp();
    }   
	//GET DAYS IN A MONTH BY PROVIDING MONTH AND YEAR
    function days_in_month($m,$y){
        $month=trim($m);$year=trim($y);
        $days = ($month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31));
        return $days;
    }
    //RETURN BOOLEAN AFTER DATE CALCULATION
    function is_past_date($year,$month,$day,$hour,$minute=''){
            $cdate=$day.'-'.$month.'-'.$year;
            $jd=$this->get_jd_from_date($cdate);    
            $chour=intval(date('H'));
            $cminute=intval(date('i'));
            if(empty($minute)){
            if($jd<=$this->todayjd && $hour<=$chour){return TRUE;}else{return FALSE;}
            }else{
            if($jd<=$this->todayjd && $hour<=$chour && $minute<=$cminute){return TRUE;}else{return FALSE;}      
            }
                
    }
	// GET RANDOM STRING
    function get_random_string($len=8,$numeric=false,$special_chars=false){
		$string="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		if($numeric){$string.="0123456789";}
		if($special_chars){$string.="#!@^-~";}
        return substr(str_shuffle($string), 0, $len);
    } 
    //RETURE CLEANED STRING
    function clean_string($string='',$chars=array(' ','-','_',',')){
        $string=trim($string);
        foreach ($chars as $key => $value) {
            $string=str_replace($value, '', $string);
        }
        return $string;
    }
    /**
     * Get Youtube video ID from URL
     *
     * @param string $url
     * @return mixed Youtube video ID or FALSE if not found
     */
    function getVideoIdFromUrl($url,$host='youtube') {
        switch (strtolower($host)) {
            case 'vimeo':{

            }
            break;
            //default is youtube
            default:{

                $link = $url;
                 $parts = parse_url($link);
                if(isset($parts['query'])){
                    parse_str($parts['query'], $qs);
                    if(isset($qs['v'])){
                        return $qs['v'];
                    }else if(isset($qs['vi'])){
                        return $qs['vi'];
                    }
                }
                if(isset($parts['path'])){
                    $path = explode('/', trim($parts['path'], '/'));
                    return $path[count($path)-1];
                }else{
                    $video_id = explode("?v=", $link);
                    if (!isset($video_id[1])) {
                        $video_id = explode("youtu.be/", $link);
                    }
                    $youtubeID = $video_id[1];
                    if (empty($video_id[1])) $video_id = explode("/v/", $link);
                    $video_id = explode("&", $video_id[1]);
                    $youtubeVideoID = $video_id[0];
                    if ($youtubeVideoID) {
                        return $youtubeVideoID;
                    } else {                    
                        return false;
                    }
                }
            }
            break;
        }
        
    }
    //convert array to get url
    function arrayToUrl($data){
        $url="";
        foreach ($data as $key => $value) {
            $url.="&".urlencode($key)."=".urlencode($value);
        }
        return $url;
    }    
    //currency converter
    function get_converted_amount($amount,$conversion_rate=1,$string_output=false,$symbol='$'){
        $converted_amount=$amount*$conversion_rate;
        if($string_output){
            return $symbol.$converted_amount;
        }else{
            return $converted_amount;
        }
    }    
    //return counting position string
    function get_ordinal_symbol($number){
        $position='';
        if(strlen($number.'')>0){ 
            $last=substr($number.'', -1);
            switch (intval($last)) {
                case 0:{$position='';}break;
                case 1:{if(intval(substr($number.'', -2))==11){$position=$number.'th';}else{$position=$number.'st';} }break;
                case 2:{if(intval(substr($number.'', -2))==12){$position=$number.'th';}else{$position=$number.'nd';} }break;
                case 3:{if(intval(substr($number.'', -2))==13){$position=$number.'th';}else{$position=$number.'rd';} }break;            
                default:{$position=$number.'th';}break;
            }
        }
        return $position;
    }

    //update file content
    function update_file_text($file,$find,$replace){
        file_put_contents($file,str_replace($find,$replace,file_get_contents($file)));
    }
    //extract domain name from url
    function extractDomain($url) { 
       $parseUrl = parse_url(trim($url)); 
       if(isset($parseUrl['host'])){
           $host = $parseUrl['host'];
       }else{
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
       }
       return trim(clean_string($host,array('www.','http://wwww.','https://www.')) ); 
    } 
    //return short string 
    function hide_string($str,$maxlen=4,$symbol=".",$multiplier=4){
        if(mb_strlen($str)>$maxlen){
            return mb_substr($str, 0,$maxlen).str_repeat($symbol, $multiplier);
        }else{
            return $str.str_repeat($symbol, $multiplier);
        }
    }
    //return time in ago format 
    function ago_time($time){
        $seconds=time()-$time;
        $response="";
        if($seconds<60){
            $response='just now';
        }elseif($seconds>60 && $seconds < 60*60){
            $response=intval($seconds/60)." minutes ago";
        }elseif($seconds>60*60 && $seconds < 60*60*24){
            $response=intval($seconds/(60*60))." hours ago";
        }
        return $response;
    }
    //return seconds in human understanding format  
    function human_time($seconds){
        $seconds=intval($seconds);
        $result="";
        $hrs=0;$mins=0;$sec=0;
        if($seconds>=60*60){$hrs=floor($seconds/(60*60));$seconds-=$hrs*60*60;}
        if($seconds>=60 && $seconds < 60*60){$mins=floor($seconds/60);$seconds-=$mins-60;}
        if($seconds<=60){$sec=ceil($seconds);}
        if($hrs>0){$result.=$hrs.' hour';$mins>0 || $sec>0 ? $result.='s, ':' ';}
        if($mins>0){$result.=$mins.' mins';$sec>0 ? $result.=', ':' ';}
        if($sec>0){$result.=$sec.' sec';}
        return $result;
    }

    //return minutes passed in a day
    function day_minutes_passed(){ 
        $timezone=new DateTimeZone( 'Asia/Karachi' );
        $now=new DateTime( 'now', $timezone );
        $midnight=new DateTime( date('Y-m-d H:i:s', strtotime('12.00am') ), $timezone );
        $diff = $now->diff( $midnight );
        $mins=( intval( $diff->format('%h') ) * 60 ) + intval( $diff->format('%i') );
        return $mins;
    }
    //return minutes passed in a day
    function day_minutes_remaining(){ 
        $timezone=new DateTimeZone( 'Asia/Karachi' );
        $now=new DateTime( 'now', $timezone );
        $midnight=new DateTime( date('Y-m-d H:i:s', strtotime('11.59pm') ), $timezone );
        $diff = $now->diff( $midnight );
        $mins=( intval( $diff->format('%h') ) * 60 ) + intval( $diff->format('%i') );
        return $mins;
    }
    
    //return minutes from time formate 00:00
    function get_minutes_from_time($time='',$now=true){ 
        if($now && empty($time)){$time=date('H:i');}
        $time_array=explode(':',$time);
        $minutes=(intval($time_array[0])*60)+intval($time_array[1]);
        if($minutes>(24*60)-1){$minutes=(24*60)-1;}
        return $minutes;
    }
    
    //return minutes from time formate 00:00
    function get_time_from_minutes($minutes='',$now=true,$am_pm=false){ 
        if($now && empty($minutes)){return date('H:i');}
        if($minutes<0){$minutes=0;}
        if($minutes>(24*60)-1){$minutes=(24*60)-1;}
        $mins=intval($minutes%60);
        $hrs=intval(($minutes-$mins)/60);
        if($am_pm){
            $ampm=" AM";
            if($hrs>12){$ampm=" PM";$hrs-=12;}
            return sprintf("%02d", $hrs).':'.sprintf("%02d", $mins).$ampm;
        }else{
            return sprintf("%02d", $hrs).':'.sprintf("%02d", $mins);            
        }
    }
    
    //check if array is associative array
    function has_string_keys(array $array) {
      return count(array_filter(array_keys($array), 'is_string')) > 0;
    }
    //return esecape html
    function escape_html($html,$decrypt=true) {
        if($decrypt){$html=real_html($html);}
        return htmlspecialchars($html);
    }
    //return decoded html
    function real_html($html) {
        $html=str_replace("<script>", "<scrpt>", $html);
        $html=str_replace("onerror=", "onerr=", $html);
        $html=str_replace("location=", "locations=", $html);
        $html=str_replace("window.location=", "win.locations=", $html);
        $html=str_replace("alert(=", "alrt(=", $html);
        $html=str_replace("window.alert=", "win.alrt=", $html);
        return html_entity_decode(htmlspecialchars_decode($html));
    }

    //return html tags
    function strip_question($html) {
        return strip_tags(htmlspecialchars_decode(html_entity_decode($html)),"<b><img>");
    }