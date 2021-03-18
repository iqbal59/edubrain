
"use strict";
app.controller("mozzCtrl", function($scope,$http,$timeout,$log,$window,$sce,$interval,config,hotkeys){
	//controller variables
	$scope.appConfig=config;
	$scope.ajax_url='../../'+config.ajaxModule+'chat/';
	$scope.pageIndex=config.currentPage;
	$scope.subPageIndex=0;
	$scope.searchText='';
	$scope.responseText='';
	$scope.responseData={};
	$scope.selectedRow={};
	$scope.sortString='';
	///////////////////////////////
	$scope.filter={};
	$scope.entry={message:'',image:'',content:'',seo_desc:''};
    $scope.promise={};
	$scope.message='';
	$scope.rid='';

	/////////HOTKEYS/////////////////////////////////////////////////////	 
	hotkeys.add({
	  combo: 'enter',	//enter
	  description: 'Search',
	  allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
	  callback: function(event, hotkey) {
		event.preventDefault();
		$scope.sendGroupMessage();
	  }
	}); 
	
	/////////GENERAL FUNCTIONS/////////////////////////////////////////////////////	          
    $scope.sortBy= function (value){ $scope.sortString=$scope.processSort(value);$scope.loadRows()};
    $scope.clearFilter= function (){ $.each($scope.filter, function(index){$scope.filter[index]='';}); };
    $scope.filterGetString= function (){ var data=''; $.each($scope.filter, function(index,value){data+='&'+index+'='+value;});data+='&search='+$scope.searchText; return data;};
    $scope.showFilter= function (){var show=false; $.each($scope.filter, function(index,value){if(value !==''){show=true;} }); return show; };
    $scope.clearResponse= function (){ $scope.responseText='';$scope.responseModelText=''; };
    $scope.selectRow = function (row) {$scope.selectedRow = row;};
	$scope.addkey=function (key){$scope.message= $scope.message+' {'+key+'} ';}; 
	$scope.scrollTo = function (id) {
		var div = document.getElementById(id);
		div.scrollTop = div.scrollHeight;
	}
	//////////////HELPER FUNCTIONS/////////////////////////////////////	
    $scope.loadGroupRows=function (){
		var data={'rid':$scope.rid};
		config.postConfig.params=data;
		$http.get($scope.ajax_url+'filterGroupMessages',config.postConfig).then(function(response){
			$scope.enableButtons();
			$scope.responseData=response.data;	
			$scope.scrollTo('cBottom');
			
		},function(response){	
			$scope.enableButtons();
			$log.error(response);
		});    
    };	
	
	$scope.sendGroupMessage=function (){
    	if($scope.message.length< 1){
			alert("Please enter message");
        }else{
		$scope.disableButtons();
		var data='rid='+encodeURIComponent($scope.rid)+'&message='+encodeURIComponent($scope.message);
		$http.post($scope.ajax_url+'addGroupMessage',data,config.postConfig).then(function(response){
			var msg=response.data.message;
			if(response.data.error === true){
			$log.error(response);
			}else{
			$scope.message='';
			$scope.loadGroupRows();
			}
		},function(response){
			$scope.enableButtons();
			$log.error(response);
			
		});
        }
    }; 
	///////autoload functions////////////////////
	$timeout(function(){$scope.loadGroupRows();},200);//SET INTERVAL TO AUTO UPDATE THE ROWS
	$scope.promise=$interval(function (){		
		var data={'rid':$scope.rid};
		config.postConfig.params=data;
		$http.get($scope.ajax_url+'filterGroupMessages',config.postConfig).then(function(response){
			$scope.enableButtons();
			$scope.responseData=response.data;			
		},function(response){	
			$scope.enableButtons();
			$log.error(response);
		});		
	}, 10000);


});