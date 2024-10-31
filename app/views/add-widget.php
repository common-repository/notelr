<section id="addWidgetsPage">

<div class="wrap">

	<div class="widget-button-wrap">
		<div id="icon-admin" class="icon32 icon32-posts-post"><br></div>
		<h2>Add widget</h2>
		<br/>
		
		<div class="metabox-holder">
		<div class="postbox-container">
			<div class="postbox">
				<h3 class="hndle">Choose widget type</h3>
				<div class="inside">
				    <ul>
				        <li>
				        	<a data-type="amazon" class="widget-button" id="addAmazonWidget">
					        	<span class="icon amazonIcon"></span>
					        	<span class="text">Amazon</span>
				        	</a>
				        </li>
						<li>
				        	<a data-type="ebay" class="widget-button" id="addEbayWidget">
					        	<span class="icon ebayIcon"></span>
					        	<span class="text">Ebay</span>
				        	</a>
				        </li>
				        <li>
				        	<a data-type="gilt" class="widget-button" id="addGiltWidget">
					        	<span class="icon giltIcon"></span>
					        	<span class="text">Gilt</span>
				        	</a>
				        </li>
				        <li>
				        	<a data-type="travelNow" class="widget-button" id="addTravelNowWidget">
					        	<span class="icon travelnowIcon"></span>
					        	<span class="text">TravelNow</span>
				        	</a>
				        </li>
				        <li>
				        	<a data-type="flixster" class="widget-button" id="addFlixsterWidget">
					        	<span class="icon flixsterIcon"></span>
					        	<span class="text">Flixster</span>
				        	</a>
				        </li>
				    </ul>
				</div>
			</div>
		</div>
		</div>
	</div>
	
	<div class="content mainCol">
	
	</div>
		    
	<div style="display:block; clear:both;"></div>

	<div class="save-widget-wrap">
		<a id="cancelWidget" class="button-secondary" href="admin.php?page=notelr">Cancel</a>
		<a id="saveWidget" class="button-primary">Save</a>
	</div>
	
<script id="amazon-widget-template" type="text/x-handlebars-template">
    <div class="postObjectWrap postAmazonWidget postProductWidget">
	    <div class="tab">
	        <a title="Delete" class="delete closeElem"><span>&times;</span></a>
	    </div>
	    <div class="postObject">
	        <div class="productInner">
	            <div class="objTitle">Suggested Products</div>
	            <ul></ul>
	            <div style="display:none" class="noResults">
	                <p>No results found</p>
	            </div>
	            <div class="footer">
	                <div class="poweredBy pbAmazon left">Provided by&nbsp;<a href="http://www.amazon.com" target="_blank"><img src="http://notelr.com/assets/images/logo_amazon-small.png" alt="Amazon logo"/></a></div>
	                <div class="instructions right">Number of items = a maximum amount of items to display.</div>
	            </div>
	        </div>
	        <div class="productInput">
	            <input type="text" class="text" placeholder="enter keywords" maxlength="250" value="{{keywords}}">
	            <select name="" class="select">
	                <option value="1">1</option>
	                <option value="2">2</option>
	                <option value="3" selected="">3</option>
	            </select>
	            <span class="label">items</span>
	            <a class="button btn productsPreview">Preview</a>
	        </div>
	    </div>
    </div>
</script>

<script id="amazon-product-template" type="text/x-handlebars-template">
    <li class="product">
        <div class="leftSide">
            <a href="{{Url}}" target="_blank">
                <img width="{{Image.Width}}" height="{{Image.Height}}" src="{{Image.Url}}" class="productImage">
            </a>
        </div>
        <div class="centerSide">
            <span class="productTitle"><a href="{{Url}}" target="_blank">{{Title}}</a></span>
            {{#if listPrice}}
            <span class="productPrice">List price: <span class="weak">{{listPrice}}</span></span>
            {{/if}}
            {{#if amazonPrice}}
            <span class="productPrice">Amazon price: <span class="strong">{{amazonPrice}}</span></span>
            {{/if}}
        </div>
        <div class="rightSide">
            <a href="{{Url}}" target="_blank" class="button btn">Buy Now</a>
        </div>
    </li>
</script>

<script id="flixster-widget-template" type="text/x-handlebars-template">
    <div class="postObjectWrap postFlixsterWidget postProductWidget">
	    <div class="tab">
	        <a title="Delete" class="delete closeElem"><span>&times;</span></a>
	    </div>
	    <div class="postObject">
	        <div class="productInner">
	            <div class="objTitle">Movie Info</div>
	            <ul class="movie-list"></ul>
	            <div style="display:none" class="noResults">
	                <p>No results found</p>
	            </div>
	            <div style="display:none" class="results-list rounded5">
	                <ul></ul>
	            </div>
	            <div class="footer">
	                <div class="poweredBy pbFlixster left">Provided by&nbsp;<a href="http://www.flixster.com" target="_blank"><img src="http://notelr.com/assets/images/logo_flixster-small.png" alt="Flixster logo"/></a></div>
	            </div>
	        </div>
	        <div class="productInput">
	            <input type="text" class="text" placeholder="search movies" maxlength="250" value="{{keywords}}">
	            <a class="button btn productsPreview">Search</a>
	        </div>
	    </div>
    </div>
</script>

<script id="flixster-product-template" type="text/x-handlebars-template">
    <li class="product" data-id="{{Id}}">
        <div class="leftSide">
            <img src="{{Thumbnail}}" class="productImage">
        </div>
        <div class="centerSide">
            <span class="productTitle">{{Title}}</span>
            <span class="productYear">({{Year}})</span>

            <div class="productDetails">
                <ul class="ratings">
                    <li class="productCriticsRatings">
                        <img src="{{Image.Critics}}">
                        <span class="label">Critics</span>
                        <span class="score">{{Ratings.Critics}}</span>
                        <span class="label">%</span>
                    </li>
                    <li class="productAudienceRatings">
                        <img src="{{Image.Audience}}">
                        <span class="label">Audience</span>
                        <span class="score">{{Ratings.Audience}}</span>
                        <span class="label">%</span>
                    </li>
                </ul>
                <ul class="cast">
                    {{#each Cast}}
                    <li>{{this}}</li>
                    {{/each}}
                </ul>
            </div>
        </div>
        <div class="rightSide">
            <a href="{{Url}}" target="_blank" class="button">More details</a>
        </div>
    </li>
</script>

<script id="gilt-widget-template" type="text/x-handlebars-template">
    <div class="postObjectWrap postGiltWidget postProductWidget">
	    <div class="tab">
	        <a title="Delete" class="delete closeElem"><span>&times;</span></a>
	    </div>
	    <div class="postObject">
	        <div class="productInner">
	            <div class="objTitle">Suggested Products</div>
	            <ul></ul>
	            <div style="display:none" class="noResults">
	                <p>No results found</p>
	            </div>
	            <div class="footer">
	                <div class="poweredBy pbGilt left">Provided by&nbsp;<a href="http://www.gilt.com" target="_blank"><img
	                    src="http://notelr.com/assets/images/logo_gilt-small.png" alt="Gilt logo"/></a></div>
	                <div class="instructions right">Number of items = a maximum amount of items to display.</div>
	            </div>
	        </div>
	        <div class="productInput">
	            <input type="text" class="text" placeholder="enter keywords" maxlength="250" value="{{keywords}}">
	            <select name="" class="select">
	                <option value="1">1</option>
	                <option value="2">2</option>
	                <option value="3" selected="">3</option>
	            </select>
	            <span class="label">items</span>
	            <a class="button btn productsPreview">Preview</a>
	        </div>
	    </div>
    </div>
</script>

<script id="gilt-product-template" type="text/x-handlebars-template">
    <li class="product">
        <div class="leftSide">
            <a href="{{Url}}" target="_blank">
                <img src="{{Image.Url}}" class="productImage">
            </a>
        </div>
        <div class="centerSide">
            <span class="productTitle"><a href="{{Url}}" target="_blank">{{Title}} - {{Brand}}</a></span>
            {{#if listPrice}}
            <span class="productPrice">List price: <span class="weak">{{listPrice}}</span></span>
            {{/if}}
            {{#if salePrice}}
            <span class="productPrice">Gilt price: <span class="strong">{{salePrice}}</span></span>
            {{/if}}
        </div>
        <div class="rightSide">
            <a href="{{Url}}" target="_blank" class="button btn">Buy Now</a>
        </div>
    </li>
</script>

<script id="ebay-widget-template" type="text/x-handlebars-template">
    <div class="postObjectWrap postEbayWidget postProductWidget">
	    <div class="tab">
	        <a title="Delete" class="delete closeElem"><span>&times;</span></a>
	    </div>
	    <div class="postObject">
	        <div class="productInner">
	            <div class="objTitle">Suggested Products</div>
	            <ul></ul>
	            <div style="display:none" class="noResults">
	                <p>No results found</p>
	            </div>
	            <div class="footer">
	                <div class="poweredBy pbEbay left">Provided by&nbsp;<a href="http://www.ebay.com" target="_blank"><img
	                    src="http://notelr.com/assets/images/logo_ebay-small.png" alt="Ebay logo"/></a></div>
	                <div class="instructions right">Number of items = a maximum amount of items to display.</div>
	            </div>
	        </div>
	        <div class="productInput">
	            <input type="text" class="text" placeholder="enter keywords" maxlength="250" value="{{keywords}}">
	            <select name="" class="select">
	                <option value="1">1</option>
	                <option value="2">2</option>
	                <option value="3" selected="">3</option>
	            </select>
	            <span class="label">items</span>
	            <a class="button btn productsPreview">Preview</a>
	        </div>
	    </div>
    </div>
</script>


<script id="ebay-product-template" type="text/x-handlebars-template">
    <li class="product">
        <div class="leftSide">
            <a href="{{Url}}" target="_blank">
                <img width="{{Image.Width}}" height="{{Image.Height}}" src="{{Image.Url}}" class="productImage">
            </a>
        </div>
        <div class="centerSide">
            <span class="productTitle"><a href="{{Url}}" target="_blank">{{Title}}</a></span>
            {{#if listPrice}}
            <span class="productPrice">List price: <span>{{listPrice}}</span></span>
            {{/if}}
            {{#if bidPrice}}
            <span class="productPrice">Current bid: <span>{{bidPrice}}</span></span>
            {{/if}}
            {{#if buyNowPrice}}
            <span class="buyNowProductPrice">Buy it now: <span>{{buyNowPrice}}</span></span>
            {{/if}}
            <span class="timeLeft">Time left: <span>{{timeLeft}}</span></span>
        </div>

        <div class="rightSide">
            <a href="{{Url}}" target="_blank" class="button btn">
                {{#if listPrice}}
                Buy Now
                {{/if}}
                {{#if bidPrice}}
                Bid Now
                {{/if}}
            </a>
        </div>
    </li>
</script>


<script id="travelNow-widget-template" type="text/x-handlebars-template">
	<div class="postObjectWrap postExpediaHotelWidget postProductWidget">
	    <div class="tab">
	        <a title="Delete" class="delete closeElem"><span>&times;</span></a>
	    </div>
	    <div class="postObject">
	        <div class="productInner">
	            <div class="objTitle">Suggested Hotels</div>
	            <ul></ul>
	            <div style="display:none" class="noResults">
	                <p>No results found</p>
	            </div>
	            <div class="footer">
	                <div class="poweredBy pbTravelnow left">Provided by&nbsp;<a href="http://www.travelnow.com"
	                                                                            target="_blank"><img
	                    src="http://notelr.com/assets/images/logo_travelnow-small.png" alt="Travelnow logo"/></a></div>
	                <div class="instructions right">Number of items = a maximum amount of items to display.</div>
	            </div>
	        </div>
	        <div class="productInput">
	            <input type="text" class="text location" placeholder="location" maxlength="250" value="{{location}}">
	            <input type="text" class="text keywords" placeholder="hotel name (optional)" maxlength="250"
	                   value="{{keywords}}">
	            <select name="" class="select">
	                <option value="1">1</option>
	                <option value="2">2</option>
	                <option value="3" selected="">3</option>
	            </select>
	            <span class="label">items</span>
	            <a class="button btn productsPreview">Preview</a>
	        </div>
	    </div>
	</div>
</script>

<script id="travelNow-product-template" type="text/x-handlebars-template">
    <li class="product">
        <div class="leftSide">
            <a href="{{Url}}" target="_blank">
                <img src="{{Image}}" class="productImage">
            </a>
        </div>
        <div class="centerSide">
            <span class="productTitle"><a href="{{Url}}" target="_blank">{{Title}}</a></span>
            <span class="stars" data-score="{{Rating}}"></span>
            <span class="productLocation">{{Location}}</span>
            <span class="productPrice">Room rate: <span class="strong">${{Rate}}</span></span>
        </div>

        <div class="rightSide">
            <a href="{{Url}}" target="_blank" class="button btn">Check Availability</a>
        </div>
    </li>
</script>
    <script type="text/javascript">
        var notelr_widget_type = <?php echo (!empty($this->type))? '"'.$this->type.'"':"null"; ?>;
        var notelr_widget_data = <?php echo (!empty($this->data))? $this->data:"[]"; ?>;
    </script>
    
</div>
</section>
