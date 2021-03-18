<?php  if (! defined('BASEPATH')) exit('No direct script access allowed');
	require 'application/vendor/autoload.php';
    /**
     * author: Asghar Ali
     * Email: asghar3085@gmail.com     *
     *
     * This library can be used to communicate with aws using aws-sdk. 
     *
     *
     * @installation
     *  Composer is required..
     *  creater composer.json file in application directory. and add following code.
     *  {
     *  "require" : {
     *          "aws/aws-sdk-php" : "^3.70"
     *        }
     *       }
     *
     * it will add aws sdk 
     *
     * 
     * You need to edit your application/config.php file  and change $config['composer_autoload'];
     * to TRUE
     *
     * $config['composer_autoload'] = TRUE;
     *
     * You need to edit autoload.config file and in $autoload['libraries'] = array('');
     * add 'aws' . 
     * 
     * eg.. $autoload['libraries'] = array('aws');
     * 
     *  S3 treats / separated file name as folder
     *  $file="home/new/name.png" is like dir(home)=>dir(new)=>file(name.png)
     * 
     */
   
Class Aws {


	protected $ins;
    public $aws;

	public function __construct(){
        $this->ins =& get_instance();
        $this->ins->load->config('aws');
        
	}

    //return AwsS3 Class Object
    public function initAwsS3(){
        $credentials=new Aws\Credentials\Credentials($this->ins->config->item('key'),$this->ins->config->item('secret'));
        return new Aws\S3\S3Client([
             'version' => $this->ins->config->item('version'),
             'region' => $this->ins->config->item('region'),
             'credentials' => $credentials                
            ]);
    }

    //return list of S3 Buckets in an array
    public function listBuckets(){
        $s3Client=$this->initAwsS3();
        $buckets=$s3Client->listBuckets();
        return $buckets['Buckets'];
    }

    //create new S3 Bucket
    public function createBucket($bucket_name){
        $s3Client=$this->initAwsS3();
        try{
            return $s3Client->createBucket(['Bucket'=>$bucket_name]);

        }catch(AwsException $e){
            return $e->getMessage();
        }
    }

}