
  function search_term() {
    
    var term__text = jQuery("#term__text").val();
        
        
        var actioncall = {
          action: 'get_terms',
          term_text: term__text,
          getterms_nonce: MyAjax.gettermsNonce
        };
        
        jQuery.post(MyAjax.ajaxurl,actioncall , function(response) {
          
           if( "" === response) {
             document.getElementById('term__result').style.borderColor="red";
             document.getElementById('term__result').innerHTML = "";
           } else {
             document.getElementById('term__result').style.borderColor="rgb(131, 213, 145)";
             document.getElementById('term__result').innerHTML = response;
           }
          
        }, 'json');
        
  }
  jQuery(document).ready(function() {
  jQuery(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      search_term();
      return false;
    }
  });
});
  jQuery(document).on('change', '#term__text' ,function (event) {
        
      search_term();
       
      });
