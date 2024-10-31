(function() {
    /* Register the buttons */
    tinymce.create('tinymce.plugins.Notelr', {
        init : function(ed, url) {
            jQuery(window).on('message', function (event) {
                event = event.originalEvent;
                if(typeof event.data.signature !== "undefined" && event.data.signature == "notelr"){
                    var return_text = '[notelr code="' + event.data.code + '" type="'+event.data.type+'" size="'+event.data.size+'" color="'+event.data.color+'"]';
                    ed.execCommand('mceInsertContent', 0, return_text);
                }
            });
            /**
             * Inserts shortcode content
             */
            ed.addButton( 'notelr', {
                title : 'Notelr - add monetization widget',
                image :url+"/logo.png",
                onclick : function() {
                    var data = {
                        action: "notelr_get_key"
                    }
                    jQuery.getJSON(ajaxurl, data, function (response) {
                        if(response != null){
                            var popup = ed.windowManager.open({title:"Select widget",url:url+"/get-widgets.php?key="+response.key+"&id="+response.id,width:700,height:500,inline:true},{plugin_url:url});
                        }else{
                            window.location = notelrBaseUrl+"/wp-admin/admin.php?page=notelr-settings";
                        }
                    });

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    /* Start the buttons */
    tinymce.PluginManager.add( 'notelr', tinymce.plugins.Notelr);

})();