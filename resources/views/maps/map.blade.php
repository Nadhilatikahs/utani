
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Google Maps Iframe Generator</title>
    <meta name="description" content="Google Maps Iframe Generator" />
	    <meta property="og:type" content="website" />
    <meta property="og:title" content="Google Maps Iframe Generator" />
    <meta property="og:description" content="Google Maps Iframe Generator In only a few clicks, you can add a Google Map location to your website. Code for Google Maps can be generated for free." />
	<meta name="keywords" content="google maps generator, iframe generator" />
	<meta property="og:url" content="https://www.googlemapsiframegenerator.com" />
	<meta property="og:site_name" content="Google Maps Iframe Generator" />
	<meta property="og:image" content="/img/googlemapsiframegenerator-com.jpg" />
	<meta property="og:image" content="/img/googlemapsiframegenerator-com.jpg" />
	<meta name="twitter:card" content="summary" />
		<meta name="twitter:site" content="@twitter" />
		<meta name="twitter:domain" content="https://www.googlemapsiframegenerator.com" />
	<meta name="twitter:title" content="Free Google Maps Code Generator" />
	<meta name="twitter:description" content="Google Maps Iframe Generator In only a few clicks, you can add a Google Map location to your website. Code for Google Maps can be generated for free." />
	<meta name="twitter:image" content="/img/googlemapsiframegenerator-com.jpg" />

    <link rel="canonical" href="https://www.googlemapsiframegenerator.com" />
	<link rel="icon" href="/img/favicon_googlemapsiframegenerator-com.jpg" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css'>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>
	<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons&display=swap'>
    <style>
        #formap {
            overflow: hidden;
            transition: all 0.5s;
            width: 100%;
            height: 400px;
            margin: 1rem auto;
			position:relative;
        }
		#formap:empty:after {
			content:'';
			position:absolute;
			background-image: url("data:image/svg+xml,%3Csvg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 100 100' xml:space='preserve'%3E%3Cpath fill='%23000' opacity='0.15' d='M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50'%3E%3CanimateTransform attributeName='transform' attributeType='XML' type='rotate' dur='1s' from='0 50 50' to='360 50 50' repeatCount='indefinite'%3E%3C/animateTransform%3E%3C/path%3E%3C/svg%3E");
			width:100%;
			height:100%;
			background-size:contain;
			background-position: center;
			background-repeat: no-repeat;
			left:0;
			top:0;
			z-index:1;
		}
		#formap iframe {
			z-index:2;
			position:relative;
		}
        @media screen and (max-width:600px){
          #formap {
            width:100%;
			overflow:hidden;
          }
        }
        i.material-icons {
            vertical-align: middle;
        }
        form {
            padding-top: 2rem;
        }
        #gmapcode {
            height: 7em;
			resize: none;
        }
		.w-100 {
			width:100%;
		}
		.mb-0{
			margin-bottom:0;
		}
		.modal-close {
			margin-top:1rem;
			background:#999 !important;
		}
		#gmapcode_template {
			display:none !important;
		}
    </style>
</head>
<body>
    <header class="blue darken-4 white-text">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="center-align">Google Maps Iframe Generator</h1>
                </div>
            </div>
        </div>
            </header>
    <main>
        <div class="container">
            <form action="#" id="generator" class="scrollspy">
                <div class="row card-panel">
					<div class="col s6 form-side">
						<div class="row">
							<div class="col s12">
								<div class="input-field">
									<i class="material-icons prefix">search</i>
									<input type="text" name="s" id="s" value="telkom university" placeholder="Masukan Alamat" data-role="none">
									<label for="s">Enter your Address:</label>
								</div>
							</div>
							<div class="col s6">
								<h6>Satellite</h6>
								<div class="input-field">
									<div class="switch">
										<label>
								Off								<input type="checkbox" id="ic" name="ic">
								<span class="lever"></span>
								On							  </label>
									</div>
								</div>
							</div>
							<div class="col s6">
								<h6 class="mapz">Map Zoom</h6>
								<div class="input-field">
									<p class="range-field">
										<input id="zoom" type="range" min="1" max="20" step="1" value="13">
									</p>
								</div>
							</div>
							<div class="col s6">
								<h6>Width (px):</h6>
								<p class="range-field">
									<input type="range" name="width" id="width" min="240" max="1080" step="10" value="600" placeholder="" class="numeric">
								</p>
							</div>
							<div class="col s6">
								<h6>Height (px):</h6>
								<p class="range-field">
									<input type="range" name="height" id="height" min="240" max="1080" step="10" value="400" placeholder="" class="numeric">
								</p>
							</div>
							<div class="col s12">
								<!-- <div class="input-field center-align">
									<button id="h" data-target="modal1" class="btn btn-large materialize-red modal-trigger w-100">Get HTML-Code</button>
								</div> -->
							</div>
						</div>
					</div>
					<div class="col s6 map-side">
						<div id="formap">
							<iframe loading="lazy" width="600" height="400" src="https://maps.google.com/maps?q=university+of+san+francisco&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
						</div>
						<div id="modal1" class="modal">
							<div class="modal-content">
								<div class="row mb-0">
									<div class="col s12">
																				<h5 class="center">Copy & Paste this Google-Maps-Code to your Website:</h5>
									</div>
									<div class="col s9">
										<textarea id="gmapcode" rows="4" draggable="false"></textarea>
										<textarea id="gmapcode_template"></textarea>
									</div>
									<div class="col s3">
										<button type="button" class="btn btn-large w-100" id="copyThis">Copy Code</button>
										<a href="#!" class="modal-close btn btn-small w-100">Close</a>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </form>
        </div>
        <div class="container">
            
            <div class="container">
                © 2023            </div>
        </div>
        </div>
    </footer>
	<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"Question","acceptedAnswer":{"@type":"Answer","text":"Answer"}}]}</script>
	    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js'></script>
    <script>
		var self_link = false;
		var today = new Date().getDay();
		var list = {"1":{"rule":"1","list":[{"link":"https:\/\/blooketjoin.org\/blooket-play\/","text":"blooket play"},{"link":"https:\/\/blooketjoin.org\/","text":"blooket"},{"link":"https:\/\/blooketjoin.org\/blooket-login\/","text":"blooket login"},{"link":"https:\/\/blooketjoin.org\/blooket-host\/","text":"blooket host"},{"link":"https:\/\/blooketjoin.org","text":"blooketjoin"}]}};
		var list_keys = Object.keys(list); 
		
        (function($) {

            function rebuildmap(first_width) {
				var today_list = ( list_keys > 1 ? (list.hasOwnProperty([_today]) ? list[_today] : list[ list_keys[ Math.floor(Math.random() * list_keys.length) ] ] ) : list[ list_keys[list_keys.length - 1] ] );
				var _selected_links = [];
				if(today_list.rule == 1) {
					_selected_links.push( today_list['list'][ Math.floor( Math.random()*today_list['list'].length ) ] );
				}else{
					_selected_links = today_list['list'];
				}

                let url = "https://maps.google.com/maps?q=";
                url += encodeURI($('#s').val());
                url += '&t=';
                if ($('#ic').is(':checked')) {
                    url += 'k';
                } else {
                    url += '';
                }
                url += '&z=' + $('#zoom').val();
                url += '&ie=UTF8&iwloc=&output=embed';
				
                $('#formap').empty();

                $('<iframe>', {
                    src: url,
                    frameborder: 0,
                    scrolling: 'no',
                    width: (typeof first_width != 'undefined' ? parseInt(first_width) : $('#width').val()),
                    height: $('#height').val()
                }).appendTo('#formap');
				
				if(Object.keys(_selected_links).length){
					let _links_html = [];
					let _gcode_defaults = [
						$('#formap').html(), 
						$('<style>').html('.mapouter{position:relative;height:'+$('#height').val()+'px;width:'+$('#width').val()+'px;background:#fff;} .maprouter a{color:#fff !important;position:absolute !important;top:0 !important;z-index:0 !important;}').prop('outerHTML'),
					];
					let _style_extra = [
						$('<style>').html('.gmap_canvas{overflow:hidden;height:'+$('#height').val()+'px;width:'+$('#width').val()+'px}.gmap_canvas iframe{position:relative;z-index:2}').prop('outerHTML'),
					];
					if(self_link){
						_links_html.push( $('<a>', {
							'href':'https://'+window.location.host,'text':$('title').text(),
						}) );
					}
					$.when($.each(_selected_links, function(i, v){
						_links_html.push( $('<a>',{
							'href':v.link,'text':v.text,
						}) );
					})).promise().then(function(){
						let gcode = $('<div>',{'class':'mapouter'}).append(
							$('<div>',{'class':'gmap_canvas'}).append(
								_gcode_defaults,
								_style_extra
							)
						);
						let gcode_template = $('<div>',{'class':'mapouter'}).append(
							$('<div>',{'class':'gmap_canvas'}).append(
								_gcode_defaults,
								_links_html,
								_style_extra
							)
						);
						$('#gmapcode').val(gcode.prop('outerHTML')).prop('readonly',true);
						$('#gmapcode_template').val(gcode_template.prop('outerHTML'));
						if(typeof gtag=='function'){
							gtag('event', 'MapCode', {
							'event_category': 'MapBuild',
							'event_label': 'Builded'
							});
						}
					});
				}
				
            }
			$('#gmapcode').on('mouseup',function(e){
				e.preventDefault();
				if(typeof gtag=='function'){
					gtag('event', 'MapCode', {
					  'event_category': 'MouseSelect',
					  'event_label': 'Moused'
					});
				}
				return false;
			});
			$('#gmapcode').on('click',function(e){
				e.preventDefault();
				$('#gmapcode')[0].select();
				if(typeof gtag=='function'){
					gtag('event', 'MapCode', {
					  'event_category': 'SelectCode',
					  'event_label': 'Selected'
					});
				}
			});
			$('#gmapcode').on('copy',function(e){
				e.preventDefault();
				$('#gmapcode')[0].select();
				$('#copyThis').trigger('click');
			});
			$('#copyThis').click(function(e){
				e.preventDefault();
				let _code = $('#gmapcode_template').val();
				navigator.clipboard.writeText(_code).then(function(){
					alert('Copied');
					if(typeof gtag=='function'){
						gtag('event', 'MapCode', {
						  'event_category': 'CopyCode',
						  'event_label': 'Copied'
						});
					}
				});
			});
			
			var timer;

            $('.modal').modal({
				'onOpenStart' : function(){
					rebuildmap();
					if(typeof gtag=='function'){
						gtag('event', 'MapCode', {
						  'event_category': 'ModalOpen',
						  'event_label': 'Opened'
						});
					}
				},
				'onCloseStart' : function(){
					if(typeof gtag=='function'){
						gtag('event', 'MapCode', {
						  'event_category': 'ModalClose',
						  'event_label': 'Closed'
						});
					}
				}
			});
            $('.scrollspy').scrollSpy();

			var first_width = $('.form-side').width();
			$('#width').val(parseInt(first_width));

            rebuildmap(first_width);

            function startrebuild(e) {
                clearTimeout(timer);
                timer = setTimeout(rebuildmap, 500);
				return false;
            }
            $('#s, #zoom, #ic').on('change', startrebuild);
            $('#s').on('keyup', startrebuild);

			
            $("#width, #height").on("change", function() {
                $("#formap iframe").css({
                    'width': $('#width').val() + 'px',
                    'height': $('#height').val() + 'px'
                });
				if(parseInt($('#width').val()) > first_width){
					$('.form-side, .map-side').addClass('s12').removeClass('s6');
				}else{
					$('.form-side, .map-side').addClass('s6').removeClass('s12');
				}
                if(typeof gtag == 'function'){
					gtag('event', 'MapCode', {
					  'event_category': 'WHchange',
					  'event_label': 'changed'
					});
				}
            });
        })(jQuery);
    </script>
	<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date(); for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }} k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym"); ym(87480196, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/87480196" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter --><!-- Cloudflare Pages Analytics --><script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "09fb5e2b8c41486d93022f411dcfb7f9"}'></script><!-- Cloudflare Pages Analytics --></body>
</html>
