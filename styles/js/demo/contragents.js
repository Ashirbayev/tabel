    function ViewIp(b)
    {
        $('#ip_control').attr('style', 'display: '+b+';');
    }
    
    $("#osnVidDeyatelnosty_contr").select2(); 
    $("#IVED_ID").select2();
    $("#ibank_id").select2();
    
    $(".i-checks").iCheck({
        checkboxClass: "icheckbox_square-green",
        radioClass: "iradio_square-green"
    });
    
    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });                
        
    function checkBIN(){
        var iin = $('#ibin').val().trim();
        if(iin !== ''){
            $.post(window.location.href, {"search_bin": iin}, function(d){                        
                if(d.trim() !== '0'){                                    
                    $('#answer').html('<p class="text-danger">Такой БИН уже существует</p>');                                
                }else{
                    $('#answer').html('');
                }
            });
        }
    };    
    
    var json_adress;
    
    $('#search_post_btn').click(function(e){
        e.preventDefault();
        var s = $('#search_post').val();
        $.post(window.location.href, {"search_post": s}, function(data){                
            var j = JSON.parse(data);
            var data = j.data;         
            json_adress = data;
            $('#search_result').css('display', 'none');
            $('#search_result').html('');
            $.each(data, function(i, p){
                $('#search_result').append('<a class="list-group-item set_addr" data="'+p.id+'" href="javascript:;">'+p.addressRus+'</a>');                                                            
            });
            $('#search_result').css('display', 'block');
            $('.form-group').click(function(){
                $('#search_result').css('display', 'none');
            });
        });
    });
    
    $('#search_post').keypress(function(e){        
        if (e.which == 13) {
            e.preventDefault();
            $('#search_post_btn').click();
        }       
    });    
    
    $('body').on("click", ".set_addr", function(){
       $('#region').val(''); 
       $('input[name=ADDRESS]').val('');
       $('input[name=ADDRESS_KAZ]').val('');
       $('input[name=STREET]').val('');
       $('input[name=RAION]').val('');
       $('input[name=type_city]').val('');
       $('.POSTCODE').val('');  
       $('input[name=HOME_NUM]').val('');
       
       var id = $(this).attr('data');
       $.each(json_adress, function(i, p){
         if(p.id == id){                       
            $('input[name=ADDRESS]').val(p.addressRus);
            $('input[name=ADDRESS_KAZ]').val(p.addressKaz);
            var fl =  p.fullAddress;
            var parts = fl.parts;
            $.each(parts, function(r, t){
                
                if(t.type.id == 'A9'){                    
                    $('#region').val(t.type.nameRus+' '+t.nameRus);
                }
                
                if(t.type.id.substr(0, 1) == 'G'){
                    $('input[name=STREET]').val(t.type.nameRus+' '+t.nameRus);
                }
                
                if(t.type.id == 'A5'||t.type.id == 'A8'){
                    $('input[name=RAION]').val(t.nameRus+' '+t.type.nameRus);                          
                }
                
                if(t.type.id == 'A1'||t.type.id == 'A9'){
                    $('input[name=TYPE_CITY]').val(t.type.nameRus);
                    $('#icity_id').val(t.nameRus);                    
                }
                if(t.type.id == 'A7'){                    
                    $('#region').val(t.nameRus);
                }
            });
            
            $('.POSTCODE').val(fl.postcode);  
            $('input[name=HOME_NUM]').val(fl.number);                                                
            $('#search_result').css('display', 'none');                      
         }
       });
    });
    
    $('#myonoffswitch').click(function(){
        var b = $(this).prop('checked');
        var ids = 0;
        
        if(b == false){
            $('#strana').css('display', 'block');
            $('#search_address').css('display', 'none');
            ids = 1;
        }else{
            $('#strana').css('display', 'none');
            $('#search_address').css('display', 'block');
            $('#icountry option[value=1]').attr('selected','selected');
        }   
        
        $.post(window.location.href, {"set_nerez":ids}, function(data){
            var j = JSON.parse(data);            
            $('#isec_econom').html('');
            $.each(j, function(i, p){
                $('#isec_econom').append('<option value="'+p.CODE+'">'+p.NAME+'</option>');
            });
        });     
    })
    
    $('.select2').css('width', '100%');
    
    $('.onoffswitch2').click(function(){
       var b = $('#myonoffswitch2').prop('checked');       
       if(b == true){
            $('#group_company_div').css('display', 'none');
            $('#igroup option[value=6]').attr('selected', 'selected');
       }else{
            $('#igroup option').removeAttr('selected');
            $('#group_company_div').css('display', 'block');            
       }
    });
    
    
    
    
/*Поисковая страница*/
$('.gradeX').click(function(){
    var s = $(this).attr('data');
    
    var url = 'contragents?view='+s;
    window.location.href = url;
    /*
    $(this).attr('class', 'gradeX active');
    $.post('contragents', {"dan_contr": s}, function(data){
        $('#dan_contr').html(data);            
    }); 
    */
})

$('#edit').click(function(){
   var id = $('.gradeX.active').attr('data');
   if(id){
    location.href = 'contragents?edit='+id;           
   }
});


$('#submit').click(function(e){
    e.preventDefault();    
    $("form#edit_contr_agents :input").each(function(){  
      	var input = $(this); 
    	var type = input.attr('required');
        input.attr('style', '');
    	if(type == 'required'){
    		if(input.val() == ''){
    			$('.tab-pane').each(function(){
    				var tb = $(this).attr('id');
    				$('#'+tb+' :input').each(function(){
    					if($(this).attr('name') == input.attr('name')){
    						$('.tab-pane').removeClass('active');
    						$('#'+tb).addClass('active');
    						input.css('border-color', 'red');
                            return;
    					} 
    				})
    			})
            }
        }	
    });
    $('#save').attr('name', 'save_contr_agents');
    $('#save').click();            
});

$('#submit_edit').click(function(e){
    e.preventDefault();    
    $("form#edit_contr_agents :input").each(function(){  
      	var input = $(this); 
    	var type = input.attr('required');
        input.attr('style', '');
    	if(type == 'required'){
    		if(input.val() == ''){
    			$('.tab-pane').each(function(){
    				var tb = $(this).attr('id');
    				$('#'+tb+' :input').each(function(){
    					if($(this).attr('name') == input.attr('name')){
    						$('.tab-pane').removeClass('active');
    						$('#'+tb).addClass('active');
    						input.css('border-color', 'red');
                            return;
    					} 
    				})
    			})
            }
        }	
    });
    $('#save').attr('name', 'save_contr_agents_edit');
    $('#save').click();
});


$('#osnVidDeyatelnosty_contr').change(function() {          
        var oked = $(this).val();        
        console.log(oked);
        $.post(window.location.href, {
            "osn_vid_deyatel": oked
        }, function(data){              
            var j = JSON.parse(data);
            console.log(j);            
            $('#OKED').val(j.OKED);             
            $('#RISK_ID').val(j.RISK_ID);                       
        });
    });
    
/*    
$('.NAME').focusout(function(){
   var v = $(this).val();
   $.post(window.location.href, {"prov_name": v}, function(data){
        if(data.trim() !== ''){
            alert(data);
        }
   }); 
});
*/