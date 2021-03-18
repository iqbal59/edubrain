"use strict";
app.controller("mozzCtrl", function($scope,$http,$timeout,$log,$window,$sce,$interval,config,hotkeys){
	//controller variables
	$scope.appConfig=config;
	$scope.ajax_url='../../../'+config.ajaxModule+'edit/';
	$scope.pageIndex=config.currentPage;
	$scope.subPageIndex=0;
	$scope.searchText='';
	$scope.responseText='';
	$scope.responseData={};
	$scope.selectedRow={};
	$scope.sortString='';
	$scope.subjects={};
	///////////////////////////////
	$scope.filter={status:'',filter_key:'',filter_value:''};
	$scope.entry={class_id:'',subject_id:'',difficulty:'',type:'',chapter:'',marks:'',question:'',option1:'',option2:'',option3:'',option4:'',answer:'',hint:'',detail:''};
    $scope.promise={};
	$scope.message='';
	$scope.class_id='';
	$scope.rid='';

	/////////HOTKEYS/////////////////////////////////////////////////////	 
	hotkeys.add({
	  combo: 'enterdgfd',	//enter
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
		$http.get($scope.ajax_url+'load/qbank',config.postConfig).then(function(response){
			$scope.enableButtons();
			$scope.entry=response.data.row;	
			$scope.loadRows();
		},function(response){	
			$scope.enableButtons();		
			$log.error(response);
		});
    
    };	
    $scope.loadRows=function (){
		var data={'class_id':$scope.entry.class_id};
		config.postConfig.params=data;
		$scope.disableButtons();
		$http.get($scope.ajax_url+'filter/subjects',config.postConfig).then(function(response){
			$scope.enableButtons();
			$scope.subjects=response.data.rows;		
			
		},function(response){	
			$scope.enableButtons();		
			$log.error(response);
		});
    
    };	
	$scope.saveRow=function (){	
    	if($scope.entry.class_id.length< 1){
			alert("Please select class");
        }else if($scope.entry.subject_id.length< 1){
			alert("Please select subject");
        }else if($scope.entry.type.length< 1){
			alert("Please select question type");
        }else if($scope.entry.question.length< 1){
			alert("Please write question");
        }else if(config.btnClickedSave===true){
			alert("Please wait for existing command.");
        }else{
		var data='class_id='+encodeURIComponent($scope.entry.class_id)+'&subject_id='+encodeURIComponent($scope.entry.subject_id);
		data+='&difficulty='+encodeURIComponent($scope.entry.difficulty)+'&type='+encodeURIComponent($scope.entry.type);
		data+='&chapter='+encodeURIComponent($scope.entry.chapter)+'&marks='+encodeURIComponent($scope.entry.marks);
		data+='&question='+encodeURIComponent($scope.entry.question)+'&answer='+encodeURIComponent($scope.entry.answer);
		data+='&option1='+encodeURIComponent($scope.entry.option1)+'&option2='+encodeURIComponent($scope.entry.option2);
		data+='&option3='+encodeURIComponent($scope.entry.option3)+'&option4='+encodeURIComponent($scope.entry.option4);
		data+='&hint='+encodeURIComponent($scope.entry.hint)+'&detail='+encodeURIComponent($scope.entry.detail);
		data+='&rid='+encodeURIComponent($scope.rid);
		$http.post($scope.ajax_url+'update/qbank',data,config.postConfig).then(function(response){
			var msg=response.data.message;
			if(response.data.error === true){
				alert(msg);
				$log.error(response);
			}else{
				alert(msg);
			}
		},function(response){
			alert(config.globalError);
			$log.error(response);
			
		});
        }
    }; 
	/////////////////////////////////////////////
	$('#add').on('shown.bs.modal', function () {config.enter='add';});
	$('#edit').on('shown.bs.modal', function () {config.enter='update';});
	$('#add').on('hidden.bs.modal', function () {config.enter='search';});
	$('#edit').on('hidden.bs.modal', function () {config.enter='search';});
	///////autoload functions////////////////////


});