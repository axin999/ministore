var categortNameElement = null;
var priceset_type = null;
var categoryName = null;
var categoryId = null;
var currentTabId =null;
var pricesetId = null;
var sampol = null;

$(document).ready(function() {
	var storedTabId = sessionStorage.getItem("currenttab");
	switch(storedTabId){
		case 'navPricelist':
				$('#pricelist').addClass('active show');
				$('#'+storedTabId).children().addClass('active show');
		break;
		case 'navAdditems':
				$('#additems').addClass('active show');
				$('#'+storedTabId).children().addClass('active show');				
		break;
		case 'navAddCategory':
				$('#category').addClass('active show');
				$('#'+storedTabId).children().addClass('active show');
		break;
		case 'navPriceset':
				$('#priceset').addClass('active show');
				$('#'+storedTabId).children().addClass('active show');
		break;
		default:
				$('#category').addClass('active show');
				$('#navAddCategory').children().addClass('active show');
	}
	
    console.log(storedTabId);
    loadcategoryselect();
});

$('.nav-item').click(function(){
	currentTabId = $(this).attr('id');
	sessionStorage.setItem("currenttab", currentTabId);
	//console.log(currentTabId);
});

$(".categorydiv_id").click(function(){
	var buddy = event.target.nodeName;
	alert(buddy);
});

$(".editcategory_btn").click(function(){
	$('#CategoryName').val(getCategoryIdName().categoryName);
});

$(".addpriceset_btn").click(function(){
	var categoryname = getCategoryIdName().categoryName;
	var categoryid = getCategoryIdName().categoryId;
	$('.pricesetTitle').find('span').remove();
	$('.pricesetTitle').append('<span>'+categoryname+'</span>');
	$('.pricesetTitle').attr('data-categoryidpriceset',categoryid);
	$('.priceSetRow').empty();
	alert(JSON.stringify(getCategoryIdName()))

	$.ajax({
		method:"GET",
		url:priceseturl,
		data:{categoryid:categoryid,_token:token},
		success:function(data){
			console.log('wew',JSON.stringify(data));
			//jquery foreach sample
			/*$.each(data, function(index,value){
				if(index=='priceset_type'){
				}				
			})*/
			data.forEach(forEachdataPirceset);
		}

	});
}) 

$("#CategoryBtnUpdate").click(function(){
	$.ajax({
		method:"POST",
		url:url,
		data:{category_name:$("#CategoryName").val(), id:categoryId, _token: token}
	})
		.done(function(data){
			console.log(JSON.stringify(data));
		});


});

$("#PriceSetBtnUpdate").click(function(){
	var datpriceset = [];

	$(".PriceSetType").each(function () {

   	var dataidset = $(this).parent().parent().data('pricesetid');
   	var pricesetval =  $(this).val();               

	    if(dataidset==null && pricesetval!= null){
	    	var current_priceset_id = $(this).val();
	    	datpriceset.push(current_priceset_id);
	    }
	 });
	$.ajax({
		method:"POST",
		url:addpriceseturl,
		data:{priceset_type:datpriceset,category_id:categoryId,_token: token},
		success:function(data){
			//console.log(data.response);
			//console.log(data);
			//console.log(JSON.stringify(data));
			alert(JSON.stringify(data.erros));
		},
		error: function (xhr) {
               if (xhr.status == 422) {
                   var errors = JSON.parse(xhr.responseText);
                   console.log(errors);
                   alert(errors.priceset_type);
               }
           }
	})


});
$('.del-ctg').click(function(){
	var delconfirm = confirm("Are you sure you want to delete it?");
	var category_id = getCategoryIdName().categoryId;
	var remove_tr = $(this).parent().parent();
	if(delconfirm == true){
		$.ajax({
			type:"post",
			url:"/delete/"+category_id,
			data:{_token: token},
			success:function(data){
				remove_tr.remove();
			}
		})
	}
});

$(".categorynamevalue").click(function(){
	var sample = $(this).text();
	alert(sample);
});

$("#navpriceset").click(function(){
	console.log(sampleurl);
	$.ajax({
		method:"GET",
		url:priceseturl,
	})
	.done(function(){
		console.log('datatoyo');
	});
});

$("#addElement_btn").click(function(){
	$("#contentPanel").append(createPriceSetElement());
});

$('#contentPanel').on( "click",".removeDescription", function() {
	var removedesc = $(this).parent().parent();
	getCurrentpsetId();

	if(pricesetId== null || pricesetId==''){
		removedesc.remove();
		console.log('noquery');
	}
	else{
	var chkclass = this.className;
		$.ajax({
			type:'post',
			url:"/deletepriceset/"+pricesetId,
			data:{_token: token},
			success:function(data){
				alert('success');
				removedesc.remove();
			}

		});
	}
});



$( "#addPriceSet" ).on( "click", "#testingBtn", function( event ) {
//var getPricesetValue = $(".PriceSetType").val();
//console.log(getPricesetValue);
//var serializepriceset = $(".PriceSetType").serialize();
//console.log(serializepriceset);

 getCurrentpsetId();
var datpriceset = [];
var serializepset = $('.priceSetRow :input').serialize();
console.log('serializer',serializepset);
$(".PriceSetType").each(function () {
   	var dataidset = $(this).parent().parent().data('pricesetid');         
        
   

    if(dataidset==null && PriceSetType!= null){
    	var showpricetypevalues = $(this).val();
    	
    	datpriceset.push(showpricetypevalues);

    }
 });
console.log('valuestoadd',datpriceset);
$.ajax({
	method:'POST',
	data:{pricesettype:datpriceset},
	url:'someurl',
	success:function(){

	}
	
})
});

$(".category-row").on('change','#category_select',function(){
	var categoryselect = $("#category_select").val();
	$(".priceset").remove();
	$.ajax({
		method:'GET',
		data:{categoryid:categoryselect,_token:token},
		url:'showpricesets',
		success:function(data){
			$.each(data, function(index,value){
				
				$(".category-row").append('<div class="form-group priceset"><input type="text" placeholder="Price For '+value.priceset_type+'" data-additempriceset="'+value.id+'" value="" class="form-control price-value"></div>')
			})
			console.log(data);
		}
	})
	
});


//submit add item

$('#submit_additem').click(function(){
	var itemname = $('#item_name').val();
	var category_id = $('#category_select').attr('id');
	var description = $('#description').val();
	var quantity = $('#quantity').val();


	//var price2 = $.each(price, (i, e) => console.log(e.value.get()));
	//var price2 = price.map((i, e) => e.value).get();

//alert(JSON.stringify(kabayo));
var myArray = new Array();
/*var priceid = $('.price-value')
  .map(function() {
    return [$.map($(this).data(),function(value){
    	return value;
    })];
  })
  .get();*/

let prices = [];
$(".price-value").each(function() {
	prices.push([$(this).data('additempriceset'),$(this).val()]);
});


var kabayo = {itemname:itemname,description:description,quantity:quantity,prices:prices}
console.log(prices[0][1]);

	$.ajax({
		method:'post',
		type:JSON,
		data:{itemname:itemname,description:description,quantity:quantity,_token:token,prices:prices},
		url:'additem',
		success:function(data){
			console.log(data);
		}

	})
})


function getCategoryIdName(){
	
	categoryName = $(event.target).closest("tr").find(".categorynamevalue").text();
	categoryId = $(event.target).parent().parent().children().first().data("categoryid");
	console.log('currentcategotyid',categoryId);
	var arr = {'categoryName':categoryName,'categoryId':categoryId};
	return arr;

}

function createPriceSetElement(itemvalue, itemid){
	var textstatus = 'disabled';
	if(itemvalue==null){
		itemvalue = '';
	}
	if(itemid==null){
		itemid=null;
		textstatus ='';
	}
	var element =' <div class="col-sm-6 d-flex" data-pricesetid='+itemid+'>\
			<div class="col-sm-4 d-flex justify-content-center">\
                <label>Description</label>\
             </div>\
             <div class="col-sm-6 d-flex justify-content-start">\
               <input class="form-control w-100 PriceSetType" type="text" name="PriceSetType" value="'+itemvalue+'" '+textstatus+'>\
             </div>\
             <div class="col-sm-2">\
               <button type="button" class="btn btn-xs btn-danger removeDescription">x</button>\
               <button type="button" class="btn btn-xs btn-danger editDescription">e</button>\
             </div>\
             </div>';
    //below is javascript sample for inner html class to work.       
    //document.getElementsByClassName("priceSetRow")[0].innerHTML += element; 
    $( ".priceSetRow" ).append(element);


}

function forEachdataPirceset(item, index){
 	createPriceSetElement(item.priceset_type,item.id);
}

function loadcategoryselect(){
	$.ajax({
		method:'GET',
		url:'/getcategory',
		success:function(data){
			$.each(data, function(index,value){
				$('#category_select').append('<option value="'+value.id+'">'+value.category_name+'</option>')	;			
			})
		}
	})
}
function getCurrentpsetId(){
	pricesetId = $(event.target).parent().parent().data('pricesetid');
	return pricesetId;
}
