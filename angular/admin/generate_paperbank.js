"use strict";
app.controller("mozzCtrl", function($scope,$http,$timeout,$log,$window,$sce,$interval,config,hotkeys){
	//controller variables
	$scope.appConfig=config;
	$scope.ajax_url='../../../'+config.ajaxModule+'generate/';
	$scope.pageIndex=config.currentPage;
	$scope.subPageIndex=0;
	$scope.searchText='';
	$scope.responseText='';
	$scope.responseData={};
	$scope.selectedRow={};
	$scope.sortString='';
	$scope.questionBank={};
	$scope.record={};
	///////////////////////////////
	$scope.filter={chapter:'',limit:'',chapter:'',type:''};
	$scope.entry={saveqb:'0',difficulty:'50',type:'',chapter:'',marks:'',question:'',option1:'',option2:'',option3:'',option4:'',answer:'',hint:'',detail:''};
    $scope.promise={};
	$scope.message='';
	$scope.class_id='';
	$scope.rid='';
	$scope.show_note=false;

	/////////HOTKEYS/////////////////////////////////////////////////////	 
	hotkeys.add({
	  combo: 'enter451',	//enter
	  description: 'Search',
	  allowIn: ['INPUT', 'SELECT'],
	  callback: function(event, hotkey) {
		event.preventDefault();
		$scope.saveRow();
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
	//////////////HELPER FUNCTIONS/////////////////////////////////////	
    $scope.loadRow=function (){
		var data={'rid':$scope.rid};
		config.postConfig.params=data;
		$scope.disableButtons();
		$http.get($scope.ajax_url+'load/paper',config.postConfig).then(function(response){
			$scope.enableButtons();
			$scope.record=response.data.row;	
			$scope.loadRows();
		},function(response){	
			$scope.enableButtons();		
			$log.error(response);
		});
    
    };	
    $scope.loadRows=function (){
		var data={'rid':$scope.rid};
		config.postConfig.params=data;
		$scope.disableButtons();
		$http.get($scope.ajax_url+'filter/paperbank',config.postConfig).then(function(response){
			$scope.enableButtons();
			$scope.responseData=response.data;		
			
		},function(response){	
			$scope.enableButtons();		
			$log.error(response);
		});
    
    };	
    $scope.loadQuestionBank=function (){
		var data={'pid':$scope.rid,'chapter':$scope.filter.chapter,'type':$scope.filter.type,'limit':$scope.filter.limit};
		config.postConfig.params=data;
		$scope.disableButtons();
		$http.get($scope.ajax_url+'filter/questionbank',config.postConfig).then(function(response){
			$scope.enableButtons();
			$scope.questionBank=response.data;		
			
		},function(response){	
			$scope.enableButtons();		
			$log.error(response);
		});
    
    };	
	
	
	$scope.saveRow=function (){	
    	if($scope.entry.question.length< 1){
			alert("Please write question");
        }else{
		var data='saveqb='+encodeURIComponent($scope.entry.saveqb);
		data+='&difficulty='+encodeURIComponent($scope.entry.difficulty)+'&type='+encodeURIComponent($scope.entry.type);
		data+='&chapter='+encodeURIComponent($scope.entry.chapter)+'&marks='+encodeURIComponent($scope.entry.marks);
		data+='&question='+encodeURIComponent($scope.entry.question)+'&answer='+encodeURIComponent($scope.entry.answer);
		data+='&option1='+encodeURIComponent($scope.entry.option1)+'&option2='+encodeURIComponent($scope.entry.option2);
		data+='&option3='+encodeURIComponent($scope.entry.option3)+'&option4='+encodeURIComponent($scope.entry.option4);
		data+='&hint='+encodeURIComponent($scope.entry.hint)+'&detail='+encodeURIComponent($scope.entry.detail);
		data+='&rid='+encodeURIComponent($scope.rid);
		$http.post($scope.ajax_url+'update/manualpaperbank',data,config.postConfig).then(function(response){
			var msg=response.data.message;
			if(response.data.error === true){
				alert(msg);
				$log.error(response);
			}else{
				$scope.entry.question='';$scope.entry.option1='';$scope.entry.option2='';$scope.entry.option3='';$scope.entry.option4='';
				$scope.entry.hint='';$scope.entry.detail='';
				alert(msg);
				$scope.loadRow();
			}
		},function(response){
			alert(config.globalError);
			$log.error(response);
			
		});
        }
    }; 
	
	$scope.saveQbRow=function (qid){	
		$scope.show_note=false;
		var data='';
		data+='&qid='+qid;
		data+='&rid='+encodeURIComponent($scope.rid);
		$http.post($scope.ajax_url+'update/qbpaperbank',data,config.postConfig).then(function(response){
			var msg=response.data.message;
			if(response.data.error === true){
				alert(msg);
				$log.error(response);
			}else{
				$scope.show_note=true;
				$scope.loadQuestionBank();
				$scope.loadRow();
			}
		},function(response){
			alert(config.globalError);
			$log.error(response);
			
		});
    }; 
	$scope.delRow=function (id){	
		var data='';
		data+='&rid='+id;
		$http.post($scope.ajax_url+'delete/paperbank',data,config.postConfig).then(function(response){
			var msg=response.data.message;
			if(response.data.error === true){
				alert(msg);
				$log.error(response);
			}else{
				$scope.loadRow();
			}
		},function(response){
			alert(config.globalError);
			$log.error(response);
			
		});
    }; 
	
	///////autoload functions////////////////////
	$timeout(function(){$scope.loadRow();$scope.loadQuestionBank();},1000); 


});