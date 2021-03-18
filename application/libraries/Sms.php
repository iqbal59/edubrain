<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms{
	protected $CI;
	
	//constructor of the class, optional params will loading the class
	public function __construct($config = array())
        {
            //assign the codeIgniter super-object
			$this->CI =& get_instance();
        }

	//////////////////////////////////////////////////
	//return sms text area
	public function get_sms_textarea($is_new=true){
		$result='';
		if($is_new){
			$result='
			<textarea ng-show="appConfig.isAscii===true" rows="6" class="form-control" placeholder="Write Message" ng-model="message" ng-keyup="validateMessage()"></textarea>
			<textarea ng-show="appConfig.isAscii===false" rows="6" class="form-control" dir="rtl" placeholder="یہاں میسیج لکھیں" ng-model="message" ng-keyup="validateMessage()"></textarea>
		    <span class="help-block text-muted ml-1">Message Characters : {{message.length}}</span>
			<span class="help-block text-muted float-right mr-1">Message Count:{{message.length | roundMsg : appConfig.isAscii}}</span>        
    		';
		}else{
			$result='
			<textarea ng-show="appConfig.isAscii===true" rows="6" class="form-control" placeholder="Write Message" ng-model="selectedRow.message" ng-keyup="validateMessage()"></textarea>
			<textarea ng-show="appConfig.isAscii===false" rows="6" class="form-control" dir="rtl" placeholder="یہاں میسیج لکھیں" ng-model="selectedRow.message" ng-keyup="validateMessage()"></textarea>
		    <span class="help-block text-muted ml-1">Message Characters : {{selectedRow.message.length}}</span>
			<span class="help-block text-muted float-right mr-1">Message Count:{{selectedRow.message.length | roundMsg : appConfig.isAscii}}</span>        
    		';

		}


        return $result;
    }
	
    //return mobiles text area
    public function get_mobiles_textarea(){
        $result='';
        $result='<textarea class="form-control" ng-model="receiver" placeholder="Enter mobile numbers..." rows="1"  ng-keyup="validateMobile()"></textarea>';
        return $result;
    }
    

    //RETURE CLEANED STRING
    private function clean_string($string='',$chars=array(' ','-','_',',')){
        $string=trim($string);
        foreach ($chars as $char) {
            $string=str_replace($char, '', $string);
	        $string=preg_replace("/".preg_quote($char, '/')."+/", "", $string);
        }
        return $string;
    }

    //RETURN THE SMS SIZE
    public function get_sms_size($sms=""){        
        if(empty($sms)){return 0;}
        $is_ascii_only=$this->is_ascii($sms);
        $len=1;
        if($is_ascii_only){
            $first=160;$rem=153;$chars=strlen($sms); 
            if($chars>$first){$len=ceil($chars/$rem);}        	
        }else{
            $first=70;$rem=67;$chars=mb_strlen($sms,'UTF-8');
            if($chars>$first){$len=ceil($chars/$rem);}            
        }       
        return $len;
    }
    //RETURN THE SMS SIZE
    public function get_chars($sms=""){        
        if(empty($sms)){return 0;}
        $is_asci=$this->is_ascii($sms);
        if($is_asci){
            return strlen($sms);          
        }else{
            return mb_strlen($sms,'UTF-8');        
        }    
    }

    //return true of string is only ascii string
    public function is_ascii( $string = '' ) {
	    return ( bool ) ! preg_match( '/[\\x80-\\xff]+/' , $string );
	}


    //RETURN BOOLEAN AFTER MOBILE VERIFICATION
    public function is_valid_mobile_number_old($number='', $country_code='pk'){
        $is_valid_number=false;
        if(empty($number)){return false;}
        $number=$this->clean_string($number,array(' ','-',',','+'));
        $number=filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT);
        $length=strlen($number);
        switch (strtolower($country_code)){
            case 'pk': {               
                switch ($length){
                    case 10 : { if(substr($number, 0, 1)=='3'){ $is_valid_number=true;} 
                    }break;
                    case 11 : { if(substr($number, 0, 2)=='03'){ $is_valid_number=true;} 
                    }break;
                    case 12 : { if(substr($number, 0, 3)=='923'){ $is_valid_number=true;} 
                    }break;
                    case 13 : { if(substr($number, 0, 4)=='+923'){ $is_valid_number=true;} 
                    }break;
                }
            }break;         
            default:{               
                switch ($length){
                    case 10 : { if(substr($number, 0, 1)=='3'){ $is_valid_number=true;} 
                    }break;
                    case 11 : { if(substr($number, 0, 2)=='03'){ $is_valid_number=true;} 
                    }break;
                    case 12 : { if(substr($number, 0, 3)=='923'){ $is_valid_number=true;} 
                    }break;
                    case 13 : { if(substr($number, 0, 4)=='+923'){ $is_valid_number=true;} 
                    }break;
                }
            }break;
        }
        return $is_valid_number;
    }
    //RETURN STANDARD MOBILE FORM 3XXXXXXXXX
    public function get_standard_mobile_number_old($number='', $country_code='pk'){
        $valid_number='';
        if(empty($number)){return false;}
        $number=$this->clean_string($number,array(' ','-',',','+'));
        $number=filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT);
        $length=strlen($number);
        switch (strtolower($country_code)) {            
            default:{               
                switch ($length) {
                    case 10 : { if(substr($number, 0, 1)=='3'){ $valid_number=$number;} }break;
                    case 11 : { if(substr($number, 0, 2)=='03'){ $valid_number=substr($number,1,strlen($number));} }break;
                    case 12 : { if(substr($number, 0, 3)=='923'){ $valid_number=substr($number,2,strlen($number));} }break;
                    case 13 : { if(substr($number, 0, 4)=='0923' || substr($number, 0, 4)=='+923'){ $valid_number=substr($number,3,strlen($number));} }break;
                }
            }break;
        }
        return $valid_number;
    }
    //GET VALID MOBILE NUMBERS IN AN ARRARY
    public function get_valid_mobiles_array_oldesr($mobiles=array(),$country_code=''){
        $valid_mobiles=array();
        foreach ($mobiles as $mobile){
            if($this->is_valid_mobile_number($mobile, $country_code)){
                array_push($valid_mobiles, $this->get_standard_mobile_number($mobile,$country_code));}
            }
        return $valid_mobiles;
    }
    //RETURN mobile network
    public function get_country_code($country_code='', $plus_code=false){
    	$code='';
        switch (strtolower($country_code)) {  	
        	default:{ $code='92';}break;
        }
        if($plus_code){return '+'.$code;}else{return $code;}
    }

    /////////////////////////////////////////////////////////////////
    //RETURN mobile network
    public function get_mobile_network($networks,$number){
        $net_code='';
        foreach($networks as $row){
            $codelen=strlen($row['dial_code']);
            if(substr($number, 0, $codelen)==$row['dial_code']){
                $net_code=$row['net_code'];break;
            }
        }
        return $net_code;
    }
    //RETURN BOOLEAN AFTER MOBILE VERIFICATION
    public function is_valid_mobile_number($countries,$networks,$number=''){
        $is_valid_number=false;
        if(empty($number)){return false;}
        $number=$this->clean_string($number,array(' ','-',',','+'));
        $number=filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT);
        $length=strlen($number);
        foreach($countries as $country){
            if($is_valid_number){break;}
            if(strtolower($country['country_code'])=='pk'){
                foreach($networks as $network){
                    if($is_valid_number){break;}
                    if($network['country_id']==$country['mid']){
                        $network_code=substr($network['dial_code'], 2, 3);
                        switch ($length){
                            case 10 : { 
                                if(substr($number, 0, 2)==$network_code){
                                    $is_valid_number=true;
                                } 
                            }break;
                            case 11 : { 
                                if(substr($number, 0, 3)=='0'.$network_code){ 
                                    $is_valid_number=true;
                                } 
                            }break;
                            case 12 : { 
                                if(substr($number, 0, 4)=='92'.$network_code){ 
                                    $is_valid_number=true;
                                } 
                            }break;
                            case 13 : { 
                                if(substr($number, 0, 5)=='+92'.$network_code){ 
                                    $is_valid_number=true;
                                } 
                            }break;
                        }
                    }
                }
            }else{                
                foreach($networks as $network){
                    if($is_valid_number){break;}
                    if($network['country_id']==$country['mid']){
                        $network_code=substr($network['dial_code'], 2, 3);
                        if(substr($number, 0, strlen($network['dial_code']))==$network['dial_code'] && $length==$network['number_length']){
                            $is_valid_number=true;
                        } 
                    }
                }               
            }
        }
        return $is_valid_number;
    }
    //RETURN STANDARD MOBILE FORM CCNETCODEMOBILE
    public function get_standard_mobile_number($countries,$networks,$number=''){
        $valid_number='';
        if(empty($number)){return false;}
        $number=$this->clean_string($number,array(' ','-',',','+'));
        $number=filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT);
        $length=strlen($number);

        foreach($countries as $country){
            if(!empty($valid_number)){break;}
            if(strtolower($country['country_code'])=='pk'){
                foreach($networks as $network){
                    if(!empty($valid_number)){break;}
                    if($network['country_id']==$country['mid']){
                        $network_code=substr($network['dial_code'],2,3);
                        $cn_dial_code=$network['dial_code'];
                        switch ($length){
                            case 10 : { 
                                if(substr($number, 0, 2)==$network_code){
                                    $valid_number=$cn_dial_code.substr($number, 2, $length);
                                } 
                            }break;
                            case 11 : { 
                                if(substr($number, 0, 3)=='0'.$network_code){ 
                                    $valid_number=$cn_dial_code.substr($number, 3, $length);
                                } 
                            }break;
                            case 12 : { 
                                if(substr($number, 0, 4)=='92'.$network_code){ 
                                    $valid_number=$cn_dial_code.substr($number, 4, $length);
                                } 
                            }break;
                            case 13 : { 
                                if(substr($number, 0, 5)=='+92'.$network_code){ 
                                    $valid_number=$cn_dial_code.substr($number, 5, $length);
                                } 
                            }break;
                        }
                    }
                }
            }else{
                foreach($networks as $network){
                    if(!empty($valid_number)){break;}
                    if($network['country_id']==$country['mid']){
                        $network_code=substr($network['dial_code'],2,3);
                        $cn_dial_code=$network['dial_code'];
                        if(substr($number, 0, strlen($network['dial_code']))==$network['dial_code'] && $length==$network['number_length']){
                            $valid_number=$cn_dial_code.substr($number, strlen($network['dial_code'])+1, $length);
                        } 
                    }
                }               
            }
        }
        return $valid_number;
    }
    //GET VALID MOBILE NUMBERS IN AN ARRARY
    public function get_valid_mobiles_array($countries,$networks,$mobiles=array() ){
        $valid_mobiles=array();
        foreach ($mobiles as $mobile){
            if($this->is_valid_mobile_number($countries,$networks,$mobile)){
                array_push($valid_mobiles, $this->get_standard_mobile_number($countries,$networks,$mobile));
            }
        }
        return $valid_mobiles;
    }



//end of class	
}
