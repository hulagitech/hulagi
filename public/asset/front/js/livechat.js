var LHC_API = LHC_API||{};
LHC_API.args = {
    mode:'widget',
    lhc_base_url:'//puryao.com/livesupport/index.php/',
    wheight:450,
    wwidth:350,
    pheight:520,
    pwidth:500,
    domain:'www.hulagi.com',
    leaveamessage:true,
    department:[1],
    check_messages:false
    };
(function() {
    var po = document.createElement('script'); 
    po.type = 'text/javascript'; 
    po.setAttribute('crossorigin','anonymous'); 
    po.async = true;
    var date = new Date();
    po.src = '//puryao.com/livesupport/design/defaulttheme/js/widgetv2/index.js?'+(""+date.getFullYear() + date.getMonth() + date.getDate());
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();