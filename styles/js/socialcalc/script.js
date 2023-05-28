$(document).ready(function() {    
    var repl = function(ids){
        var id = ids.trim();
        var t = $('#'+id).css('top');
        var st = $('#'+id).attr('style');        
        st = st.replace('top:', '');
        st = st.replace(t+';', '');
        $('#'+id).attr('style', st);
        console.log(id);
    }
          
    var idss = [
        "te_endcaph",
        "te_panesliderh",
        "te_lessbuttonh",
        "te_morebuttonh",
        "te_scrollareah",
        "te_thumbh"
    ];
    for(var i=0;i<idss.length;i++){
        repl(idss[i]);
    }             
});    