<?php
class System_setting_M extends MY_Model
{

    protected $_model_name='System_setting_M.php';
	protected $_table_name = 'system_settings';
    private $_required=array('name');  
  
    public $STATUS_VALID='valid';              
    public $STATUS_INVALID='invalid';
    public $LIC_LT='lifetime';
    public $LIC_DT='durable';
    public $LIC_TT='trial';

    public $_ORG_NAME='org_name';           
    public $_ORG_ADDRESS='org_address';            
    public $_ORG_CONTACT_NUMBER='org_contact_number';            
    public $_ORG_LOGO='org_logo';            
    public $_CURRENCY_SYMBOL='currency_symbol';  
    public $_CUSTOM_AUTH_BG='custom_auth_bg';            
    public $_DISABLE_NOTE='disable_note';            
    public $_INSTALL_DATE='install_date';            
    public $_INSTALL_JD='install_jd';            
    public $_INSTALL_YEAR='install_year';            
    public $_INSTALL_VERSION='install_version';            
    public $_NEXT_CHECK_JD='next_check_jd';            
    public $_EXPIRE_DATE='expire_date';            
    public $_EXPIRE_JD='expire_jd';            
    public $_EXPIRE_NOTE='expire_note';            
    public $_LIC_KEY='licencekey';           
    public $_LIC_STATUS='lic_status';           
    public $_LIC_TYPE='lic_type';           
    public $_ENVATO_CODE='envatocode';           
    public $_SMS_VENDOR='sms_vendor';                    
    public $_SMS_TYPE='sms_type'; //brand|nonbrand            
    public $_SMS_LANG='sms_lang';             
    public $_SMS_MASK='sms_mask';             
    public $_SMS_SENDING='sms_sending';//0=disable | 1=enable             
    public $_SMS_API_USERNAME='sms_api_username';             
    public $_SMS_API_KEY='sms_api_key';             
    public $_MAINTENANCE_MODE='maintenance_mode';//0=disable | 1=enable             
    public $_MAINTENANCE_MESSAGE='maintenance_message';             
    public $_MAX_UPLOAD_SIZE='max_upload_size';   
    public $_WS_PUBLISH_TIME='ws_publish_time';     
    public $_WS_MODIFY_TIME='ws_modify_time';     
    public $_WS_VIEWS='ws_views';     
    public $_WS_THEME='ws_theme'; 
    public $_BG_THEME='bg_theme'; 
    ////////////////////////////////////     
    public $_WS_TIMEZONE='ws_timezone';     
    public $_WS_DAILY_QOUTE='ws_daily_qoute';     
    public $_WS_LECTURE_ACTIVE_TIME='ws_lecture_active_time';     
    public $_WS_CHAPTER_WISE_LESSONING='ws_chapter_wise_lessoning';     
    public $_WS_EXAM_STRICT_START_TIME='ws_exam_strict_start_time';     
    public $_WS_EXAM_PRACTICE_TEST='ws_exam_practice_test';     
    public $_WS_LESSON_SCHEDULE='ws_lesson_schedule';     



	function __construct (){
		parent::__construct();                
	}

    //add new row in db table 
    public function add_row($vals=array()){
        //GET ALL THE FIELDS IN ARRAY   
        $db_row=  $this->grab_row($vals);        
        //PERFROM DIFFERENCT CHECKS BEFORE DATA INSERTION (OPTIONAL)
        ////////////////////////////////////////////////////////////////////////
        
        //SAVE DATA INTO DATABASE
        return $this->save_db_row($db_row,$this->_required);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// GETTER FUNCTIONS ////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //GET VALUE FROM KEY
    public function get_setting($key=''){
        if($this->get_rows(array('name'=>$key),'',true)>0){
            return $this->get_by(array('name'=>$key),true)->value;
        }
        return '';
    }       
    
    
    // GET ALL SETTINGS IN ARRAY WITH NAME AS INDEX AND VALUE AS ARRAY VALUE
    function get_settings_array(){
        return $this->get_values_array('name', 'value');        
    }
    
    //SET VALUE OF KEY
    public function save_setting($key='',$value=''){
        if($this->get_rows(array('name'=>$key),'',true)>0){
            //key already exist save value
            $this->save(array('value'=>$value),array('name'=>$key));
        }else{
            //key does not exist yet
            $this->add_row(array('name'=>strtolower($key),'value'=>$value));
        }
    }   
    //SAVE SETTINGS ARRAY
    public function save_settings_array($data=array() ){
        if (count($data)>0) {
            foreach ($data as $key => $value) {
                $this->save_setting($key,$value);
            }
        }
    }    


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// VALIDATION FUNCTIONS ////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
    //get default settings array
    public function get_default_settings(){
        $data=array();
        $data[$this->_ORG_NAME]=''; 
        $data[$this->_ORG_ADDRESS]=''; 
        $data[$this->_ORG_CONTACT_NUMBER]=''; 
        $data[$this->_ORG_LOGO]='default.png'; 
        $data[$this->_CURRENCY_SYMBOL]='$'; 
        $data[$this->_CUSTOM_AUTH_BG]=''; 
        $data[$this->_DISABLE_NOTE]=''; 
        $data[$this->_INSTALL_DATE]=''; 
        $data[$this->_INSTALL_JD]=''; 
        $data[$this->_INSTALL_YEAR]=''; 
        $data[$this->_INSTALL_VERSION]=''; 
        $data[$this->_NEXT_CHECK_JD]=''; 
        $data[$this->_EXPIRE_DATE]=''; 
        $data[$this->_EXPIRE_JD]=''; 
        $data[$this->_EXPIRE_NOTE]=''; 
        $data[$this->_LIC_KEY]=''; 
        $data[$this->_LIC_STATUS]=''; 
        $data[$this->_LIC_TYPE]=''; 
        $data[$this->_ENVATO_CODE]=''; 
        $data[$this->_SMS_VENDOR]=''; 
        $data[$this->_SMS_TYPE]=''; 
        $data[$this->_SMS_LANG]=''; 
        $data[$this->_SMS_MASK]=''; 
        $data[$this->_SMS_SENDING]=''; 
        $data[$this->_SMS_TYPE]=''; 
        $data[$this->_SMS_API_USERNAME]=''; 
        $data[$this->_SMS_API_KEY]=''; 
        $data[$this->_MAINTENANCE_MODE]='0'; 
        $data[$this->_MAINTENANCE_MESSAGE]=''; 
        $data[$this->_CUSTOM_AUTH_BG]=''; 
        $data[$this->_MAX_UPLOAD_SIZE]=''; 
        $data[$this->_WS_VIEWS]='0'; 
        $data[$this->_WS_THEME]='default'; 
        $data[$this->_WS_PUBLISH_TIME]=''; 
        $data[$this->_WS_MODIFY_TIME]=''; 
        $data[$this->_WS_DAILY_QOUTE]=''; 
        $data[$this->_WS_LECTURE_ACTIVE_TIME]='0'; 
        $data[$this->_WS_CHAPTER_WISE_LESSONING]='0'; 
        $data[$this->_WS_TIMEZONE]='Asia/Karachi'; 
        $data[$this->_WS_EXAM_STRICT_START_TIME]='0'; 
        $data[$this->_WS_EXAM_PRACTICE_TEST]='0'; 
        $data[$this->_WS_LESSON_SCHEDULE]=''; 
        $data[$this->_BG_THEME]=''; 

                             
        return $data;
    }
    //process install settings
    public function process_install_settings(){
        $this->init_settings();
        $settings=array();
        $settings[$this->_INSTALL_DATE] = $this->date;
        $settings[$this->_INSTALL_JD] = $this->todayjd;
        $settings[$this->_INSTALL_YEAR] = $this->year;
        $settings[$this->_NEXT_CHECK_JD] = $this->todayjd+30;
        $settings[$this->_MAX_UPLOAD_SIZE] = (1024*5);
        $settings[$this->_WS_THEME] = 'default';
        $settings[$this->_WS_PUBLISH_TIME] = date("Y-m-d").'T'.date("H:i:s+00:00");
        $settings[$this->_WS_MODIFY_TIME] = date("Y-m-d").'T'.date("H:i:s+00:00");
        $this->save_settings_array($settings);
    }

    //reset settings to default
    public function init_settings(){
        $settings=$this->get_default_settings();

        foreach($settings as $key=>$value){
            if($this->get_rows(array('name'=>$key),'',true)<1){
                //create row
                $this->add_row(array('name'=>$key,'value'=>$value));
            }else{
                //update row
                $this->save(array('value'=>$value),array('name'=>$key));

            }

        }
    }

    //recheck settings to default
    public function recheck_settings(){
        $settings=$this->get_default_settings();
        foreach($settings as $key=>$value){
            if($this->get_rows(array('name'=>$key),'',true)<1){
                //create row
                $this->add_row(array('name'=>$key,'value'=>$value));
            }
        }
    }


    //return timezones
    public function get_timezones(){
        $timezones='{
            "Africa\/Abidjan": "Africa\/Abidjan",
            "Africa\/Accra": "Africa\/Accra",
            "Africa\/Addis_Ababa": "Africa\/Addis Ababa",
            "Africa\/Algiers": "Africa\/Algiers",
            "Africa\/Asmara": "Africa\/Asmara",
            "Africa\/Bamako": "Africa\/Bamako",
            "Africa\/Bangui": "Africa\/Bangui",
            "Africa\/Banjul": "Africa\/Banjul",
            "Africa\/Bissau": "Africa\/Bissau",
            "Africa\/Blantyre": "Africa\/Blantyre",
            "Africa\/Brazzaville": "Africa\/Brazzaville",
            "Africa\/Bujumbura": "Africa\/Bujumbura",
            "Africa\/Cairo": "Africa\/Cairo",
            "Africa\/Casablanca": "Africa\/Casablanca",
            "Africa\/Ceuta": "Africa\/Ceuta",
            "Africa\/Conakry": "Africa\/Conakry",
            "Africa\/Dakar": "Africa\/Dakar",
            "Africa\/Dar_es_Salaam": "Africa\/Dar es Salaam",
            "Africa\/Djibouti": "Africa\/Djibouti",
            "Africa\/Douala": "Africa\/Douala",
            "Africa\/El_Aaiun": "Africa\/El Aaiun",
            "Africa\/Freetown": "Africa\/Freetown",
            "Africa\/Gaborone": "Africa\/Gaborone",
            "Africa\/Harare": "Africa\/Harare",
            "Africa\/Johannesburg": "Africa\/Johannesburg",
            "Africa\/Juba": "Africa\/Juba",
            "Africa\/Kampala": "Africa\/Kampala",
            "Africa\/Khartoum": "Africa\/Khartoum",
            "Africa\/Kigali": "Africa\/Kigali",
            "Africa\/Kinshasa": "Africa\/Kinshasa",
            "Africa\/Lagos": "Africa\/Lagos",
            "Africa\/Libreville": "Africa\/Libreville",
            "Africa\/Lome": "Africa\/Lome",
            "Africa\/Luanda": "Africa\/Luanda",
            "Africa\/Lubumbashi": "Africa\/Lubumbashi",
            "Africa\/Lusaka": "Africa\/Lusaka",
            "Africa\/Malabo": "Africa\/Malabo",
            "Africa\/Maputo": "Africa\/Maputo",
            "Africa\/Maseru": "Africa\/Maseru",
            "Africa\/Mbabane": "Africa\/Mbabane",
            "Africa\/Mogadishu": "Africa\/Mogadishu",
            "Africa\/Monrovia": "Africa\/Monrovia",
            "Africa\/Nairobi": "Africa\/Nairobi",
            "Africa\/Ndjamena": "Africa\/Ndjamena",
            "Africa\/Niamey": "Africa\/Niamey",
            "Africa\/Nouakchott": "Africa\/Nouakchott",
            "Africa\/Ouagadougou": "Africa\/Ouagadougou",
            "Africa\/Porto-Novo": "Africa\/Porto-Novo",
            "Africa\/Sao_Tome": "Africa\/Sao Tome",
            "Africa\/Tripoli": "Africa\/Tripoli",
            "Africa\/Tunis": "Africa\/Tunis",
            "Africa\/Windhoek": "Africa\/Windhoek",
            "America\/Adak": "America\/Adak",
            "America\/Anchorage": "America\/Anchorage",
            "America\/Anguilla": "America\/Anguilla",
            "America\/Antigua": "America\/Antigua",
            "America\/Araguaina": "America\/Araguaina",
            "America\/Argentina": "America\/Argentina",
            "America\/Aruba": "America\/Aruba",
            "America\/Asuncion": "America\/Asuncion",
            "America\/Atikokan": "America\/Atikokan",
            "America\/Bahia": "America\/Bahia",
            "America\/Bahia_Banderas": "America\/Bahia Banderas",
            "America\/Barbados": "America\/Barbados",
            "America\/Belem": "America\/Belem",
            "America\/Belize": "America\/Belize",
            "America\/Blanc-Sablon": "America\/Blanc-Sablon",
            "America\/Boa_Vista": "America\/Boa Vista",
            "America\/Bogota": "America\/Bogota",
            "America\/Boise": "America\/Boise",
            "America\/Cambridge_Bay": "America\/Cambridge Bay",
            "America\/Campo_Grande": "America\/Campo Grande",
            "America\/Cancun": "America\/Cancun",
            "America\/Caracas": "America\/Caracas",
            "America\/Cayenne": "America\/Cayenne",
            "America\/Cayman": "America\/Cayman",
            "America\/Chicago": "America\/Chicago",
            "America\/Chihuahua": "America\/Chihuahua",
            "America\/Costa_Rica": "America\/Costa Rica",
            "America\/Creston": "America\/Creston",
            "America\/Cuiaba": "America\/Cuiaba",
            "America\/Curacao": "America\/Curacao",
            "America\/Danmarkshavn": "America\/Danmarkshavn",
            "America\/Dawson": "America\/Dawson",
            "America\/Dawson_Creek": "America\/Dawson Creek",
            "America\/Denver": "America\/Denver",
            "America\/Detroit": "America\/Detroit",
            "America\/Dominica": "America\/Dominica",
            "America\/Edmonton": "America\/Edmonton",
            "America\/Eirunepe": "America\/Eirunepe",
            "America\/El_Salvador": "America\/El Salvador",
            "America\/Fort_Nelson": "America\/Fort Nelson",
            "America\/Fortaleza": "America\/Fortaleza",
            "America\/Glace_Bay": "America\/Glace Bay",
            "America\/Goose_Bay": "America\/Goose Bay",
            "America\/Grand_Turk": "America\/Grand Turk",
            "America\/Grenada": "America\/Grenada",
            "America\/Guadeloupe": "America\/Guadeloupe",
            "America\/Guatemala": "America\/Guatemala",
            "America\/Guayaquil": "America\/Guayaquil",
            "America\/Guyana": "America\/Guyana",
            "America\/Halifax": "America\/Halifax",
            "America\/Havana": "America\/Havana",
            "America\/Hermosillo": "America\/Hermosillo",
            "America\/Indiana": "America\/Indiana",
            "America\/Inuvik": "America\/Inuvik",
            "America\/Iqaluit": "America\/Iqaluit",
            "America\/Jamaica": "America\/Jamaica",
            "America\/Juneau": "America\/Juneau",
            "America\/Kentucky": "America\/Kentucky",
            "America\/Kralendijk": "America\/Kralendijk",
            "America\/La_Paz": "America\/La Paz",
            "America\/Lima": "America\/Lima",
            "America\/Los_Angeles": "America\/Los Angeles",
            "America\/Lower_Princes": "America\/Lower Princes",
            "America\/Maceio": "America\/Maceio",
            "America\/Managua": "America\/Managua",
            "America\/Manaus": "America\/Manaus",
            "America\/Marigot": "America\/Marigot",
            "America\/Martinique": "America\/Martinique",
            "America\/Matamoros": "America\/Matamoros",
            "America\/Mazatlan": "America\/Mazatlan",
            "America\/Menominee": "America\/Menominee",
            "America\/Merida": "America\/Merida",
            "America\/Metlakatla": "America\/Metlakatla",
            "America\/Mexico_City": "America\/Mexico City",
            "America\/Miquelon": "America\/Miquelon",
            "America\/Moncton": "America\/Moncton",
            "America\/Monterrey": "America\/Monterrey",
            "America\/Montevideo": "America\/Montevideo",
            "America\/Montserrat": "America\/Montserrat",
            "America\/Nassau": "America\/Nassau",
            "America\/New_York": "America\/New York",
            "America\/Nipigon": "America\/Nipigon",
            "America\/Nome": "America\/Nome",
            "America\/Noronha": "America\/Noronha",
            "America\/North_Dakota": "America\/North Dakota",
            "America\/Nuuk": "America\/Nuuk",
            "America\/Ojinaga": "America\/Ojinaga",
            "America\/Panama": "America\/Panama",
            "America\/Pangnirtung": "America\/Pangnirtung",
            "America\/Paramaribo": "America\/Paramaribo",
            "America\/Phoenix": "America\/Phoenix",
            "America\/Port-au-Prince": "America\/Port-au-Prince",
            "America\/Port_of_Spain": "America\/Port of Spain",
            "America\/Porto_Velho": "America\/Porto Velho",
            "America\/Puerto_Rico": "America\/Puerto Rico",
            "America\/Punta_Arenas": "America\/Punta Arenas",
            "America\/Rainy_River": "America\/Rainy River",
            "America\/Rankin_Inlet": "America\/Rankin Inlet",
            "America\/Recife": "America\/Recife",
            "America\/Regina": "America\/Regina",
            "America\/Resolute": "America\/Resolute",
            "America\/Rio_Branco": "America\/Rio Branco",
            "America\/Santarem": "America\/Santarem",
            "America\/Santiago": "America\/Santiago",
            "America\/Santo_Domingo": "America\/Santo Domingo",
            "America\/Sao_Paulo": "America\/Sao Paulo",
            "America\/Scoresbysund": "America\/Scoresbysund",
            "America\/Sitka": "America\/Sitka",
            "America\/St_Barthelemy": "America\/St Barthelemy",
            "America\/St_Johns": "America\/St Johns",
            "America\/St_Kitts": "America\/St Kitts",
            "America\/St_Lucia": "America\/St Lucia",
            "America\/St_Thomas": "America\/St Thomas",
            "America\/St_Vincent": "America\/St Vincent",
            "America\/Swift_Current": "America\/Swift Current",
            "America\/Tegucigalpa": "America\/Tegucigalpa",
            "America\/Thule": "America\/Thule",
            "America\/Thunder_Bay": "America\/Thunder Bay",
            "America\/Tijuana": "America\/Tijuana",
            "America\/Toronto": "America\/Toronto",
            "America\/Tortola": "America\/Tortola",
            "America\/Vancouver": "America\/Vancouver",
            "America\/Whitehorse": "America\/Whitehorse",
            "America\/Winnipeg": "America\/Winnipeg",
            "America\/Yakutat": "America\/Yakutat",
            "America\/Yellowknife": "America\/Yellowknife",
            "Antarctica\/Casey": "Antarctica\/Casey",
            "Antarctica\/Davis": "Antarctica\/Davis",
            "Antarctica\/DumontDUrville": "Antarctica\/DumontDUrville",
            "Antarctica\/Macquarie": "Antarctica\/Macquarie",
            "Antarctica\/Mawson": "Antarctica\/Mawson",
            "Antarctica\/McMurdo": "Antarctica\/McMurdo",
            "Antarctica\/Palmer": "Antarctica\/Palmer",
            "Antarctica\/Rothera": "Antarctica\/Rothera",
            "Antarctica\/Syowa": "Antarctica\/Syowa",
            "Antarctica\/Troll": "Antarctica\/Troll",
            "Antarctica\/Vostok": "Antarctica\/Vostok",
            "Arctic\/Longyearbyen": "Arctic\/Longyearbyen",
            "Asia\/Aden": "Asia\/Aden",
            "Asia\/Almaty": "Asia\/Almaty",
            "Asia\/Amman": "Asia\/Amman",
            "Asia\/Anadyr": "Asia\/Anadyr",
            "Asia\/Aqtau": "Asia\/Aqtau",
            "Asia\/Aqtobe": "Asia\/Aqtobe",
            "Asia\/Ashgabat": "Asia\/Ashgabat",
            "Asia\/Atyrau": "Asia\/Atyrau",
            "Asia\/Baghdad": "Asia\/Baghdad",
            "Asia\/Bahrain": "Asia\/Bahrain",
            "Asia\/Baku": "Asia\/Baku",
            "Asia\/Bangkok": "Asia\/Bangkok",
            "Asia\/Barnaul": "Asia\/Barnaul",
            "Asia\/Beirut": "Asia\/Beirut",
            "Asia\/Bishkek": "Asia\/Bishkek",
            "Asia\/Brunei": "Asia\/Brunei",
            "Asia\/Chita": "Asia\/Chita",
            "Asia\/Choibalsan": "Asia\/Choibalsan",
            "Asia\/Colombo": "Asia\/Colombo",
            "Asia\/Damascus": "Asia\/Damascus",
            "Asia\/Dhaka": "Asia\/Dhaka",
            "Asia\/Dili": "Asia\/Dili",
            "Asia\/Dubai": "Asia\/Dubai",
            "Asia\/Dushanbe": "Asia\/Dushanbe",
            "Asia\/Famagusta": "Asia\/Famagusta",
            "Asia\/Gaza": "Asia\/Gaza",
            "Asia\/Hebron": "Asia\/Hebron",
            "Asia\/Ho_Chi_Minh": "Asia\/Ho Chi Minh",
            "Asia\/Hong_Kong": "Asia\/Hong Kong",
            "Asia\/Hovd": "Asia\/Hovd",
            "Asia\/Irkutsk": "Asia\/Irkutsk",
            "Asia\/Jakarta": "Asia\/Jakarta",
            "Asia\/Jayapura": "Asia\/Jayapura",
            "Asia\/Jerusalem": "Asia\/Jerusalem",
            "Asia\/Kabul": "Asia\/Kabul",
            "Asia\/Kamchatka": "Asia\/Kamchatka",
            "Asia\/Karachi": "Asia\/Karachi",
            "Asia\/Kathmandu": "Asia\/Kathmandu",
            "Asia\/Khandyga": "Asia\/Khandyga",
            "Asia\/Kolkata": "Asia\/Kolkata",
            "Asia\/Krasnoyarsk": "Asia\/Krasnoyarsk",
            "Asia\/Kuala_Lumpur": "Asia\/Kuala Lumpur",
            "Asia\/Kuching": "Asia\/Kuching",
            "Asia\/Kuwait": "Asia\/Kuwait",
            "Asia\/Macau": "Asia\/Macau",
            "Asia\/Magadan": "Asia\/Magadan",
            "Asia\/Makassar": "Asia\/Makassar",
            "Asia\/Manila": "Asia\/Manila",
            "Asia\/Muscat": "Asia\/Muscat",
            "Asia\/Nicosia": "Asia\/Nicosia",
            "Asia\/Novokuznetsk": "Asia\/Novokuznetsk",
            "Asia\/Novosibirsk": "Asia\/Novosibirsk",
            "Asia\/Omsk": "Asia\/Omsk",
            "Asia\/Oral": "Asia\/Oral",
            "Asia\/Phnom_Penh": "Asia\/Phnom Penh",
            "Asia\/Pontianak": "Asia\/Pontianak",
            "Asia\/Pyongyang": "Asia\/Pyongyang",
            "Asia\/Qatar": "Asia\/Qatar",
            "Asia\/Qostanay": "Asia\/Qostanay",
            "Asia\/Qyzylorda": "Asia\/Qyzylorda",
            "Asia\/Riyadh": "Asia\/Riyadh",
            "Asia\/Sakhalin": "Asia\/Sakhalin",
            "Asia\/Samarkand": "Asia\/Samarkand",
            "Asia\/Seoul": "Asia\/Seoul",
            "Asia\/Shanghai": "Asia\/Shanghai",
            "Asia\/Singapore": "Asia\/Singapore",
            "Asia\/Srednekolymsk": "Asia\/Srednekolymsk",
            "Asia\/Taipei": "Asia\/Taipei",
            "Asia\/Tashkent": "Asia\/Tashkent",
            "Asia\/Tbilisi": "Asia\/Tbilisi",
            "Asia\/Tehran": "Asia\/Tehran",
            "Asia\/Thimphu": "Asia\/Thimphu",
            "Asia\/Tokyo": "Asia\/Tokyo",
            "Asia\/Tomsk": "Asia\/Tomsk",
            "Asia\/Ulaanbaatar": "Asia\/Ulaanbaatar",
            "Asia\/Urumqi": "Asia\/Urumqi",
            "Asia\/Ust-Nera": "Asia\/Ust-Nera",
            "Asia\/Vientiane": "Asia\/Vientiane",
            "Asia\/Vladivostok": "Asia\/Vladivostok",
            "Asia\/Yakutsk": "Asia\/Yakutsk",
            "Asia\/Yangon": "Asia\/Yangon",
            "Asia\/Yekaterinburg": "Asia\/Yekaterinburg",
            "Asia\/Yerevan": "Asia\/Yerevan",
            "Atlantic\/Azores": "Atlantic\/Azores",
            "Atlantic\/Bermuda": "Atlantic\/Bermuda",
            "Atlantic\/Canary": "Atlantic\/Canary",
            "Atlantic\/Cape_Verde": "Atlantic\/Cape Verde",
            "Atlantic\/Faroe": "Atlantic\/Faroe",
            "Atlantic\/Madeira": "Atlantic\/Madeira",
            "Atlantic\/Reykjavik": "Atlantic\/Reykjavik",
            "Atlantic\/South_Georgia": "Atlantic\/South Georgia",
            "Atlantic\/St_Helena": "Atlantic\/St Helena",
            "Atlantic\/Stanley": "Atlantic\/Stanley",
            "Australia\/Adelaide": "Australia\/Adelaide",
            "Australia\/Brisbane": "Australia\/Brisbane",
            "Australia\/Broken_Hill": "Australia\/Broken Hill",
            "Australia\/Currie": "Australia\/Currie",
            "Australia\/Darwin": "Australia\/Darwin",
            "Australia\/Eucla": "Australia\/Eucla",
            "Australia\/Hobart": "Australia\/Hobart",
            "Australia\/Lindeman": "Australia\/Lindeman",
            "Australia\/Lord_Howe": "Australia\/Lord Howe",
            "Australia\/Melbourne": "Australia\/Melbourne",
            "Australia\/Perth": "Australia\/Perth",
            "Australia\/Sydney": "Australia\/Sydney",
            "Europe\/Amsterdam": "Europe\/Amsterdam",
            "Europe\/Andorra": "Europe\/Andorra",
            "Europe\/Astrakhan": "Europe\/Astrakhan",
            "Europe\/Athens": "Europe\/Athens",
            "Europe\/Belgrade": "Europe\/Belgrade",
            "Europe\/Berlin": "Europe\/Berlin",
            "Europe\/Bratislava": "Europe\/Bratislava",
            "Europe\/Brussels": "Europe\/Brussels",
            "Europe\/Bucharest": "Europe\/Bucharest",
            "Europe\/Budapest": "Europe\/Budapest",
            "Europe\/Busingen": "Europe\/Busingen",
            "Europe\/Chisinau": "Europe\/Chisinau",
            "Europe\/Copenhagen": "Europe\/Copenhagen",
            "Europe\/Dublin": "Europe\/Dublin",
            "Europe\/Gibraltar": "Europe\/Gibraltar",
            "Europe\/Guernsey": "Europe\/Guernsey",
            "Europe\/Helsinki": "Europe\/Helsinki",
            "Europe\/Isle_of_Man": "Europe\/Isle of Man",
            "Europe\/Istanbul": "Europe\/Istanbul",
            "Europe\/Jersey": "Europe\/Jersey",
            "Europe\/Kaliningrad": "Europe\/Kaliningrad",
            "Europe\/Kiev": "Europe\/Kiev",
            "Europe\/Kirov": "Europe\/Kirov",
            "Europe\/Lisbon": "Europe\/Lisbon",
            "Europe\/Ljubljana": "Europe\/Ljubljana",
            "Europe\/London": "Europe\/London",
            "Europe\/Luxembourg": "Europe\/Luxembourg",
            "Europe\/Madrid": "Europe\/Madrid",
            "Europe\/Malta": "Europe\/Malta",
            "Europe\/Mariehamn": "Europe\/Mariehamn",
            "Europe\/Minsk": "Europe\/Minsk",
            "Europe\/Monaco": "Europe\/Monaco",
            "Europe\/Moscow": "Europe\/Moscow",
            "Europe\/Oslo": "Europe\/Oslo",
            "Europe\/Paris": "Europe\/Paris",
            "Europe\/Podgorica": "Europe\/Podgorica",
            "Europe\/Prague": "Europe\/Prague",
            "Europe\/Riga": "Europe\/Riga",
            "Europe\/Rome": "Europe\/Rome",
            "Europe\/Samara": "Europe\/Samara",
            "Europe\/San_Marino": "Europe\/San Marino",
            "Europe\/Sarajevo": "Europe\/Sarajevo",
            "Europe\/Saratov": "Europe\/Saratov",
            "Europe\/Simferopol": "Europe\/Simferopol",
            "Europe\/Skopje": "Europe\/Skopje",
            "Europe\/Sofia": "Europe\/Sofia",
            "Europe\/Stockholm": "Europe\/Stockholm",
            "Europe\/Tallinn": "Europe\/Tallinn",
            "Europe\/Tirane": "Europe\/Tirane",
            "Europe\/Ulyanovsk": "Europe\/Ulyanovsk",
            "Europe\/Uzhgorod": "Europe\/Uzhgorod",
            "Europe\/Vaduz": "Europe\/Vaduz",
            "Europe\/Vatican": "Europe\/Vatican",
            "Europe\/Vienna": "Europe\/Vienna",
            "Europe\/Vilnius": "Europe\/Vilnius",
            "Europe\/Volgograd": "Europe\/Volgograd",
            "Europe\/Warsaw": "Europe\/Warsaw",
            "Europe\/Zagreb": "Europe\/Zagreb",
            "Europe\/Zaporozhye": "Europe\/Zaporozhye",
            "Europe\/Zurich": "Europe\/Zurich",
            "Indian\/Antananarivo": "Indian\/Antananarivo",
            "Indian\/Chagos": "Indian\/Chagos",
            "Indian\/Christmas": "Indian\/Christmas",
            "Indian\/Cocos": "Indian\/Cocos",
            "Indian\/Comoro": "Indian\/Comoro",
            "Indian\/Kerguelen": "Indian\/Kerguelen",
            "Indian\/Mahe": "Indian\/Mahe",
            "Indian\/Maldives": "Indian\/Maldives",
            "Indian\/Mauritius": "Indian\/Mauritius",
            "Indian\/Mayotte": "Indian\/Mayotte",
            "Indian\/Reunion": "Indian\/Reunion",
            "Pacific\/Apia": "Pacific\/Apia",
            "Pacific\/Auckland": "Pacific\/Auckland",
            "Pacific\/Bougainville": "Pacific\/Bougainville",
            "Pacific\/Chatham": "Pacific\/Chatham",
            "Pacific\/Chuuk": "Pacific\/Chuuk",
            "Pacific\/Easter": "Pacific\/Easter",
            "Pacific\/Efate": "Pacific\/Efate",
            "Pacific\/Enderbury": "Pacific\/Enderbury",
            "Pacific\/Fakaofo": "Pacific\/Fakaofo",
            "Pacific\/Fiji": "Pacific\/Fiji",
            "Pacific\/Funafuti": "Pacific\/Funafuti",
            "Pacific\/Galapagos": "Pacific\/Galapagos",
            "Pacific\/Gambier": "Pacific\/Gambier",
            "Pacific\/Guadalcanal": "Pacific\/Guadalcanal",
            "Pacific\/Guam": "Pacific\/Guam",
            "Pacific\/Honolulu": "Pacific\/Honolulu",
            "Pacific\/Kiritimati": "Pacific\/Kiritimati",
            "Pacific\/Kosrae": "Pacific\/Kosrae",
            "Pacific\/Kwajalein": "Pacific\/Kwajalein",
            "Pacific\/Majuro": "Pacific\/Majuro",
            "Pacific\/Marquesas": "Pacific\/Marquesas",
            "Pacific\/Midway": "Pacific\/Midway",
            "Pacific\/Nauru": "Pacific\/Nauru",
            "Pacific\/Niue": "Pacific\/Niue",
            "Pacific\/Norfolk": "Pacific\/Norfolk",
            "Pacific\/Noumea": "Pacific\/Noumea",
            "Pacific\/Pago_Pago": "Pacific\/Pago Pago",
            "Pacific\/Palau": "Pacific\/Palau",
            "Pacific\/Pitcairn": "Pacific\/Pitcairn",
            "Pacific\/Pohnpei": "Pacific\/Pohnpei",
            "Pacific\/Port_Moresby": "Pacific\/Port Moresby",
            "Pacific\/Rarotonga": "Pacific\/Rarotonga",
            "Pacific\/Saipan": "Pacific\/Saipan",
            "Pacific\/Tahiti": "Pacific\/Tahiti",
            "Pacific\/Tarawa": "Pacific\/Tarawa",
            "Pacific\/Tongatapu": "Pacific\/Tongatapu",
            "Pacific\/Wake": "Pacific\/Wake",
            "Pacific\/Wallis": "Pacific\/Wallis"
        }';
        return json_decode($timezones);
    }



//////////////////////////////////////////////// END OF CLASS /////////////////////
}