(function () {
    $ = jQuery;
    $(document).ready(function () {
            var type, nrProducts, keywords, location,movieId,id;
            if(notelr_widget_type){
                var data = notelr_widget_data;
                type = notelr_widget_type;
                var id = data['id'];
                if(data.hasOwnProperty("movie_id")){
                    movieId = data['movie_id'];
                }
                if(data.hasOwnProperty("nr_products")){
                    nrProducts = data['nr_products'];
                }
                if(data.hasOwnProperty("location")){
                    location = data['location'];
                }
                if(data.hasOwnProperty("keywords")){
                    keywords = data['keywords'];
                }
                if(data.hasOwnProperty("id")){
                    id = data['id'];
                }
                appendWidgetContent(type,data);
                loadWidgetByType();
            }
            $(".widget-button").click(function (e) {
                e.preventDefault();
                type = $(this).data("type");
                appendWidgetContent(type);
            });
            function appendWidgetContent(type,data)
            {
                var template = Handlebars.compile($("#" + type + "-widget-template").text());
                if(data){
                    $(".content").append(template(data));
                    if(nrProducts){
                        $(".content").find(".productInput .select").val(nrProducts);
                    }
                }else{
                    $(".content").append(template());
                }
                $(".widget-button-wrap").hide();
            }
            function loadWidgetByType()
            {
                if (type == "travelNow") {
                    loadTravelNowWidget();
                }else if(type == "flixster"){
                    loadFlixsterWidget();
                }else{
                    loadWidget();
                }
            }
            $("body").on("click", ".productsPreview", function (e) {
                movieId="";keywords="";nrProducts="";location="";
                loadWidgetByType();
            });

            function loadWidget() {
                keywords = $(".content").find(".productInput .text").val();
                nrProducts = $(".content").find(".productInput .select").val();

                var data = {
                    action: "notelr_get_products",
                    data: {
                        "type": type,
                        "keywords": keywords,
                        "nrProducts": nrProducts
                    }
                }
                $.getJSON(ajaxurl, data, function (data) {
                    var $widget = $(".postObject")
                    var productTemplate = Handlebars.compile($("#" + type + "-product-template").text());
                    if (typeof data.Products != "undefined" && data.Products.length != 0) {
                        $widget.find(".productInner ul").empty();
                        for (var i = 0; i < data.Products.length; i++) {
                            $widget.find(".productInner ul").append(productTemplate(data.Products[i]));
                        }
                        $widget.find(".moreResults a").attr("href", data.MoreSearchResults);
                        $widget.find(".moreResults").show();
                        $widget.find(".noResults").hide();
                    } else {
                        $widget.find(".moreResults").hide();
                        $widget.find(".noResults").show();
                    }
                });

            }

            function loadFlixsterWidget() {
                keywords = $(".content").find(".productInput .text").val();
                var data = {
                    action: "notelr_get_products",
                    data: {
                        "type": type,
                        "keywords": keywords,
                        "movieId":movieId
                    }
                }
                $.getJSON(ajaxurl, data, function (data) {
                    var $widget = $(".postObject");
                    if(movieId){
                        var criticsRatings = parseInt(data['Ratings']['Critics'], 10);
                        var audienceRatings = parseInt(data['Ratings']['Audience'], 10);
                        data['Image'] = {};
                        if (criticsRatings >= 60) {
                            data['Image']['Critics'] = notelrBaseUrl+"/wp-content/plugins/notelr/assets/images/flixster-fresh.png";
                        } else {
                            data['Image']['Critics'] = notelrBaseUrl+"/wp-content/plugins/notelr/assets/images/flixster-rotten.png";
                        }
                        if (audienceRatings >= 60) {
                            data['Image']['Audience'] = notelrBaseUrl+"/wp-content/plugins/notelr/assets/images/flixster-fresh.png";
                        } else {
                            data['Image']['Audience'] = notelrBaseUrl+"/wp-content/plugins/notelr/assets/images/flixster-rotten.png";
                        }
                        var productTemplate = Handlebars.compile($("#" + type + "-product-template").text());
                        var $elem = $(productTemplate(data));
                        $elem.addClass("selected");
                        $widget.find(".productInner .movie-list").append($elem);
                    }else{
                        $("body").on("click",".results-list .product",function(){
                            var $elem = $(event.target);
                            if (!$elem.hasClass("product")) {
                                $elem = $elem.parents(".product");
                            }
                            $elem = $elem.clone();
                            $widget.find(".productInner .movie-list").empty();
                            $elem.appendTo($widget.find(".productInner .movie-list"));
                            $elem.addClass("selected");
                            $elem.find(".productDetails").show();
                            movieId = $elem.data("id");
                            $widget.find(".productInner .results-list").slideUp();
                        });
                        var productTemplate = Handlebars.compile($("#" + type + "-product-template").text());
                        if (typeof data != "undefined" && data.length != 0) {
                            $widget.find(".productInner ul").empty();
                            for (var i = 0; i < data.length; i++) {
                                var criticsRatings = parseInt(data[i]['Ratings']['Critics'], 10);
                                var audienceRatings = parseInt(data[i]['Ratings']['Audience'], 10);
                                data[i]['Image'] = {};
                                if (criticsRatings >= 60) {
                                    data[i]['Image']['Critics'] = notelrBaseUrl+"/wp-content/plugins/notelr/assets/images/flixster-fresh.png";
                                } else {
                                    data[i]['Image']['Critics'] = notelrBaseUrl+"/wp-content/plugins/notelr/assets/images/flixster-rotten.png";
                                }
                                if (audienceRatings >= 60) {
                                    data[i]['Image']['Audience'] = notelrBaseUrl+"/wp-content/plugins/notelr/assets/images/flixster-fresh.png";
                                } else {
                                    data[i]['Image']['Audience'] = notelrBaseUrl+"/wp-content/plugins/notelr/assets/images/flixster-rotten.png";
                                }
                                $widget.find(".productInner .results-list > ul").append(productTemplate(data[i]));
                            }
                            $widget.find(".noResults").hide();
                            $widget.find(".productInner .results-list").slideDown();
                        } else {
                            $widget.find(".noResults").show();
                        }
                    }

                });

            }

            function loadTravelNowWidget() {
                keywords = $(".content").find(".productInput .text.keywords").val();
                nrProducts = $(".content").find(".productInput .select").val();
                location = $(".content").find(".productInput .text.location").val();
                if (!location) {
                    return;
                }
                var data = {
                    action: "notelr_get_products",
                    data: {
                        "type": type,
                        "keywords": keywords,
                        "nrProducts": nrProducts,
                        "location":location
                    }
                }
                $.getJSON(ajaxurl, data, function (data) {
                    var $widget = $(".postObject")
                    var productTemplate = Handlebars.compile($("#" + type + "-product-template").text());
                    if (typeof data != "undefined" && data.length != 0) {
                        $widget.find(".productInner ul").empty();
                        for (var i = 0; i < data.length; i++) {
                            $widget.find(".productInner ul").append(productTemplate(data[i]));
                        }
                        $widget.find(".moreResults").show();
                        $widget.find(".noResults").hide();
                        $widget.find(".stars").raty({
                            path: notelrBaseUrl+'/wp-content/plugins/notelr/assets/js/libs/raty/img',
                            half: true,
                            readOnly: true,
                            hints: ['', '', '', '', ''],
                            score: function () {
                                return $(this).attr('data-score');
                            }
                        });
                    } else {
                        $widget.find(".moreResults").hide();
                        $widget.find(".noResults").show();
                    }
                });

            }

            $("#saveWidget").click(function (e) {
                e.preventDefault();
                var data = {
                    action: "notelr_save_widget",
                    data: {
                        "type": type,
                        "keywords": keywords,
                        "nrProducts": nrProducts,
                        "location":location,
                        "movieId":movieId,
                        "id":id
                    }
                }
                $.getJSON(ajaxurl, data, function (data) {
                    if (data.status == "ok") {
                        window.location = "admin.php?page=notelr";
                    }
                });
            });
            $("body").on("click",".postObjectWrap .closeElem",function(e){
                e.preventDefault();
                $(".content").empty();
                $(".widget-button-wrap").show();
                type ="";
                nrProducts="";
                keywords="";
                movieId="";
                location="";
                id="";
            });
            $("body").on("keypress",".productInput .text",function(e){
                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if (keycode == 13) {
                        movieId="";keywords="";nrProducts="";location="";
                        loadWidgetByType();
                    }
            })
        }

    )
    ;
})();