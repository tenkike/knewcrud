//$(document).ready(function() {})

$(function ($) { 
    
    $.fn.AuthRakhano = function(){
    };
    
     var delay= 24 * 60 * 120;
     var location= window.location;
        
     var protocol= location.protocol;
     var hostname= location.hostname;
     var url_oauth= protocol+'//'+hostname;
        
    var _token='';
    var _credentials="";
    $.AuthRakhano= {    
        
        newRakPostConnect: function(newToken){    
            console.log('newToken ', newToken);
        $.AuthRakhano.twdAjax= {
            Post: $.post({
                    url: url_oauth+'/authorize',
                    type: 'POST',
                    data: JSON.stringify({'email': 'admin@admin.com'}),
                    headers:{
                        'X-CSRF-TOKEN': newToken,
                        'Content-Type': 'application/json'
                    }
                })
                .done(function(i, r){

                    if(r === 'success'){
                       var token= localStorage.setItem('token', i.token);
                       var credentials= localStorage.setItem('credentials', JSON.stringify({'email': i.email, 'token': i.token}) );
                    }
                })
                .fail(function(f,d){

                  //  console.log(f); 

                })
        }
    },
        
    newRakGetConnect: function() {  
      
           $.AuthRakhano.twdAjax= {
               Get: $.get({
                   url: url_oauth+'/getoauth'                   
               })
                .done(function(t, r){
                    var itoken=  t.token;
                    if(itoken !== ""){
                        localStorage.setItem('token',itoken);
                    }
                    
                      
               })
                .fail(function(f, d){
                   window.location="/auth/login" 
               })
           }
       }
    
        
    };    
        
    $.AuthRakhano.newRakGetConnect();
     _token= localStorage.getItem('token');
    
    setTimeout(()=>{
        
        console.log('$_token', _token);
         if(_token){
             $.AuthRakhano.newRakPostConnect(_token);
         }
      },1);
    
    console.log('AuthRakhano', $.AuthRakhano);
    


})
